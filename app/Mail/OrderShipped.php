<?php

namespace App\Mail;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Crypt;

class OrderShipped extends Mailable
{
    public $order;

    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */
    public function __construct(Order $order)
    {
        $this->order = $order;
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        $trackingLink = Crypt::encryptString($this->order->tracking_link);

        return new Content(
            view: 'emails.order-shipped',

        );
    }
}
