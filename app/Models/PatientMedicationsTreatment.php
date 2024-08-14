<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PatientMedicationsTreatment extends Model
{
    use HasFactory;

    // Table associated with the model
    protected $table = 'patient_medications_treatment';

    // Fillable attributes
    protected $fillable = [
        'patient_id',
        'use_of_medication',
        'medication_use_reminders',
        'medication_side_effects',
    ];

    // Define the relationship with the Patient model
    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }
}
