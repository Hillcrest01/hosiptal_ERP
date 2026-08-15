<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ConsultationNote extends Model
{
    use HasFactory, SoftDeletes;
     protected $fillable = [
        'consultation_id',
        'user_id',
        'note',
        'type'
    ];
     public function consultation()
    {
        return $this->belongsTo(Consultation::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
