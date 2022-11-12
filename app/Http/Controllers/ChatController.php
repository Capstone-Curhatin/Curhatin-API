<?php

namespace App\Http\Controllers;

use App\Helpers\ResponseFormatter;
use App\Models\Chat;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Validator;

class ChatController extends Controller
{

    public function getPriorityUser(Request $request){

    }

    public function addWaitingRoom(Request $request){
        $chat = new Chat;
        $chat->user_id = $request->user()->id;
        $chat->updated_at = Carbon::now();
        $chat->created_at = Carbon::now();
        return ResponseFormatter::success(null, 'Data succesfully added!');
    }

    public function updateStatus(Request $request){
        if ($request->type == "is_online"){
            Chat::where('user_id', $request->user()->id)->update(['is_online', $request->is_online]);
            return ResponseFormatter::success('Data succesfully updated!');
        }elseif ($request->type == "is_waiting"){
            Chat::where('user_id', $request->user()->id)->update(['is_waiting', $request->is_waiting]);
            return ResponseFormatter::success('Data succesfully updated!');
        }else{
            return ResponseFormatter::error('Type not found!');
        }
    }
}
