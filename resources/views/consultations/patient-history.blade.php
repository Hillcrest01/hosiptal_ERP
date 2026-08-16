@extends('layouts.admin')

@section('title', 'Patient History')
@section('page-title', 'Patient History - ' . $patient->full_name)
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('patients.index') }}">Patients</a></li>
    <li class="breadcrumb-item"><a href="{{ route('patients.show', $patient->id) }}">{{ $patient->full_name }}</a></li>
    <li class="breadcrumb-item active">History</li>
@endsection

@section('content')
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <span>
                <i class="fas fa-history mr-2"></i> Consultation History
                <span class="badge badge-secondary ml-2">{{ $consultations->total() }} records</span>
            </span>
            <a href="{{ route('consultations.create', ['patient_id' => $patient->id]) }}" class="btn btn-primary btn-sm">
                <i class="fas fa-plus mr-1"></i> New Consultation
            </a>
        </div>
        <div class="card-body">
            @if($consultations->isEmpty())
                <div class="empty-state">
                    <div class="empty-icon">
                        <i class="fas fa-stethoscope"></i>
                    </div>
                    <h5>No consultation history found</h5>
                    <p>This patient has not had any consultations yet.</p>
                    <a href="{{ route('consultations.create', ['patient_id' => $patient->id]) }}" class="btn btn-primary">
                        <i class="fas fa-plus mr-2"></i> Start Consultation
                    </a>
                </div>
            @else
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Date</th>
                                <th>Doctor</th>
                                <th>Symptoms</th>
                                <th>Diagnosis</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($consultations as $consultation)
                                <tr>
                                    <td>{{ $consultation->formatted_date }}</td>
                                    <td>{{ $consultation->doctor->name ?? 'N/A' }}</td>
                                    <td>{{ Str::limit($consultation->symptoms, 50) }}</td>
                                    <td>{{ Str::limit($consultation->diagnosis, 50) }}</td>
                                    <td>{!! $consultation->status_badge !!}</td>
                                    <td>
                                        <a href="{{ route('consultations.show', $consultation->id) }}" class="btn btn-sm btn-outline-primary">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('consultations.prescription-print', $consultation->id) }}" target="_blank" class="btn btn-sm btn-outline-info">
                                            <i class="fas fa-print"></i>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="mt-3">
                    {{ $consultations->links() }}
                </div>
            @endif
        </div>
    </div>
@endsection