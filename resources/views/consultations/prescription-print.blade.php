<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Prescription - {{ $consultation->patient->full_name ?? 'N/A' }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 40px;
            color: #333;
        }
        .header {
            text-align: center;
            border-bottom: 2px solid #1a3c6e;
            padding-bottom: 20px;
            margin-bottom: 20px;
        }
        .header h1 {
            color: #1a3c6e;
            margin: 0;
        }
        .header .subtitle {
            color: #666;
            font-size: 14px;
        }
        .patient-info {
            background: #f5f7fa;
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 20px;
        }
        .patient-info table {
            width: 100%;
        }
        .patient-info td {
            padding: 5px 10px;
        }
        .prescription-table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }
        .prescription-table th {
            background: #1a3c6e;
            color: white;
            padding: 10px;
            text-align: left;
        }
        .prescription-table td {
            padding: 10px;
            border-bottom: 1px solid #ddd;
        }
        .prescription-table tr:hover {
            background: #f5f7fa;
        }
        .footer {
            margin-top: 40px;
            padding-top: 20px;
            border-top: 1px solid #ddd;
            font-size: 12px;
            color: #666;
        }
        .doctor-signature {
            margin-top: 30px;
        }
        .doctor-signature .signature-line {
            width: 200px;
            border-bottom: 1px solid #333;
            margin-top: 30px;
        }
        @media print {
            body { margin: 20px; }
            .no-print { display: none; }
        }
        .no-print {
            margin-top: 20px;
        }
        .no-print button {
            padding: 10px 20px;
            background: #1a3c6e;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        .no-print button:hover {
            background: #0f2a4a;
        }
        .emergency-badge {
            background: #dc3545;
            color: white;
            padding: 2px 10px;
            border-radius: 3px;
            font-size: 12px;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="no-print" style="text-align: right; margin-bottom: 20px;">
        <button onclick="window.print()">
            <i class="fas fa-print"></i> Print Prescription
        </button>
        <button onclick="window.close()" style="background: #6c757d; margin-left: 10px;">
            <i class="fas fa-times"></i> Close
        </button>
    </div>

    <div class="header">
        <h1>{{ config('app.name') }}</h1>
        <div class="subtitle">Prescription</div>
        <div class="subtitle">Date: {{ $consultation->consultation_date->format('d M Y h:i A') }}</div>
    </div>

    <div class="patient-info">
        <table>
            <tr>
                <td><strong>Patient Name:</strong></td>
                <td>{{ $consultation->patient->full_name ?? 'N/A' }}</td>
                <td><strong>Age:</strong></td>
                <td>{{ $consultation->patient->age ?? 'N/A' }} years</td>
            </tr>
            <tr>
                <td><strong>UHID:</strong></td>
                <td>{{ $consultation->patient->uhid ?? 'N/A' }}</td>
                <td><strong>Gender:</strong></td>
                <td><span class="text-capitalize">{{ $consultation->patient->gender ?? 'N/A' }}</span></td>
            </tr>
            <tr>
                <td><strong>Phone:</strong></td>
                <td>{{ $consultation->patient->phone ?? 'N/A' }}</td>
                <td><strong>Blood Group:</strong></td>
                <td>{{ $consultation->patient->blood_group ?? 'N/A' }}</td>
            </tr>
            <tr>
                <td><strong>Doctor:</strong></td>
                <td colspan="3">{{ $consultation->doctor->name ?? 'N/A' }}</td>
            </tr>
        </table>
    </div>

    @if($consultation->diagnosis)
        <div style="margin-bottom: 20px;">
            <strong>Diagnosis:</strong>
            <p style="margin: 5px 0; padding: 10px; background: #f5f7fa; border-radius: 5px;">
                {{ $consultation->diagnosis }}
            </p>
        </div>
    @endif

    <h3 style="color: #1a3c6e;">Prescribed Medicines</h3>
    @if($consultation->prescriptions->isEmpty())
        <p style="color: #666;">No medicines prescribed.</p>
    @else
        <table class="prescription-table">
            <thead>
                <tr>
                    <th style="width: 25%;">Medicine</th>
                    <th style="width: 20%;">Dosage</th>
                    <th style="width: 20%;">Frequency</th>
                    <th style="width: 20%;">Duration</th>
                    <th style="width: 15%;">Instructions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($consultation->prescriptions as $prescription)
                    <tr>
                        <td>
                            <strong>{{ $prescription->drug_name }}</strong>
                            @if($prescription->is_emergency)
                                <span class="emergency-badge">Emergency</span>
                            @endif
                        </td>
                        <td>{{ $prescription->dosage }}</td>
                        <td>{{ $prescription->frequency }}</td>
                        <td>{{ $prescription->duration }}</td>
                        <td>{{ $prescription->instructions ?? '-' }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif

    @if($consultation->advice)
        <div style="margin: 20px 0;">
            <strong>Advice to Patient:</strong>
            <p style="margin: 5px 0; padding: 10px; background: #f5f7fa; border-radius: 5px;">
                {{ $consultation->advice }}
            </p>
        </div>
    @endif

    @if($consultation->follow_up_date)
        <div style="margin: 20px 0;">
            <strong>Follow-up Date:</strong>
            <span style="color: #1a3c6e; font-weight: bold;">
                {{ $consultation->follow_up_date->format('l, d F Y') }}
            </span>
        </div>
    @endif

    <div class="doctor-signature">
        <div style="float: right; text-align: center;">
            <div class="signature-line"></div>
            <div style="margin-top: 5px;">
                <strong>Dr. {{ $consultation->doctor->name ?? 'N/A' }}</strong>
                <br>
                <span style="font-size: 12px; color: #666;">(Signature & Stamp)</span>
            </div>
        </div>
        <div style="clear: both;"></div>
    </div>

    <div class="footer">
        <p>This is a computer-generated prescription. Please verify all details.</p>
        <p>Generated on: {{ now()->format('d M Y h:i A') }}</p>
    </div>
</body>
</html>