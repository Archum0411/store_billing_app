<?php

namespace App\Jobs;

use App\Mail\OrderConfirmationMail;
use App\Models\Order;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class SendOrderConfirmationJob implements ShouldQueue
{

    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $tries = 3;

    /**
     * Create a new job instance.
     */
    public function __construct(
        public int $orderId
    ) {}
    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $order = Order::with(['customer', 'items.product'])
            ->find($this->orderId);

        if (!$order) {
            Log::warning('Order confirmation skipped: order not found.', [
                'order_id' => $this->orderId,
            ]);

            return;
        }

        $email = $order->customer?->email;

        if (!$email) {
            Log::warning('Order confirmation skipped: customer email not found.', [
                'order_id' => $order->id,
                'customer_id' => $order->customer_id,
            ]);

            return;
        }

        Mail::to($email)->send(new OrderConfirmationMail($order));

        Log::info('Order confirmation email sent.', [
            'order_id' => $order->id,
            'customer_email' => $email,
        ]);
    }
}
