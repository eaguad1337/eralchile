<?php namespace App\Listeners;

use App\Events\OrderRejectedEvent;
use App\Mail\OrderRejected;
use App\Events\OrderApprovedEvent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Mail;

class OrderRejectedListener
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
     * @param OrderRejectedEvent $event
     * @return void
     */
    public function handle(OrderRejectedEvent $event)
    {
        Mail::to($event->getOrder()->user->email)
            ->send(new OrderRejected($event->getOrder()));
    }
}
