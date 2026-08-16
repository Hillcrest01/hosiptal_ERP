<?php

namespace App\Http\Controllers;

use App\Services\ConsultationService;
use App\Http\Requests\StoreConsultationRequest;
use App\Models\Consultation;
use App\Models\Patient;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;

class ConsultationsController extends Controller
{
    protected $consultationService;

    public function __construct(ConsultationService $consultationService)
    {
        $this->consultationService = $consultationService;
    }

        public function index(Request $request)
    {
        $status = $request->get('status', 'active');
        
        if ($status === 'all') {
            $consultations = Consultation::with(['patient', 'doctor'])
                ->latest('consultation_date')
                ->paginate(15);
        } elseif ($status === 'active') {
            $consultations = $this->consultationService->getActiveConsultations();
        } elseif ($status === 'today') {
            $consultations = $this->consultationService->getTodayConsultations();
            return view('consultations.today', compact('consultations'));
        } else {
            $consultations = Consultation::with(['patient', 'doctor'])
                ->where('status', $status)
                ->latest('consultation_date')
                ->paginate(15);
        }

        $stats = $this->consultationService->getConsultationStats();

        return view('consultations.index', compact('consultations', 'stats', 'status'));
    }

    public function create()
    {
        $patients = Patient::active()->orderBy('first_name')->get();
        // $doctors = User::whereHas('roles', function($query) {
        //     $query->where('name', 'doctor');
        // })->get();
        $doctors = User::orderBy('name')->get();

        return view('consultations.create', compact('patients', 'doctors'));
    }

    public function store(StoreConsultationRequest $request)
    {
         $validated = $request->validated();
        // dd($validated);
        // Check if the data is being received
        if (empty($validated)) {
            return back()->withInput()->with('error', 'No data received. Please check your form.');
        }
        try {
            $consultation = $this->consultationService->createConsultation($request->validated());
            return redirect()->route('consultations.show', $consultation->id)
                ->with('success', 'Consultation created successfully.');
        } catch (Exception $e) {
            return back()->withInput()->with('error', $e->getMessage());
        }
    }

    public function show(Consultation $consultation)
    {
        $consultation->load(['patient', 'doctor', 'vitals', 'prescriptions', 'investigationOrders', 'notes.user']);
        return view('consultations.show', compact('consultation'));
    }

    public function edit(Consultation $consultation)
    {
        $consultation->load(['vitals', 'prescriptions', 'investigationOrders']);
        $patients = Patient::active()->orderBy('first_name')->get();
        $doctors = User::whereHas('roles', function($query) {
            $query->where('name', 'doctor');
        })->get();

        return view('consultations.edit', compact('consultation', 'patients', 'doctors'));
    }

    public function update(StoreConsultationRequest $request, Consultation $consultation)
    {
        try {
            $consultation = $this->consultationService->updateConsultation($consultation, $request->validated());
            return redirect()->route('consultations.show', $consultation->id)
                ->with('success', 'Consultation updated successfully.');
        } catch (\Exception $e) {
            return back()->withInput()->with('error', $e->getMessage());
        }
    }

    public function complete(Consultation $consultation)
    {
        try {
            $this->consultationService->completeConsultation($consultation);
            return redirect()->route('consultations.show', $consultation->id)
                ->with('success', 'Consultation marked as completed.');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function cancel(Consultation $consultation, Request $request)
    {
        try {
            $this->consultationService->cancelConsultation($consultation, $request->get('reason'));
            return redirect()->route('consultations.index')
                ->with('success', 'Consultation cancelled successfully.');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function patientHistory(Patient $patient)
    {
        $consultations = $this->consultationService->getConsultationsForPatient($patient->id);
        return view('consultations.patient-history', compact('patient', 'consultations'));
    }

    public function prescriptionPrint(Consultation $consultation)
    {
        $consultation->load(['patient', 'doctor', 'prescriptions']);
        return view('consultations.prescription-print', compact('consultation'));
    }
}
