<?php

namespace App\Http\Controllers;

use App\Events\ChatEvents;
use App\Events\DeleteMessageEvents;
use App\Events\DirectMessageEvents;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\Hash;

class MessageController extends Controller
{
    public function sendPublicMsg(Request $request)
    {
        $now = Date::now();
        $hash = Hash::make($now->unix());
        $message = $request->get('message');
        $date = $now->toDateTime();
        $reference = [
            'hash' => $request->get('ref_hash'),
            'message' => $request->get('ref_message'),
            'from' => $request->get('ref_from'),
        ];

        broadcast(new ChatEvents($hash, $message, $date, $reference))->toOthers();

        return response()->json([
            'status' => 'Message sent successfully!',
            'date' => $date,
            'hash' => $hash
        ], 200);
    }

    public function sendDirectMsg(Request $request)
    {
        $now = Date::now();
        $hash = Hash::make($now->unix());
        $message = $request->get('message');
        $to = $request->get('to');
        $date = $now->toDateTime();
        $reference = [
            'hash' => $request->get('ref_hash'),
            'message' => $request->get('ref_message'),
            'from' => $request->get('ref_from'),
        ];

        broadcast(new DirectMessageEvents($hash, $message, $to, $date, $reference));

        return response()->json([
            'status' => 'Direct Message sent successfully!',
            'date' => $date,
            'hash' => $hash
        ], 200);
    }

    public function deleteMsg(Request $request)
    {
        $channel = $request->get('channel');
        $hash = $request->get('hash');
        $from = $request->get('from');

        broadcast(new DeleteMessageEvents($channel, $hash, $from))->toOthers();

        return response()->json([
            'status' => 'Message deleted successfully!',
        ], 200);
    }
}
