<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Prescription extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'consultation_id',
        'drug_id',
        'drug_name',
        'dosage',
        'frequency',
        'duration',
        'instructions',
        'is_emergency'
    ];

    protected $casts = [
        'is_emergency' => 'boolean'
    ];

    public function consultation(){
        $this->belongsTo(Consultation::class);
    }
    public function drug(){
        return $this->belongsTo(Drug::class);
    }
}
