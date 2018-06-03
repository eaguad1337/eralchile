<?php namespace App\Listeners;

use App\Events\OrderSignedEvent;
use App\Mail\OrderSigned;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Mail;

class OrderSignedListener
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
     * @param OrderSignedEvent $event
     * @return void
     */
    public function handle(OrderSignedEvent $event)
    {
        Mail::to($event->getOrder()->user->email)
            ->send(new OrderSigned($event->getOrder()));
    }
}
