<?php

namespace App\Mail;

use EAguad\Model\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class OrderSigned extends Mailable
{
    use Queueable, SerializesModels;
    /**
     * @var Order
     */
    private $order;

    /**
     * Create a new message instance.
     *
     * @param Order $order
     */
    public function __construct(Order $order)
    {
        $this->order = $order;
    }

    /**
     * Build the message.
     *
     * @return $this
     * @throws \Spatie\MediaLibrary\Exceptions\InvalidConversion
     */
    public function build()
    {
        $orderFile = $this->order->getFirstMedia();
        return $this->view('emails.order_signed')
            ->subject("Orden " . $this->order->code . " visada.")
            ->attach($orderFile->getPath(), [
                'as' => $this->order->code . '.pdf',
                'mime' => 'application/pdf',
            ])
            ->with(['order' => $this->order]);
    }
}
