<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MedicalFecility extends Model
{
    use HasFactory;
    protected $fillable=['facility_id','facility_name','facility_drs','facility_patients','lang'];

    public function getDoctorsAttribute()
    {
        $doctorIds = explode(',', $this->facility_drs);
        $doctors = User::whereIn('id', $doctorIds)->get(['firstname', 'lastname','doctor_id']);
        
        return $doctors;
    }
    public function getPatientsAttribute()
    {
        $patientIds = explode(',', $this->facility_patients);
        $patients = Patient::whereIn('id', $patientIds)->get(['first_name', 'last_name','patient_id']);
        
        return $patients;
    }
}
