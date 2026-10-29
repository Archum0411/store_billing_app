<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Order confirmation</title>
</head>
<body style="margin:0;padding:24px;background:#f3f6fa;color:#28364b;font-family:Arial,sans-serif">
    <div style="max-width:640px;margin:0 auto;padding:28px;background:#fff;border:1px solid #e2e8f0;border-radius:12px">
        <h1 style="margin:0 0 16px;font-size:24px">Thank you for your order, {{ $order->customer->customer_name }}!</h1>
        <p style="margin:0 0 20px;line-height:1.6">
            Your order <strong>#{{ $order->id }}</strong> has been confirmed.
            A copy of your bill is attached to this email.
        </p>

        <table style="width:100%;border-collapse:collapse">
            <thead>
                <tr>
                    <th style="padding:10px 6px;border-bottom:1px solid #e2e8f0;text-align:left">Item</th>
                    <th style="padding:10px 6px;border-bottom:1px solid #e2e8f0;text-align:right">Qty</th>
                    <th style="padding:10px 6px;border-bottom:1px solid #e2e8f0;text-align:right">Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($order->items as $item)
                    <tr>
                        <td style="padding:10px 6px;border-bottom:1px solid #f0f2f5">
                            {{ $item->product?->product_name ?? 'Product unavailable' }}
                        </td>
                        <td style="padding:10px 6px;border-bottom:1px solid #f0f2f5;text-align:right">
                            {{ $item->quantity }}
                        </td>
                        <td style="padding:10px 6px;border-bottom:1px solid #f0f2f5;text-align:right">
                            ₹{{ number_format((float) $item->line_total, 2) }}
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <p style="margin:20px 0 0;text-align:right;font-size:18px">
            <strong>Order total: ₹{{ number_format((float) $order->grand_total, 2) }}</strong>
        </p>
        <p style="margin:24px 0 0;color:#788096;font-size:13px">
            This is an automated order confirmation from Store Billing.
        </p>
    </div>
</body>
</html>
