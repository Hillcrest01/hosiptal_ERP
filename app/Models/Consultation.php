<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Consultation extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'patient_id',
        'doctor_id',
        'consultation_date',
        'symptoms',
        'diagnosis',
        'clinical_notes',
        'treatment_plan',
        'advice',
        'follow_up_date',
        'status'
    ];

    protected $casts = [
        'follow_up_date' => 'datetime',
        'consultation_date' => 'datetime',
    ];

    public function patient(){
        return $this->belongsTo(Patient::class);
    }

    public function doctor(){
        return $this->belongsTo(User::class, 'doctor_id');
    }

    public function vitals(){
        return $this->hasOne(Vital::class);
    }
    public function prescriptions(){
        return $this->hasMany(Prescription::class);
    }
     public function investigationOrders()
    {
        return $this->hasMany(InvestigationOrder::class);
    }

    public function notes()
    {
        return $this->hasMany(ConsultationNote::class);
    }

    public function scopeActive($query){
        return $query->where('status', 'active');
    }

    public function scopeCompleted($query){
        return $query->where('status', 'completed');
    }
    public function scopeByDoctor($query, $doctorId){
        return $query->where('doctor_id', $doctorId);
    }
    public function scopeByPatient($query, $patientId){
        return $query->where('patient_id', $patientId);
    }
    public function scopeToday($query){
        return $query->where('consultation_date', today());
    }

    public function getStatusBadgeAttribute(){
        $colors = [
            'active' => 'primary',
            'completed' => 'success',
            'cancelled' => 'danger',
        ];
        $labels = [
            'active' => 'Active',
            'completed' => 'Completed',
            'cancelled' => 'Cancelled',
        ];
        $color = $colors[$this->status] ?? 'secondary';
        $label = $labels[$this->status] ?? 'unknown';

        return "<span class='badge badge-{$color}'>{$label}</span>";
    }
     public function getFormattedDateAttribute()
    {
        return $this->consultation_date->format('d M Y h:i A');
    }
}
