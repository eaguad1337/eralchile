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
        if (!$event->getOrder()->signer) return;
        
        Mail::to($event->getOrder()->signer->email)
            ->send(new OrderApproved($event->getOrder()));
    }
}
