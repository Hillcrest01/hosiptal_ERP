@extends('layouts.admin')

@section('title', 'Edit Consultation')
@section('page-title', 'Edit Consultation')
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('consultations.index') }}">Consultations</a></li>
    <li class="breadcrumb-item"><a href="{{ route('consultations.show', $consultation->id) }}">Details</a></li>
    <li class="breadcrumb-item active">Edit</li>
@endsection

@section('content')
<div class="card">
    <div class="card-header">
        <i class="fas fa-edit mr-2"></i> Edit Consultation for {{ $consultation->patient->full_name ?? 'N/A' }}
    </div>
    <div class="card-body">
        <form action="{{ route('consultations.update', $consultation->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="patient_id" class="form-label">Patient <span class="text-danger">*</span></label>
                        <select name="patient_id" id="patient_id" class="form-control @error('patient_id') is-invalid @enderror" required>
                            <option value="">Select Patient</option>
                            @foreach($patients as $patient)
                                <option value="{{ $patient->id }}" {{ old('patient_id', $consultation->patient_id) == $patient->id ? 'selected' : '' }}>
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
                                <option value="{{ $doctor->id }}" {{ old('doctor_id', $consultation->doctor_id) == $doctor->id ? 'selected' : '' }}>
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
                               value="{{ old('consultation_date', $consultation->consultation_date->format('Y-m-d\TH:i')) }}" required>
                        @error('consultation_date')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="status" class="form-label">Status</label>
                        <select name="status" id="status" class="form-control @error('status') is-invalid @enderror">
                            <option value="active" {{ old('status', $consultation->status) == 'active' ? 'selected' : '' }}>Active</option>
                            <option value="completed" {{ old('status', $consultation->status) == 'completed' ? 'selected' : '' }}>Completed</option>
                            <option value="cancelled" {{ old('status', $consultation->status) == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                        </select>
                        @error('status')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="follow_up_date" class="form-label">Follow-up Date</label>
                        <input type="date" name="follow_up_date" id="follow_up_date" 
                               class="form-control @error('follow_up_date') is-invalid @enderror" 
                               value="{{ old('follow_up_date', $consultation->follow_up_date ? $consultation->follow_up_date->format('Y-m-d') : '') }}">
                        @error('follow_up_date')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="symptoms" class="form-label">Symptoms</label>
                        <textarea name="symptoms" id="symptoms" rows="3" 
                                  class="form-control @error('symptoms') is-invalid @enderror">{{ old('symptoms', $consultation->symptoms) }}</textarea>
                        @error('symptoms')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="diagnosis" class="form-label">Diagnosis</label>
                        <textarea name="diagnosis" id="diagnosis" rows="3" 
                                  class="form-control @error('diagnosis') is-invalid @enderror">{{ old('diagnosis', $consultation->diagnosis) }}</textarea>
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
                                  class="form-control @error('clinical_notes') is-invalid @enderror">{{ old('clinical_notes', $consultation->clinical_notes) }}</textarea>
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
                                  class="form-control @error('treatment_plan') is-invalid @enderror">{{ old('treatment_plan', $consultation->treatment_plan) }}</textarea>
                        @error('treatment_plan')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="advice" class="form-label">Advice to Patient</label>
                        <textarea name="advice" id="advice" rows="3" 
                                  class="form-control @error('advice') is-invalid @enderror">{{ old('advice', $consultation->advice) }}</textarea>
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
                                       class="form-control" value="{{ old('weight', $consultation->vitals->weight ?? '') }}">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="height" class="form-label">Height (cm)</label>
                                <input type="number" step="0.01" name="height" id="height" 
                                       class="form-control" value="{{ old('height', $consultation->vitals->height ?? '') }}">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="systolic_bp" class="form-label">Systolic BP</label>
                                <input type="number" name="systolic_bp" id="systolic_bp" 
                                       class="form-control" value="{{ old('systolic_bp', $consultation->vitals->systolic_bp ?? '') }}" placeholder="e.g. 120">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="diastolic_bp" class="form-label">Diastolic BP</label>
                                <input type="number" name="diastolic_bp" id="diastolic_bp" 
                                       class="form-control" value="{{ old('diastolic_bp', $consultation->vitals->diastolic_bp ?? '') }}" placeholder="e.g. 80">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="temperature" class="form-label">Temperature (°C)</label>
                                <input type="number" step="0.1" name="temperature" id="temperature" 
                                       class="form-control" value="{{ old('temperature', $consultation->vitals->temperature ?? '') }}">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="pulse_rate" class="form-label">Pulse Rate (bpm)</label>
                                <input type="number" name="pulse_rate" id="pulse_rate" 
                                       class="form-control" value="{{ old('pulse_rate', $consultation->vitals->pulse_rate ?? '') }}">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="respiratory_rate" class="form-label">Respiratory Rate</label>
                                <input type="number" name="respiratory_rate" id="respiratory_rate" 
                                       class="form-control" value="{{ old('respiratory_rate', $consultation->vitals->respiratory_rate ?? '') }}">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="blood_sugar" class="form-label">Blood Sugar (mg/dL)</label>
                                <input type="number" step="0.01" name="blood_sugar" id="blood_sugar" 
                                       class="form-control" value="{{ old('blood_sugar', $consultation->vitals->blood_sugar ?? '') }}">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="form-group mt-4">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save mr-2"></i> Update Consultation
                </button>
                <a href="{{ route('consultations.show', $consultation->id) }}" class="btn btn-secondary">
                    <i class="fas fa-times mr-2"></i> Cancel
                </a>
            </div>
        </form>
    </div>
</div>
@endsection