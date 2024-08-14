<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
    use HasFactory;
    
    protected $fillable=['patient_id','first_name','last_name','phone_number','other_number', 'image','address' ,'doctor_ids','facility_ids','frequency','preferred_time_from','preferred_time_to','monitor_id','lang','DOB','weight'];

    public function getDoctorsAttribute()
    {
        $doctorIds = explode(',', $this->doctor_ids);
        $doctors = User::whereIn('id', $doctorIds)->get(['firstname', 'lastname','doctor_id']);
        
        return $doctors;
    }
    public function getFacilitiesAttribute()
    {
        $facility_ids = explode(',', $this->facility_ids);
        $facilities = MedicalFecility::whereIn('id', $facility_ids)->get(['facility_name', 'facility_id']);
        
        return $facilities;
    }
    public function patientHistory()
    {
        return $this->belongsTo(MonitoringHistory::class,'id','patient_id');
    }
    public function patientHistoryList()
    {
        return $this->hasMany(MonitoringHistory::class,'patient_id','id');
    }
    public function patientMonitors()
    {
        return $this->hasMany(PatientMonitor::class, 'patient_id', 'id');
    }
}
