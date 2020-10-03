<?php

namespace App\Http\Controllers;

use App\Events\ChatEvents;
use App\Events\DirectMessageEvents;
use Illuminate\Http\Request;

class MessageController extends Controller
{
    public function send(Request $request)
    {
        broadcast(new ChatEvents($request->get('message')))->toOthers();

        return response()->json([
            'status' => 'Message sent successfully!',
            'date' => now()->toDateTime()
        ], 200);
    }

    public function sendDirectMsg(Request $request)
    {
        $message = $request->get('message');
        $to = $request->get('to');

        event(new DirectMessageEvents($message, $to));

        return response()->json([
            'status' => 'Direct Message sent successfully!',
            'date' => now()->toDateTime()
        ], 200);
    }
}
