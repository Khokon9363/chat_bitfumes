<?php

namespace App\Http\Controllers;

use App\Event\ChatEvent;
use App\User;
use Illuminate\Http\Request;
use App\Message;
use Illuminate\Support\Facades\Auth;

class MessageController extends Controller
{
    public function store(Request $request)
    {   
        $message = new Message();
        $message->to = 2;
        $message->from = 1;
        $message->message = $request->message;
        $message->save();

        $user = User::find(Auth::id());
        event(new ChatEvent($request->message, $user));

        return response()->json($message,200);
    }
    public function all()
    {   
        $chats = Message::all();
        return response()->json($chats,200);
    }
}
