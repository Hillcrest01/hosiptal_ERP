<?php

namespace App\Services;

use App\Models\Patient;
use Illuminate\Validation\ValidationException;

class PatientService
{

    //function to register patients
    public function register(array $data): Patient
    {
        // dd($data);
        $existing = Patient::where('phone', $data['phone'])->first();
        if ($existing) {
            throw ValidationException::withMessages([
                'phone' => 'A patient with this phone number already exists. UHID: ' . $existing->uhid,
            ]);
        }
        if (!empty($data['email'])) {
            $existingEmail = Patient::where('email', $data['email'])->first();
            if ($existingEmail) {
                throw ValidationException::withMessages([
                    'email' => 'A patient with this email address exists , UHID' . $existing->uhid,
                ]);
            }
        }

        $data['uhid'] = $this->generateUHID();

        return Patient::create($data);
    }

    private function generateUHID()
    {
        $prefix = now()->format('ymd');
        $lastPatient = Patient::withTrashed()->latest('id')->first();
        $sequence = $lastPatient ? $lastPatient->id + 1 : 1;
        $suffix = str_pad($sequence, 4, '0', STR_PAD_LEFT);
        return $prefix . '-' . $suffix;
    }

    public function searchPatients(string $search)
    {
        return Patient::search($search)->paginate(15);
    }

    public function getPatientByUhid(string $uhid): ?Patient
    {
        Patient::where('uhid', $uhid)->first();
    }
    public function updatePatient(Patient $patient, array $data): Patient
    {
        if (isset($data['phone'])) {
            $patientExist = Patient::where('phone', $data['phone'])->where('id', '!=', $patient->id)->first();
            if ($patientExist) {
                throw ValidationException::withMessages([
                    'phone' => 'This phone number is already registered to another patient.'
                ]);

            }

        }
        $patient->update($data);
        return $patient->fresh();
    }

    public function deletePatient(Patient $patient): void
    {
        $patient->delete();
    }
    public function getRecentPatients()
    {
        return Patient::latest()->limit(5)->get();
    }

    public function getTotalPatientCount(): int
    {
        return Patient::count();
    }
}
