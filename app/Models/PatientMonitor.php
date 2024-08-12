<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PatientMonitor extends Model
{
    use HasFactory;
    protected $fillable=['doctor_id','patient_id','monitor_condition','medication','dose','lang'];

    public function patient(){
        return $this->belongsTo(Patient::class,'patient_id','id');
    }
    public function symptom(){
        return $this->belongsTo(Symptom::class,'monitor_condition','id');
    }
    public function medications(){
        return $this->belongsTo(Medication::class,'medication','id');
    }
    
    
}
