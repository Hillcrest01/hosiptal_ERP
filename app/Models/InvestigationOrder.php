<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class InvestigationOrder extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'consultation_id',
        'investigation_name',
        'type',
        'instructions',
        'status',
        'results',
        'result_entered_at',
        'result_entered_by'
    ];

    protected $casts = [
        'result_entered_at' => 'datetime'
    ];

    public function consultation()
    {
        return $this->belongsTo(Consultation::class);
    }

    public function resultEnteredBy()
    {
        return $this->belongsTo(User::class, 'result_entered_by');
    }

    public function getStatusBadgeAttribute()
    {
        $colors = [
            'ordered' => 'warning',
            'in_progress' => 'info',
            'completed' => 'success',
            'cancelled' => 'danger'
        ];

        $labels = [
            'ordered' => 'Ordered',
            'in_progress' => 'In Progress',
            'completed' => 'Completed',
            'cancelled' => 'Cancelled'
        ];

        return "<span class='badge badge-{$colors[$this->status]}'>{$labels[$this->status]}</span>";
    }
     public function getTypeLabelAttribute()
    {
        $labels = [
            'pathology' => 'Pathology',
            'radiology' => 'Radiology',
            'other' => 'Other'
        ];

        return $labels[$this->type] ?? 'Unknown';
    }
}
