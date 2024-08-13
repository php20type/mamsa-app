<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    use HasFactory;
    protected $fillable=['sender_id','receiver_id','message','message_type','is_read','message_sender'];

    public function patientDetails()
    {
        return $this->belongsTo(Patient::class, 'sender_id');
    }
}
