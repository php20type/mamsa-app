<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PatientMedicalCondition extends Model
{
    use HasFactory;

    protected $table = 'patient_medical_conditions';

    protected $fillable = [
        'patient_id',
        'overall_health',
        'chronic_pain',
        'pulmonary_disease',
    ];

    /**
     * Define the relationship with the Patient model.
     */
    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

}
