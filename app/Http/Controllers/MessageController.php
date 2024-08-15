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
        return redirect()->back()->with('success',__('dashboard.Message Send Successfully'));
    }
    public function replyMessage(Request $request){
        $message=Message::where('id',$request->message_id)->first();
        Message::where('id',$request->message_id)->update(['is_read'=>1]);
        Message::create(['sender_id'=>auth()->user()->id,'receiver_id'=>$message->sender_id,'message'=>$request->message,'message_sender'=>'doctor']);
        return redirect()->back()->with('success',__('dashboard.Message Send Successfully'));
    }
    public function sendMessage(Request $request){
        $message_type=$request->message_type;
        $message=$request->message;
        Message::create(['sender_id'=>auth()->user()->id,'receiver_id'=>$request->patient_id,'message'=>$message,'message_type'=>$message_type,'message_sender'=>'doctor']);
        return redirect()->back()->with('success',__('dashboard.Message Send Successfully'));
    }
}
