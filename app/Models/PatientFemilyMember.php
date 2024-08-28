<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PatientFemilyMember extends Model
{
    use HasFactory;
    protected $fillable = ['patient_id','name','phone','relation','email'];
}
