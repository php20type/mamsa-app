<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PatientLifestyleAndWellbeing extends Model
{
    use HasFactory;

    // Table associated with the model
    protected $table = 'patient_lifestyle_and_wellbeing';

    // Fillable attributes
    protected $fillable = [
        'patient_id',
        'regular_food_intake',
        'hydration',
        'qxy_gometer',
        'quality_of_sleep',
    ];

    // Define the relationship with the Patient model
    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }
}
