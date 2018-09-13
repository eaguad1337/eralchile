<?php

namespace App\Mail;

use EAguad\Model\Order;
use EAguad\Model\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class OrderApproved extends Mailable
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
        return $this->view('emails.order_approved')
            ->with(['order' => $this->order])
            ->attach($orderFile->getPath(), [
                'as' => $this->order->code . '.pdf',
                'mime' => 'application/pdf',
            ])
            ->subject("Orden " . $this->order->code . " aprobada")
            ->to($this->order->signer->email);
    }
}
