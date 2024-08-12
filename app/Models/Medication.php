<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Medication extends Model
{
    use HasFactory;

    protected $fillable=['med_name','med_id','med_form','med_form_look','med_pack_look','med_purpose','med_contraindications','med_sideeffects','lang'];
}
