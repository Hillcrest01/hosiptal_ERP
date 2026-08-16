@extends('layouts.admin')

@section('title', 'Consultations')
@section('page-title', 'Consultations')
@section('breadcrumb')
    <li class="breadcrumb-item active">Consultations</li>
@endsection

@section('content')
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="stat-card stat-card-blue">
                <div class="stat-icon">
                    <i class="fas fa-stethoscope"></i>
                </div>
                <div class="stat-number">{{ $stats['total'] }}</div>
                <div class="stat-label">Total Consultations</div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stat-card stat-card-teal">
                <div class="stat-icon">
                    <i class="fas fa-calendar-day"></i>
                </div>
                <div class="stat-number">{{ $stats['today'] }}</div>
                <div class="stat-label">Today's Consultations</div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stat-card stat-card-purple">
                <div class="stat-icon">
                    <i class="fas fa-spinner"></i>
                </div>
                <div class="stat-number">{{ $stats['active'] }}</div>
                <div class="stat-label">Active Consultations</div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stat-card stat-card-rose">
                <div class="stat-icon">
                    <i class="fas fa-check-circle"></i>
                </div>
                <div class="stat-number">{{ $stats['completed'] }}</div>
                <div class="stat-label">Completed</div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <span>Consultation List</span>
            <a href="{{ route('consultations.create') }}" class="btn btn-primary">
                <i class="fas fa-plus mr-2"></i> New Consultation
            </a>
        </div>
        <div class="card-body">
            <ul class="nav nav-tabs mb-4">
                <li class="nav-item">
                    <a class="nav-link {{ $status == 'active' ? 'active' : '' }}" href="{{ route('consultations.index', ['status' => 'active']) }}">
                        <i class="fas fa-spinner mr-1"></i> Active
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ $status == 'today' ? 'active' : '' }}" href="{{ route('consultations.index', ['status' => 'today']) }}">
                        <i class="fas fa-calendar-day mr-1"></i> Today
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ $status == 'completed' ? 'active' : '' }}" href="{{ route('consultations.index', ['status' => 'completed']) }}">
                        <i class="fas fa-check mr-1"></i> Completed
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ $status == 'cancelled' ? 'active' : '' }}" href="{{ route('consultations.index', ['status' => 'cancelled']) }}">
                        <i class="fas fa-times mr-1"></i> Cancelled
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ $status == 'all' ? 'active' : '' }}" href="{{ route('consultations.index', ['status' => 'all']) }}">
                        <i class="fas fa-list mr-1"></i> All
                    </a>
                </li>
            </ul>

            @if($consultations->isEmpty())
                <div class="empty-state">
                    <div class="empty-icon">
                        <i class="fas fa-stethoscope"></i>
                    </div>
                    <h5>No consultations found</h5>
                    <p>Start a new consultation by clicking the button above.</p>
                    <a href="{{ route('consultations.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus mr-2"></i> New Consultation
                    </a>
                </div>
            @else
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Date & Time</th>
                                <th>Patient</th>
                                <th>Doctor</th>
                                <th>Symptoms</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($consultations as $consultation)
                                <tr>
                                    <td>{{ $consultation->formatted_date }}</td>
                                    <td>
                                        <a href="{{ route('patients.show', $consultation->patient_id) }}">
                                            {{ $consultation->patient->full_name ?? 'N/A' }}
                                        </a>
                                    </td>
                                    <td>{{ $consultation->doctor->name ?? 'N/A' }}</td>
                                    <td>{{ Str::limit($consultation->symptoms, 50) }}</td>
                                    <td>{!! $consultation->status_badge !!}</td>
                                    <td>
                                        <a href="{{ route('consultations.show', $consultation->id) }}" class="btn btn-sm btn-outline-primary">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        @if($consultation->status == 'active')
                                            <a href="{{ route('consultations.edit', $consultation->id) }}" class="btn btn-sm btn-outline-secondary">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form action="{{ route('consultations.complete', $consultation->id) }}" method="POST" class="d-inline">
                                                @csrf
                                                <button type="submit" class="btn btn-sm btn-outline-success">
                                                    <i class="fas fa-check"></i>
                                                </button>
                                            </form>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="mt-3">
                    {{ $consultations->appends(['status' => $status])->links() }}
                </div>
            @endif
        </div>
    </div>
@endsection