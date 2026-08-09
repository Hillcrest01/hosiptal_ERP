@extends('layouts.admin')

@section('title', 'Patient Details')
@section('page-title', 'Patient Details')
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('patients.index') }}">Patients</a></li>
    <li class="breadcrumb-item active">{{ $patient->full_name }}</li>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    Patient Information
                </div>
                <div class="card-body text-center">
                    <div class="mb-3">
                        <i class="fas fa-user-circle fa-5x text-secondary"></i>
                    </div>
                    <h5>{{ $patient->full_name }}</h5>
                    <p class="text-muted">UHID: <strong>{{ $patient->uhid }}</strong></p>
                    <hr>
                    <div class="text-left">
                        <p><strong>Gender:</strong> <span class="text-capitalize">{{ $patient->gender }}</span></p>
                        <p><strong>Date of Birth:</strong> {{ $patient->date_of_birth->format('d M Y') }}</p>
                        <p><strong>Age:</strong> {{ $patient->age }} years</p>
                        <p><strong>Blood Group:</strong> {{ $patient->blood_group ?? 'Not specified' }}</p>
                        <p><strong>Phone:</strong> {{ $patient->phone }}</p>
                        @if($patient->email)
                            <p><strong>Email:</strong> {{ $patient->email }}</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-8">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <span>Complete Profile</span>
                    <div>
                        <a href="{{ route('patients.edit', $patient->id) }}" class="btn btn-primary btn-sm">
                            <i class="fas fa-edit mr-2"></i> Edit
                        </a>
                        <form action="{{ route('patients.destroy', $patient->id) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this patient?')">
                                <i class="fas fa-trash mr-2"></i> Delete
                            </button>
                        </form>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <h6 class="text-muted">Address</h6>
                            <p>{{ $patient->address ?? 'Not provided' }}</p>
                            @if($patient->city || $patient->state || $patient->postal_code)
                                <p class="text-muted small">
                                    {{ $patient->city }}{{ $patient->city && $patient->state ? ', ' : '' }}
                                    {{ $patient->state }} {{ $patient->postal_code }}
                                </p>
                            @endif
                        </div>
                        <div class="col-md-6">
                            <h6 class="text-muted">Emergency Contact</h6>
                            <p><strong>Name:</strong> {{ $patient->emergency_contact_name ?? 'Not provided' }}</p>
                            <p><strong>Phone:</strong> {{ $patient->emergency_contact_phone ?? 'Not provided' }}</p>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <h6 class="text-muted">Medical History</h6>
                            <p>{{ $patient->medical_history ?? 'No medical history recorded' }}</p>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <h6 class="text-muted">Allergies</h6>
                            <p>{{ $patient->allergies ?? 'No allergies recorded' }}</p>
                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="col-md-12">
                            <small class="text-muted">
                                Registered: {{ $patient->created_at->format('d M Y h:i A') }}
                            </small>
                            @if($patient->updated_at && $patient->updated_at != $patient->created_at)
                                <br>
                                <small class="text-muted">
                                    Last Updated: {{ $patient->updated_at->format('d M Y h:i A') }}
                                </small>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <div class="card mt-3">
                <div class="card-header">
                    Quick Actions
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3 col-6 mb-2">
                            <a href="#" class="btn btn-outline-primary w-100">
                                <i class="fas fa-stethoscope d-block mb-1"></i>
                                Consultation
                            </a>
                        </div>
                        <div class="col-md-3 col-6 mb-2">
                            <a href="#" class="btn btn-outline-success w-100">
                                <i class="fas fa-flask d-block mb-1"></i>
                                Lab Tests
                            </a>
                        </div>
                        <div class="col-md-3 col-6 mb-2">
                            <a href="#" class="btn btn-outline-warning w-100">
                                <i class="fas fa-prescription-bottle d-block mb-1"></i>
                                Pharmacy
                            </a>
                        </div>
                        <div class="col-md-3 col-6 mb-2">
                            <a href="#" class="btn btn-outline-danger w-100">
                                <i class="fas fa-file-invoice d-block mb-1"></i>
                                Billing
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection