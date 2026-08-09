<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePatientRequest;
use App\Models\Patient;
use App\Services\PatientService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class PatientController extends Controller
{
    protected $patientService;

    public function __construct(PatientService $patientService)
    {
        $this->patientService = $patientService;
    }

    public function index(REQUEST $request)
    {
        if ($request->has('search')) {
            $patients = $this->patientService->searchPatients($request->search);
        } else {
            $patients = Patient::latest()->paginate(15);
        }

        $data = [
            'patients' => $patients,
        ];
        return view('patients.index')->with($data);
    }

    public function create()
    {
        return view('patients.create');
    }

    public function store(StorePatientRequest $request)
    {
        
        // dd($request->validated());
        try {
            $patient = $this->patientService->register($request->validated());
            return redirect()->route('patients.show', $patient->id)->with('success', 'Patient registered successfully. UHID' . $patient->uhid);
        } catch (Exception $e) {
            // dd($e->getMessage());
            Log::error($e->getMessage());
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function show(Patient $patient)
    {
        $data = [
            'patient' => $patient,
        ];
        return view('patients.show')->with($data);
    }

    public function edit(Patient $patient)
    {
        $data = [
            'patient' => $patient,
        ];
        return view('patients.edit')->with($data);
    }

    public function update(Request $request, Patient $patient)
    {
        try {
            $patient = $this->patientService->updatePatient($patient, $request->all());
            return redirect()->route('patients.show', $patient->id)->with('success', 'Patient details successfully updated');
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function destroy(Patient $patient)
    {
        try {
            $this->patientService->deletePatient($patient);
            return redirect()->route('patients.index')->with('success', 'Successfully deleted');
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function search(Request $request)
    {
        try {
            $patients = $this->patientService->searchPatients($request->q);
            return response()->json($patients);
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

}
