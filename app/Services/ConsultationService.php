<?php

namespace App\Services;

use App\Models\Consultation;
use App\Models\InvestigationOrder;
use App\Models\Vital;
use Illuminate\Support\Facades\DB;

class ConsultationService
{
    public function createConsultation(array $data): Consultation
    {
        return DB::transaction(function () use ($data) {
            $consultation = Consultation::create([
                'patient_id' => $data['patient_id'],
                'doctor_id' => $data['doctor_id'],
                'consultation_date' => $data['consultation_date'],
                'symptoms' => $data['symptoms'] ?? null,
                'diagnosis' => $data['diagnosis'] ?? null,
                'clinical_notes' => $data['clinical_notes'] ?? null,
                'treatment_plan' => $data['treatment_plan'] ?? null,
                'advice' => $data['advice'] ?? null,
                'follow_up_date' => $data['follow_up_date'] ?? null,
                'status' => 'active'
            ]);
        

        if ($this->hasVitals($data)) {
            $vitalData = [
                'consultation_id' => $consultation->id,
                'weight' => $data['weight'] ?? null,
                'height' => $data['height'] ?? null,
                'systolic_bp' => $data['systolic_bp'] ?? null,
                'diastolic_bp' => $data['diastolic_bp'] ?? null,
                'temperature' => $data['temperature'] ?? null,
                'pulse_rate' => $data['pulse_rate'] ?? null,
                'respiratory_rate' => $data['respiratory_rate'] ?? null,
                'blood_sugar' => $data['blood_sugar'] ?? null,
            ];

            // Calculate BMI
            if (!empty($data['weight']) && !empty($data['height'])) {
                $heightInMeters = $data['height'] / 100;
                $vitalData['bmi'] = round($data['weight'] / ($heightInMeters * $heightInMeters), 2);
            }

            Vital::create($vitalData);
        }

        if (!empty($data['investigations'])) {
            foreach ($data['investigations'] as $investigationData) {
                InvestigationOrder::create([
                    'consultation_id' => $consultation->id,
                    'investigation_name' => $investigationData['investigation_name'],
                    'type' => $investigationData['type'],
                    'instructions' => $investigationData['instructions'] ?? null,
                    'status' => 'ordered'
                ]);
            }
        }
          return $consultation->load(['patient', 'doctor', 'vitals', 'prescriptions', 'investigationOrders']);
 });
    }
    private function hasVitals(array $data): bool
    {
        $vitalFields = ['weight', 'height', 'systolic_bp', 'diastolic_bp', 'temperature', 'pulse_rate', 'respiratory_rate', 'blood_sugar'];
        foreach ($vitalFields as $field) {
            if (!empty($data[$field])) {
                return true;
            }
        }
        return false;
    }

    public function updateConsultation(Consultation $consultation, array $data): Consultation
    {
        return DB::transaction(function () use ($consultation, $data) {
            $consultation->update([
                'symptoms' => $data['symptoms'] ?? $consultation->symptoms,
                'diagnosis' => $data['diagnosis'] ?? $consultation->diagnosis,
                'clinical_notes' => $data['clinical_notes'] ?? $consultation->clinical_notes,
                'treatment_plan' => $data['treatment_plan'] ?? $consultation->treatment_plan,
                'advice' => $data['advice'] ?? $consultation->advice,
                'follow_up_date' => $data['follow_up_date'] ?? $consultation->follow_up_date,
                'status' => $data['status'] ?? $consultation->status,
            ]);

            // Update vitals if provided
            if ($this->hasVitals($data) && $consultation->vitals) {
                $vitalData = [];
                $fields = ['weight', 'height', 'systolic_bp', 'diastolic_bp', 'temperature', 'pulse_rate', 'respiratory_rate', 'blood_sugar'];
                foreach ($fields as $field) {
                    if (isset($data[$field])) {
                        $vitalData[$field] = $data[$field];
                    }
                }

                // Recalculate BMI
                $weight = $vitalData['weight'] ?? $consultation->vitals->weight;
                $height = $vitalData['height'] ?? $consultation->vitals->height;
                if ($weight && $height) {
                    $heightInMeters = $height / 100;
                    $vitalData['bmi'] = round($weight / ($heightInMeters * $heightInMeters), 2);
                }

                $consultation->vitals->update($vitalData);
            }

            return $consultation->fresh(['patient', 'doctor', 'vitals', 'prescriptions', 'investigationOrders']);
        });
    }

    public function completeConsultation(Consultation $consultation): void
    {
        $consultation->update(['status' => 'completed']);
    }
    public function cancelConsultation(Consultation $consultation, string $reason = null): void
    {
        $consultation->update([
            'status' => 'cancelled',
            'clinical_notes' =>$consultation->clinical_notes. "\n\nCancelled: " . ($reason ?? 'No reason provided'),
        ]);
    }
    
    public function getConsultationsForPatient(int $patientId){
        return Consultation::with(['doctor', 'vitals','prescriptions'])->where('patient_id', $patientId)
        ->latest('consultation_date')->paginate(15);
    }

    public function getConsultationsForDoctor(int $doctorId){
        return Consultation::with(['patient', 'vitals'])->where('doctor_id', $doctorId)->latest('consultation_date')->paginate(15);
    }
    public function getTodayConsultations(){
        return Consultation::with(['doctor', 'patient'])->today()->latest('consultation_date')->get();
    }

    public function getActiveConsultations(){
        return Consultation::with(['doctor','patient'])->active()->latest('consultation_date')->paginate(15);
    }
    public function getConsultationStats(){
        return [
            'total' => Consultation::count(),
            'today' => Consultation::today()->count(),
            'active' => Consultation::active()->count(),
            'completed' => Consultation::completed()->count()
        ];
    }
}