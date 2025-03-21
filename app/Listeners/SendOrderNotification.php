<?php

namespace App\Listeners;

use App\Events\EmptyCartEvent;
use App\Models\User;
use App\Notifications\OrderCreatedNotifications;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendOrderNotification
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle(EmptyCartEvent $event)
    {
        $order = $event->order;
        $user=User::where('store_id',$event->order->store_id)->first();
        $user->notify(new OrderCreatedNotifications($order));
    }
}
