<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PatientHobby extends Model
{
    use HasFactory;

    protected $fillable = ['patient_id', 'hobby_id', 'status'];

    public function hobby()
    {
        return $this->belongsTo(Hobby::class);
    }
}
