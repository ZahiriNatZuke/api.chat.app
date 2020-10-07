<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class DirectMessageEvents implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * @var array
     */
    public $response;

    /**
     * Create a new event instance.
     *
     * @param $hash
     * @param $message
     * @param $to
     * @param $date
     * @param null $reference
     */
    public function __construct($hash, $message, $to, $date, $reference = null)
    {
        $this->response = [
            'hash' => $hash,
            'message' => $message,
            'from' => auth()->user(),
            'to' => $to,
            'date' => $date,
            'reference' => $reference,
        ];
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel("channel-direct.{$this->response['to']}");
    }
}
