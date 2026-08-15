<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreConsultationRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
                        'patient_id' => 'required|exists:patients,id',
            'doctor_id' => 'required|exists:users,id',
            'consultation_date' => 'required|date',
            'symptoms' => 'nullable|string|max:1000',
            'diagnosis' => 'nullable|string|max:1000',
            'clinical_notes' => 'nullable|string|max:2000',
            'treatment_plan' => 'nullable|string|max:1000',
            'advice' => 'nullable|string|max:500',
            'follow_up_date' => 'nullable|date|after:consultation_date',
            
            // Vitals
            'weight' => 'nullable|numeric|min:1|max:500',
            'height' => 'nullable|numeric|min:1|max:300',
            'systolic_bp' => 'nullable|integer|min:60|max:300',
            'diastolic_bp' => 'nullable|integer|min:30|max:200',
            'temperature' => 'nullable|numeric|min:30|max:45',
            'pulse_rate' => 'nullable|integer|min:20|max:300',
            'respiratory_rate' => 'nullable|integer|min:4|max:100',
            'blood_sugar' => 'nullable|numeric|min:10|max:600',
            
            // Prescriptions
            'prescriptions' => 'nullable|array',
            'prescriptions.*.drug_name' => 'required_with:prescriptions|string|max:255',
            'prescriptions.*.dosage' => 'required_with:prescriptions|string|max:100',
            'prescriptions.*.frequency' => 'required_with:prescriptions|string|max:100',
            'prescriptions.*.duration' => 'required_with:prescriptions|string|max:100',
            'prescriptions.*.instructions' => 'nullable|string|max:500',
            
            // Investigations
            'investigations' => 'nullable|array',
            'investigations.*.investigation_name' => 'required_with:investigations|string|max:255',
            'investigations.*.type' => 'required_with:investigations|in:pathology,radiology,other',
            'investigations.*.instructions' => 'nullable|string|max:500',
        ];
    }

    public function messages()
    {
        return [
            'patient_id.required' => 'Please select a patient.',
            'patient_id.exists' => 'Selected patient does not exist.',
            'doctor_id.required' => 'Please select a doctor.',
            'consultation_date.required' => 'Consultation date is required.',
            'follow_up_date.after' => 'Follow-up date must be after consultation date.',
        ];
    }
}
