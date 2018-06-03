<?php namespace App\Listeners;

use App\Mail\OrderApproved;
use App\Events\OrderApprovedEvent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Mail;

class OrderApprovedListener
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
     * @param OrderApprovedEvent $event
     * @return void
     */
    public function handle(OrderApprovedEvent $event)
    {
        Mail::to($event->getOrder()->user->email)
            ->send(new OrderApproved($event->getOrder()));
    }
}
