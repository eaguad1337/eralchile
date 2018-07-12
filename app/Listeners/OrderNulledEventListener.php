<?php

namespace App\Listeners;

use App\Events\OrderNulledEvent;
use App\Mail\OrderNulled;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Mail;

class OrderNulledEventListener
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
     * @param  OrderNulledEvent  $event
     * @return void
     */
    public function handle(OrderNulledEvent $event)
    {
        Mail::to($event->getOrder()->user->email)
            ->send(new OrderNulled($event->getOrder()));
    }
}
