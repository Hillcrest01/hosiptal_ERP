@extends('layouts.admin')

@section('title', 'New Consultation')
@section('page-title', 'New Consultation')
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('consultations.index') }}">Consultations</a></li>
    <li class="breadcrumb-item active">New</li>
@endsection

@section('content')
<div class="card">
    <div class="card-header">
        <i class="fas fa-stethoscope mr-2"></i> Start New Consultation
    </div>
    <div class="card-body">
        <form action="{{ route('consultations.store') }}" method="POST" id="consultationForm">
            @csrf

            <!-- Patient & Doctor Selection -->
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="patient_id" class="form-label">Patient <span class="text-danger">*</span></label>
                        <select name="patient_id" id="patient_id" class="form-control @error('patient_id') is-invalid @enderror" required>
                            <option value="">Select Patient</option>
                            @foreach($patients as $patient)
                                <option value="{{ $patient->id }}" {{ old('patient_id') == $patient->id ? 'selected' : '' }}>
                                    {{ $patient->full_name }} ({{ $patient->uhid }})
                                </option>
                            @endforeach
                        </select>
                        @error('patient_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="doctor_id" class="form-label">Doctor <span class="text-danger">*</span></label>
                        <select name="doctor_id" id="doctor_id" class="form-control @error('doctor_id') is-invalid @enderror" required>
                            <option value="">Select Doctor</option>
                            @foreach($doctors as $doctor)
                                <option value="{{ $doctor->id }}" {{ old('doctor_id') == $doctor->id ? 'selected' : '' }}>
                                    {{ $doctor->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('doctor_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="consultation_date" class="form-label">Consultation Date & Time <span class="text-danger">*</span></label>
                        <input type="datetime-local" name="consultation_date" id="consultation_date" 
                               class="form-control @error('consultation_date') is-invalid @enderror" 
                               value="{{ old('consultation_date', now()->format('Y-m-d\TH:i')) }}" required>
                        @error('consultation_date')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="follow_up_date" class="form-label">Follow-up Date</label>
                        <input type="date" name="follow_up_date" id="follow_up_date" 
                               class="form-control @error('follow_up_date') is-invalid @enderror" 
                               value="{{ old('follow_up_date') }}">
                        @error('follow_up_date')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Symptoms & Diagnosis -->
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="symptoms" class="form-label">Symptoms</label>
                        <textarea name="symptoms" id="symptoms" rows="3" 
                                  class="form-control @error('symptoms') is-invalid @enderror">{{ old('symptoms') }}</textarea>
                        @error('symptoms')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="diagnosis" class="form-label">Diagnosis</label>
                        <textarea name="diagnosis" id="diagnosis" rows="3" 
                                  class="form-control @error('diagnosis') is-invalid @enderror">{{ old('diagnosis') }}</textarea>
                        @error('diagnosis')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="clinical_notes" class="form-label">Clinical Notes</label>
                        <textarea name="clinical_notes" id="clinical_notes" rows="3" 
                                  class="form-control @error('clinical_notes') is-invalid @enderror">{{ old('clinical_notes') }}</textarea>
                        @error('clinical_notes')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="treatment_plan" class="form-label">Treatment Plan</label>
                        <textarea name="treatment_plan" id="treatment_plan" rows="3" 
                                  class="form-control @error('treatment_plan') is-invalid @enderror">{{ old('treatment_plan') }}</textarea>
                        @error('treatment_plan')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="advice" class="form-label">Advice to Patient</label>
                        <textarea name="advice" id="advice" rows="3" 
                                  class="form-control @error('advice') is-invalid @enderror">{{ old('advice') }}</textarea>
                        @error('advice')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Vitals -->
            <div class="card mt-4">
                <div class="card-header">
                    <i class="fas fa-heartbeat mr-2"></i> Vitals
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="weight" class="form-label">Weight (kg)</label>
                                <input type="number" step="0.01" name="weight" id="weight" 
                                       class="form-control @error('weight') is-invalid @enderror" 
                                       value="{{ old('weight') }}">
                                @error('weight')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="height" class="form-label">Height (cm)</label>
                                <input type="number" step="0.01" name="height" id="height" 
                                       class="form-control @error('height') is-invalid @enderror" 
                                       value="{{ old('height') }}">
                                @error('height')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="systolic_bp" class="form-label">Systolic BP</label>
                                <input type="number" name="systolic_bp" id="systolic_bp" 
                                       class="form-control @error('systolic_bp') is-invalid @enderror" 
                                       value="{{ old('systolic_bp') }}" placeholder="e.g. 120">
                                @error('systolic_bp')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="diastolic_bp" class="form-label">Diastolic BP</label>
                                <input type="number" name="diastolic_bp" id="diastolic_bp" 
                                       class="form-control @error('diastolic_bp') is-invalid @enderror" 
                                       value="{{ old('diastolic_bp') }}" placeholder="e.g. 80">
                                @error('diastolic_bp')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="temperature" class="form-label">Temperature (°C)</label>
                                <input type="number" step="0.1" name="temperature" id="temperature" 
                                       class="form-control @error('temperature') is-invalid @enderror" 
                                       value="{{ old('temperature') }}">
                                @error('temperature')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="pulse_rate" class="form-label">Pulse Rate (bpm)</label>
                                <input type="number" name="pulse_rate" id="pulse_rate" 
                                       class="form-control @error('pulse_rate') is-invalid @enderror" 
                                       value="{{ old('pulse_rate') }}">
                                @error('pulse_rate')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="respiratory_rate" class="form-label">Respiratory Rate</label>
                                <input type="number" name="respiratory_rate" id="respiratory_rate" 
                                       class="form-control @error('respiratory_rate') is-invalid @enderror" 
                                       value="{{ old('respiratory_rate') }}">
                                @error('respiratory_rate')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="blood_sugar" class="form-label">Blood Sugar (mg/dL)</label>
                                <input type="number" step="0.01" name="blood_sugar" id="blood_sugar" 
                                       class="form-control @error('blood_sugar') is-invalid @enderror" 
                                       value="{{ old('blood_sugar') }}">
                                @error('blood_sugar')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Prescriptions -->
            <div class="card mt-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <span><i class="fas fa-prescription mr-2"></i> Prescriptions</span>
                    <button type="button" class="btn btn-sm btn-primary" onclick="addPrescription()">
                        <i class="fas fa-plus mr-1"></i> Add Medicine
                    </button>
                </div>
                <div class="card-body">
                    <div id="prescriptions-container">
                        <div class="prescription-row row mb-3">
                            <div class="col-md-3">
                                <input type="text" name="prescriptions[0][drug_name]" class="form-control" placeholder="Medicine Name">
                            </div>
                            <div class="col-md-2">
                                <input type="text" name="prescriptions[0][dosage]" class="form-control" placeholder="Dosage">
                            </div>
                            <div class="col-md-2">
                                <input type="text" name="prescriptions[0][frequency]" class="form-control" placeholder="Frequency">
                            </div>
                            <div class="col-md-2">
                                <input type="text" name="prescriptions[0][duration]" class="form-control" placeholder="Duration">
                            </div>
                            <div class="col-md-2">
                                <input type="text" name="prescriptions[0][instructions]" class="form-control" placeholder="Instructions">
                            </div>
                            <div class="col-md-1">
                                <button type="button" class="btn btn-sm btn-danger" onclick="removePrescription(this)">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                    <small class="text-muted">Leave empty if no prescriptions</small>
                </div>
            </div>

            <!-- Investigations -->
            <div class="card mt-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <span><i class="fas fa-flask mr-2"></i> Investigations</span>
                    <button type="button" class="btn btn-sm btn-primary" onclick="addInvestigation()">
                        <i class="fas fa-plus mr-1"></i> Add Investigation
                    </button>
                </div>
                <div class="card-body">
                    <div id="investigations-container">
                        <div class="investigation-row row mb-3">
                            <div class="col-md-5">
                                <input type="text" name="investigations[0][investigation_name]" class="form-control" placeholder="Investigation Name">
                            </div>
                            <div class="col-md-3">
                                <select name="investigations[0][type]" class="form-control">
                                    <option value="pathology">Pathology</option>
                                    <option value="radiology">Radiology</option>
                                    <option value="other">Other</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <input type="text" name="investigations[0][instructions]" class="form-control" placeholder="Instructions">
                            </div>
                            <div class="col-md-1">
                                <button type="button" class="btn btn-sm btn-danger" onclick="removeInvestigation(this)">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                    <small class="text-muted">Leave empty if no investigations</small>
                </div>
            </div>

            <div class="form-group mt-4">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save mr-2"></i> Start Consultation
                </button>
                <a href="{{ route('consultations.index') }}" class="btn btn-secondary">
                    <i class="fas fa-times mr-2"></i> Cancel
                </a>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
    let prescriptionIndex = 1;
    let investigationIndex = 1;

    function addPrescription() {
        const container = document.getElementById('prescriptions-container');
        const row = document.createElement('div');
        row.className = 'prescription-row row mb-3';
        row.innerHTML = `
            <div class="col-md-3">
                <input type="text" name="prescriptions[${prescriptionIndex}][drug_name]" class="form-control" placeholder="Medicine Name">
            </div>
            <div class="col-md-2">
                <input type="text" name="prescriptions[${prescriptionIndex}][dosage]" class="form-control" placeholder="Dosage">
            </div>
            <div class="col-md-2">
                <input type="text" name="prescriptions[${prescriptionIndex}][frequency]" class="form-control" placeholder="Frequency">
            </div>
            <div class="col-md-2">
                <input type="text" name="prescriptions[${prescriptionIndex}][duration]" class="form-control" placeholder="Duration">
            </div>
            <div class="col-md-2">
                <input type="text" name="prescriptions[${prescriptionIndex}][instructions]" class="form-control" placeholder="Instructions">
            </div>
            <div class="col-md-1">
                <button type="button" class="btn btn-sm btn-danger" onclick="removePrescription(this)">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        `;
        container.appendChild(row);
        prescriptionIndex++;
    }

    function removePrescription(button) {
        const row = button.closest('.prescription-row');
        if (document.querySelectorAll('.prescription-row').length > 1) {
            row.remove();
        } else {
            alert('At least one prescription row is required.');
        }
    }

    function addInvestigation() {
        const container = document.getElementById('investigations-container');
        const row = document.createElement('div');
        row.className = 'investigation-row row mb-3';
        row.innerHTML = `
            <div class="col-md-5">
                <input type="text" name="investigations[${investigationIndex}][investigation_name]" class="form-control" placeholder="Investigation Name">
            </div>
            <div class="col-md-3">
                <select name="investigations[${investigationIndex}][type]" class="form-control">
                    <option value="pathology">Pathology</option>
                    <option value="radiology">Radiology</option>
                    <option value="other">Other</option>
                </select>
            </div>
            <div class="col-md-3">
                <input type="text" name="investigations[${investigationIndex}][instructions]" class="form-control" placeholder="Instructions">
            </div>
            <div class="col-md-1">
                <button type="button" class="btn btn-sm btn-danger" onclick="removeInvestigation(this)">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        `;
        container.appendChild(row);
        investigationIndex++;
    }

    function removeInvestigation(button) {
        const row = button.closest('.investigation-row');
        if (document.querySelectorAll('.investigation-row').length > 1) {
            row.remove();
        } else {
            alert('At least one investigation row is required.');
        }
    }

    // Auto-calculate BMI (optional enhancement)
    document.getElementById('weight').addEventListener('input', calculateBMI);
    document.getElementById('height').addEventListener('input', calculateBMI);

    function calculateBMI() {
        const weight = parseFloat(document.getElementById('weight').value);
        const height = parseFloat(document.getElementById('height').value);
        if (weight && height && height > 0) {
            const heightInMeters = height / 100;
            const bmi = weight / (heightInMeters * heightInMeters);
            // Display BMI if you want to add a field
            console.log('BMI:', bmi.toFixed(2));
        }
    }
</script>
@endpush
@endsection