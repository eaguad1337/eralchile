<?php

namespace EAguad\Listeners;

use EAguad\Events\OrderSignedEvent;
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
     * @throws \Spatie\MediaLibrary\Exceptions\InvalidConversion
     */
    public function handle(OrderSignedEvent $event)
    {
        $orderFile = $event->getOrder()->getFirstMedia('pdf');
        Mail::to($event->getOrder()->user->email)
            ->attach($orderFile->getPath(), [
                'as' => $orderFile->name,
                'mime' => 'application/pdf',
            ])
            ->send(new OrderSigned($event->getOrder()));
    }
}
