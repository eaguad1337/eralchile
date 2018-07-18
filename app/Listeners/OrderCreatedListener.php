<?php namespace App\Listeners;

use App\Events\OrderCreatedEvent;
use App\Mail\OrderCreated;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Mail;

class OrderCreatedListener
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
     * @param OrderCreatedEvent $event
     * @return void
     */
    public function handle(OrderCreatedEvent $event)
    {
        Mail::to($event->getOrder()->approver->email)
            ->send(new OrderCreated($event->getOrder()));
    }
}
