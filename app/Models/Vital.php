<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Vital extends Model
{
     protected $fillable = [
        'consultation_id',
        'weight',
        'height',
        'bmi',
        'systolic_bp',
        'diastolic_bp',
        'temperature',
        'pulse_rate',
        'respiratory_rate',
        'blood_sugar',
        'notes'
    ];

    protected $casts = [
        'weight' => 'decimal:2',
        'height' => 'decimal:2',
        'bmi' => 'decimal:2',
        'temperature' => 'decimal:1',
        'blood_sugar' => 'decimal:2'
    ];

    public function consultation(){
        return $this->belongsTo(Consultation::class);
    }
    public function getBpReadingAttribute(){
        if($this->systolic_bp && $this->diastolic_bp){
            return "{$this->systolic_bp} / {$this->diastolic_bp}";
        }
        return null;
    }
    public function getBmiCategoryAttribute()
    {
        if (!$this->bmi) return null;

        if ($this->bmi < 18.5) return 'Underweight';
        if ($this->bmi < 25) return 'Normal';
        if ($this->bmi < 30) return 'Overweight';
        if ($this->bmi < 35) return 'Obese Class I';
        if ($this->bmi < 40) return 'Obese Class II';
        return 'Obese Class III';
    }
}
