<?php

namespace App\Mail;

use App\Models\OrderReturns as ModelsOrderReturns;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class OrderReturns extends Mailable
{
    use Queueable, SerializesModels;
    public $order;
    public $status;
    /**
     * Create a new message instance.
     */
    public function __construct(ModelsOrderReturns $order, string $status)
    {
        $this->status = $status;
        $this->order = $order;
    }

    public function build()
    {
        return $this->subject("Order #{$this->order->order->order_number} Status: {$this->status}")
            ->view('emails.order-return-status')
            ->from(config('mail.from.address'), config('mail.from.name'));
    }
    public function attachments(): array
    {
        return [];
    }
}
