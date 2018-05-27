<?php namespace EAguad\Listeners;

use App\Mail\OrderRejected;
use EAguad\Events\OrderApprovedEvent;
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
     * @param OrderApprovedEvent $event
     * @return void
     * @throws \Spatie\MediaLibrary\Exceptions\InvalidConversion
     */
    public function handle(OrderApprovedEvent $event)
    {
        $orderFile = $event->getOrder()->getFirstMedia('pdf');
        Mail::to($event->getOrder()->costCentre->getReviewerEmail())
            ->attach($orderFile->getPath(), [
                'as' => $orderFile->name,
                'mime' => 'application/pdf',
            ])
            ->send(new OrderRejected($event->getOrder()));
    }
}
