<?php

namespace App\Http\Controllers;

use App\Models\Message;
use Illuminate\Http\Request;

class MessageController extends Controller
{
    //
    public function sendGroupMessage(Request $request){
        $patients=$request->patient;
        $message_type=$request->message_type;
        $message=$request->message;
        foreach($patients as $patient){
            Message::create(['sender_id'=>auth()->user()->id,'receiver_id'=>$patient,'message'=>$message,'message_type'=>$message_type,'message_sender'=>'doctor']);
        }
        return redirect()->back()->with('success','Message Send Successfully');
    }
}
