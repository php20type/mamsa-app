<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PatientMedication extends Model
{
    use HasFactory;

    // Define the table name if different from the default
    protected $table = 'patient_medication';

    // Define the fillable fields
    protected $fillable = [
        'patient_id',
        'medication',
        'purpose_of_medication',
        'use_schedule',
        'food_use',
        'dose_use',
        'doses_per_package',
        'last_prescription_start',
    ];

    // Define the relationship with the Patient model
    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }
}
