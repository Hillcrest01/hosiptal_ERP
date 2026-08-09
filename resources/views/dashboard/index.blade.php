@extends('layouts.admin')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard')
@section('breadcrumb')
    <li class="breadcrumb-item active">Dashboard</li>
@endsection

@section('content')
    <div class="row">
        <div class="col-lg-3 col-6">
            <div class="stat-card stat-card-blue">
                <div class="stat-icon">
                    <i class="fas fa-users"></i>
                </div>
                <div class="stat-number">{{ $totalPatients ?? 0 }}</div>
                <div class="stat-label">Total Patients</div>
            </div>
        </div>
        <div class="col-lg-3 col-6">
            <div class="stat-card stat-card-teal">
                <div class="stat-icon">
                    <i class="fas fa-calendar-check"></i>
                </div>
                <div class="stat-number">0</div>
                <div class="stat-label">Today's Appointments</div>
            </div>
        </div>
        <div class="col-lg-3 col-6">
            <div class="stat-card stat-card-purple">
                <div class="stat-icon">
                    <i class="fas fa-procedures"></i>
                </div>
                <div class="stat-number">0</div>
                <div class="stat-label">Admitted Patients</div>
            </div>
        </div>
        <div class="col-lg-3 col-6">
            <div class="stat-card stat-card-rose">
                <div class="stat-icon">
                    <i class="fas fa-dollar-sign"></i>
                </div>
                <div class="stat-number">$0</div>
                <div class="stat-label">Today's Revenue</div>
            </div>
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <span>Recent Patients</span>
                    <a href="{{ route('patients.index') }}" class="btn btn-sm btn-outline-primary">View All</a>
                </div>
                <div class="card-body">
                    @if(isset($recentPatients) && $recentPatients->isNotEmpty())
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>UHID</th>
                                        <th>Name</th>
                                        <th>Age</th>
                                        <th>Phone</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($recentPatients as $patient)
                                        <tr>
                                            <td><strong>{{ $patient->uhid }}</strong></td>
                                            <td>{{ $patient->full_name }}</td>
                                            <td>{{ $patient->age }}</td>
                                            <td>{{ $patient->phone }}</td>
                                            <td>
                                                <a href="{{ route('patients.show', $patient->id) }}" class="btn btn-sm btn-outline-primary">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="empty-state">
                            <div class="empty-icon">
                                <i class="fas fa-inbox"></i>
                            </div>
                            <h5>No patients registered yet</h5>
                            <p>Start by registering your first patient to see activity here.</p>
                            <a href="{{ route('patients.create') }}" class="btn btn-primary">
                                <i class="fas fa-user-plus mr-2"></i> Register Patient
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    Quick Actions
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <a href="{{ route('patients.create') }}" class="quick-action-btn">
                            <span class="icon-circle blue">
                                <i class="fas fa-user-plus"></i>
                            </span>
                            New Patient
                        </a>
                        <a href="#" class="quick-action-btn">
                            <span class="icon-circle teal">
                                <i class="fas fa-stethoscope"></i>
                            </span>
                            New Consultation
                        </a>
                        <a href="#" class="quick-action-btn">
                            <span class="icon-circle purple">
                                <i class="fas fa-prescription-bottle"></i>
                            </span>
                            Dispense Medicine
                        </a>
                        <a href="#" class="quick-action-btn">
                            <span class="icon-circle rose">
                                <i class="fas fa-file-invoice"></i>
                            </span>
                            Create Bill
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection