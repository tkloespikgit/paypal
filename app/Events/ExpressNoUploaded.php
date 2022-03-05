<?php

namespace App\Events;

use App\Models\OrderInfo;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ExpressNoUploaded
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * @var OrderInfo
     */
    public $order;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(OrderInfo $order)
    {
        //
        $this->order = $order;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('order_express');
    }
}
