<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MonitoringHistory extends Model
{
    use HasFactory;
    protected $fillable=['doctor_id','patient_id','monitor_id','rep_date','rep_overall','rep_overall_neg','rep_overall_bodypart','rep_monitor_condition','rep_monitor_condition_neg','rep_medication','rep_medication_neg','rep_medication_sideeffect','rep_medication_bodypart','notes'];
}
