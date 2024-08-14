<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PatientQuantitativeIndicators extends Model
{
    use HasFactory;

    // Table associated with the model
    protected $table = 'patient_quantitative_indicators';

    // Fillable attributes
    protected $fillable = [
        'patient_id',
        'blood_pressure',
        'weight',
        'physical_exercise_activity',
    ];
 
    // Define the relationship with the Patient model
    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }
}
