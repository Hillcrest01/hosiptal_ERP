@extends('layouts.admin')

@section('title', 'Consultation Details')
@section('page-title', 'Consultation Details')
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('consultations.index') }}">Consultations</a></li>
    <li class="breadcrumb-item active">{{ $consultation->patient->full_name ?? 'N/A' }}</li>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-8">
            <!-- Consultation Details -->
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <span>
                        <i class="fas fa-stethoscope mr-2"></i> Consultation Details
                    </span>
                    <div>
                        @if($consultation->status == 'active')
                            <a href="{{ route('consultations.edit', $consultation->id) }}" class="btn btn-primary btn-sm">
                                <i class="fas fa-edit mr-1"></i> Edit
                            </a>
                            <form action="{{ route('consultations.complete', $consultation->id) }}" method="POST" class="d-inline">
                                @csrf
                                <button type="submit" class="btn btn-success btn-sm">
                                    <i class="fas fa-check mr-1"></i> Complete
                                </button>
                            </form>
                        @endif
                        <a href="{{ route('consultations.prescription-print', $consultation->id) }}" target="_blank" class="btn btn-info btn-sm">
                            <i class="fas fa-print mr-1"></i> Print Prescription
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <strong>Patient:</strong>
                            <a href="{{ route('patients.show', $consultation->patient_id) }}">
                                {{ $consultation->patient->full_name ?? 'N/A' }}
                            </a>
                            <span class="badge badge-secondary ml-2">{{ $consultation->patient->uhid ?? 'N/A' }}</span>
                        </div>
                        <div class="col-md-6">
                            <strong>Doctor:</strong> {{ $consultation->doctor->name ?? 'N/A' }}
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <strong>Consultation Date:</strong> {{ $consultation->formatted_date }}
                        </div>
                        <div class="col-md-6">
                            <strong>Status:</strong> {!! $consultation->status_badge !!}
                        </div>
                    </div>
                    @if($consultation->follow_up_date)
                        <div class="row mb-3">
                            <div class="col-md-12">
                                <strong>Follow-up Date:</strong> {{ $consultation->follow_up_date->format('d M Y') }}
                            </div>
                        </div>
                    @endif

                    <hr>

                    <div class="row">
                        <div class="col-md-6">
                            <h6 class="text-muted">Symptoms</h6>
                            <p>{{ $consultation->symptoms ?? 'Not recorded' }}</p>
                        </div>
                        <div class="col-md-6">
                            <h6 class="text-muted">Diagnosis</h6>
                            <p>{{ $consultation->diagnosis ?? 'Not recorded' }}</p>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <h6 class="text-muted">Clinical Notes</h6>
                            <p>{{ $consultation->clinical_notes ?? 'Not recorded' }}</p>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <h6 class="text-muted">Treatment Plan</h6>
                            <p>{{ $consultation->treatment_plan ?? 'Not recorded' }}</p>
                        </div>
                        <div class="col-md-6">
                            <h6 class="text-muted">Advice to Patient</h6>
                            <p>{{ $consultation->advice ?? 'Not recorded' }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Vitals -->
            @if($consultation->vitals)
                <div class="card mt-3">
                    <div class="card-header">
                        <i class="fas fa-heartbeat mr-2"></i> Vitals
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="text-center">
                                    <div class="text-muted small">Weight</div>
                                    <div class="h6">{{ $consultation->vitals->weight ?? 'N/A' }} kg</div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="text-center">
                                    <div class="text-muted small">Height</div>
                                    <div class="h6">{{ $consultation->vitals->height ?? 'N/A' }} cm</div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="text-center">
                                    <div class="text-muted small">BMI</div>
                                    <div class="h6">{{ $consultation->vitals->bmi ?? 'N/A' }}</div>
                                    @if($consultation->vitals->bmi)
                                        <small class="text-muted">{{ $consultation->vitals->bmi_category }}</small>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="text-center">
                                    <div class="text-muted small">Blood Pressure</div>
                                    <div class="h6">{{ $consultation->vitals->bp_reading ?? 'N/A' }}</div>
                                </div>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-md-3">
                                <div class="text-center">
                                    <div class="text-muted small">Temperature</div>
                                    <div class="h6">{{ $consultation->vitals->temperature ?? 'N/A' }} °C</div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="text-center">
                                    <div class="text-muted small">Pulse Rate</div>
                                    <div class="h6">{{ $consultation->vitals->pulse_rate ?? 'N/A' }} bpm</div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="text-center">
                                    <div class="text-muted small">Respiratory Rate</div>
                                    <div class="h6">{{ $consultation->vitals->respiratory_rate ?? 'N/A' }}</div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="text-center">
                                    <div class="text-muted small">Blood Sugar</div>
                                    <div class="h6">{{ $consultation->vitals->blood_sugar ?? 'N/A' }} mg/dL</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Prescriptions -->
            <div class="card mt-3">
                <div class="card-header">
                    <i class="fas fa-prescription mr-2"></i> Prescriptions
                </div>
                <div class="card-body">
                    @if($consultation->prescriptions->isEmpty())
                        <p class="text-muted">No prescriptions recorded.</p>
                    @else
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Medicine</th>
                                        <th>Dosage</th>
                                        <th>Frequency</th>
                                        <th>Duration</th>
                                        <th>Instructions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($consultation->prescriptions as $prescription)
                                        <tr>
                                            <td><strong>{{ $prescription->drug_name }}</strong></td>
                                            <td>{{ $prescription->dosage }}</td>
                                            <td>{{ $prescription->frequency }}</td>
                                            <td>{{ $prescription->duration }}</td>
                                            <td>{{ $prescription->instructions ?? '-' }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Investigations -->
            <div class="card mt-3">
                <div class="card-header">
                    <i class="fas fa-flask mr-2"></i> Investigations
                </div>
                <div class="card-body">
                    @if($consultation->investigationOrders->isEmpty())
                        <p class="text-muted">No investigations ordered.</p>
                    @else
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Investigation</th>
                                        <th>Type</th>
                                        <th>Status</th>
                                        <th>Instructions</th>
                                        <th>Results</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($consultation->investigationOrders as $investigation)
                                        <tr>
                                            <td><strong>{{ $investigation->investigation_name }}</strong></td>
                                            <td>{{ $investigation->type_label }}</td>
                                            <td>{!! $investigation->status_badge !!}</td>
                                            <td>{{ $investigation->instructions ?? '-' }}</td>
                                            <td>{{ $investigation->results ?? 'Pending' }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <!-- Patient Info Card -->
            <div class="card">
                <div class="card-header">
                    <i class="fas fa-user mr-2"></i> Patient Info
                </div>
                <div class="card-body text-center">
                    <i class="fas fa-user-circle fa-4x text-secondary mb-3"></i>
                    <h5>{{ $consultation->patient->full_name ?? 'N/A' }}</h5>
                    <p class="text-muted">UHID: <strong>{{ $consultation->patient->uhid ?? 'N/A' }}</strong></p>
                    <hr>
                    <div class="text-left">
                        <p><strong>Age:</strong> {{ $consultation->patient->age ?? 'N/A' }} years</p>
                        <p><strong>Gender:</strong> <span class="text-capitalize">{{ $consultation->patient->gender ?? 'N/A' }}</span></p>
                        <p><strong>Phone:</strong> {{ $consultation->patient->phone ?? 'N/A' }}</p>
                        <p><strong>Blood Group:</strong> {{ $consultation->patient->blood_group ?? 'N/A' }}</p>
                    </div>
                    <a href="{{ route('consultations.patient-history', $consultation->patient_id) }}" class="btn btn-outline-primary btn-block">
                        <i class="fas fa-history mr-1"></i> View Patient History
                    </a>
                    <a href="{{ route('patients.show', $consultation->patient_id) }}" class="btn btn-outline-secondary btn-block">
                        <i class="fas fa-address-card mr-1"></i> Full Profile
                    </a>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="card mt-3">
                <div class="card-header">
                    <i class="fas fa-bolt mr-2"></i> Quick Actions
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        @if($consultation->status == 'active')
                            <form action="{{ route('consultations.complete', $consultation->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-success btn-block">
                                    <i class="fas fa-check mr-1"></i> Complete Consultation
                                </button>
                            </form>
                            <a href="{{ route('consultations.edit', $consultation->id) }}" class="btn btn-primary btn-block">
                                <i class="fas fa-edit mr-1"></i> Edit Consultation
                            </a>
                        @endif
                        <a href="{{ route('consultations.prescription-print', $consultation->id) }}" target="_blank" class="btn btn-info btn-block">
                            <i class="fas fa-print mr-1"></i> Print Prescription
                        </a>
                        <a href="{{ route('consultations.index') }}" class="btn btn-secondary btn-block">
                            <i class="fas fa-arrow-left mr-1"></i> Back to List
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection