<?php

namespace App\Mail;

use App\Models\Order;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class OrderConfirmationMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public Order $order
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Order confirmation - Order #'.$this->order->id,
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.orders.confirmation',
        );
    }

    public function build(): self
    {
        $bill = Pdf::loadView('billing_management.bill-pdf', [
            'order' => $this->order,
        ])->output();

        return $this->attachData($bill, 'order-'.$this->order->id.'-bill.pdf', [
            'mime' => 'application/pdf',
        ]);
    }
}
