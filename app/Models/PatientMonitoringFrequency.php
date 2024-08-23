<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PatientMonitoringFrequency extends Model
{
    use HasFactory;

    protected $fillable = ['patient_id', 'frequency', 'preferred_call_time'];

    protected $casts = [
        'frequency' => 'array', // Cast the frequency JSON to an array
    ];
}
