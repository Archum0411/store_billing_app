<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Bill #{{ $order->id }}</title>
    <style>
        body { color: #28364b; font-family: DejaVu Sans, sans-serif; font-size: 12px; }
        .header { margin-bottom: 24px; width: 100%; }
        .header td { vertical-align: top; }
        .right { text-align: right; }
        h1 { margin: 0 0 4px; font-size: 22px; }
        h2 { margin: 24px 0 8px; font-size: 15px; }
        table.items { width: 100%; border-collapse: collapse; margin-top: 20px; }
        .items th, .items td { border-bottom: 1px solid #dfe4ec; padding: 9px 6px; text-align: left; }
        .items th { background: #f3f6fa; }
        .items .right { text-align: right; }
        table.totals { width: 260px; margin: 20px 0 0 auto; border-collapse: collapse; }
        .totals td { padding: 6px; }
        .grand-total { border-top: 1px solid #28364b; font-size: 15px; font-weight: bold; }
    </style>
</head>
<body>
    <table class="header">
        <tr>
            <td>
                <h1>Store Billing</h1>
                <div>Order invoice</div>
            </td>
            <td class="right">
                <strong>Bill #{{ $order->id }}</strong><br>
                {{ $order->created_at?->format('d M Y, h:i A') }}
            </td>
        </tr>
    </table>

    <h2>Customer</h2>
    <div>{{ $order->customer->customer_name }}</div>
    <div>{{ $order->customer->email }}</div>

    <table class="items">
        <thead>
            <tr>
                <th>Product</th>
                <th class="right">Qty</th>
                <th class="right">Unit price</th>
                <th class="right">Tax</th>
                <th class="right">Line total</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($order->items as $item)
                <tr>
                    <td>{{ $item->product?->product_name ?? 'Product unavailable' }}</td>
                    <td class="right">{{ $item->quantity }}</td>
                    <td class="right">₹{{ number_format((float) $item->unit_price, 2) }}</td>
                    <td class="right">{{ number_format((float) $item->tax_percentage, 2) }}%</td>
                    <td class="right">₹{{ number_format((float) $item->line_total, 2) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <table class="totals">
        <tr>
            <td>Subtotal</td>
            <td class="right">₹{{ number_format((float) $order->subtotal, 2) }}</td>
        </tr>
        <tr>
            <td>Tax</td>
            <td class="right">₹{{ number_format((float) $order->tax_total, 2) }}</td>
        </tr>
        <tr class="grand-total">
            <td>Grand total</td>
            <td class="right">₹{{ number_format((float) $order->grand_total, 2) }}</td>
        </tr>
    </table>
</body>
</html>
