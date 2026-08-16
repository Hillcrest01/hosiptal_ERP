@extends('layouts.admin')

@section('title', "Today's Consultations")
@section('page-title', "Today's Consultations")
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('consultations.index') }}">Consultations</a></li>
    <li class="breadcrumb-item active">Today</li>
@endsection

@section('content')
    <div class="alert alert-info">
        <i class="fas fa-calendar-day mr-2"></i> Showing consultations for <strong>{{ now()->format('l, d F Y') }}</strong>
    </div>

    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <span><i class="fas fa-list mr-2"></i> Today's Schedule</span>
            <a href="{{ route('consultations.create') }}" class="btn btn-primary btn-sm">
                <i class="fas fa-plus mr-1"></i> New Consultation
            </a>
        </div>
        <div class="card-body">
            @if($consultations->isEmpty())
                <div class="empty-state">
                    <div class="empty-icon">
                        <i class="fas fa-calendar-check"></i>
                    </div>
                    <h5>No consultations scheduled for today</h5>
                    <p>Enjoy a quiet day or start a new consultation.</p>
                    <a href="{{ route('consultations.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus mr-2"></i> Start Consultation
                    </a>
                </div>
            @else
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Time</th>
                                <th>Patient</th>
                                <th>Doctor</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($consultations as $consultation)
                                <tr>
                                    <td>{{ $consultation->consultation_date->format('h:i A') }}</td>
                                    <td>
                                        <a href="{{ route('patients.show', $consultation->patient_id) }}">
                                            {{ $consultation->patient->full_name ?? 'N/A' }}
                                        </a>
                                        <br>
                                        <small class="text-muted">{{ $consultation->patient->uhid ?? 'N/A' }}</small>
                                    </td>
                                    <td>{{ $consultation->doctor->name ?? 'N/A' }}</td>
                                    <td>{!! $consultation->status_badge !!}</td>
                                    <td>
                                        <a href="{{ route('consultations.show', $consultation->id) }}" class="btn btn-sm btn-outline-primary">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        @if($consultation->status == 'active')
                                            <a href="{{ route('consultations.edit', $consultation->id) }}" class="btn btn-sm btn-outline-secondary">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>
@endsection