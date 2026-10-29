
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bill #{{ $order->id }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
          rel="stylesheet">
    <style>
        body { background:#f3f6fa; color:#28364b; }
        .bill {
            max-width:850px; margin:35px auto; padding:35px;
            background:white; border:1px solid #e2e8f0;
            border-radius:12px;
        }
        @media print {
            .no-print { display:none !important; }
            .bill { margin:0; border:0; }
        }
    </style>
</head>
<body>
<div class="bill">
    <div class="d-flex justify-content-between">
        <div>
            <h2 class="fw-bold">Store Billing</h2>
            <p class="text-secondary">Order Invoice</p>
        </div>
        <div class="text-end">
            <h5>Bill #{{ $order->id }}</h5>
            {{ $order->created_at->format('d M Y, h:i A') }}
        </div>
    </div>

    <hr>

    <h5>Customer Details</h5>
    <div>{{ $order->customer->customer_name }}</div>
    <div>{{ $order->customer->email }}</div>

    <div class="table-responsive mt-4">
        <table class="table">
            <thead>
            <tr>
                <th>Product</th>
                <th>Qty</th>
                <th>Price</th>
                <th>Tax</th>
                <th class="text-end">Line Total</th>
            </tr>
            </thead>
            <tbody>
            @foreach ($order->items as $item)
                <tr>
                    <td>{{ $item->product->product_name }}</td>
                    <td>{{ $item->quantity }}</td>
                    <td>₹{{ number_format((float)$item->unit_price, 2) }}</td>
                    <td>{{ number_format((float)$item->tax_percentage, 2) }}%</td>
                    <td class="text-end">
                        ₹{{ number_format((float)$item->line_total, 2) }}
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>

    <div class="row justify-content-end">
        <div class="col-sm-6">
            <div class="d-flex justify-content-between mb-2">
                <span>Subtotal</span>
                <strong>₹{{ number_format((float)$order->subtotal, 2) }}</strong>
            </div>
            <div class="d-flex justify-content-between mb-2">
                <span>Tax</span>
                <strong>₹{{ number_format((float)$order->tax_total, 2) }}</strong>
            </div>
            <hr>
            <div class="d-flex justify-content-between fs-5">
                <strong>Grand Total</strong>
                <strong>₹{{ number_format((float)$order->grand_total, 2) }}</strong>
            </div>
        </div>
    </div>

    <div class="mt-4 d-flex gap-2 no-print">
        <button class="btn btn-primary" onclick="window.print()">
            Print Bill
        </button>
        <a href="{{ route('billing.create') }}"
           class="btn btn-outline-secondary">
            New Order
        </a>
    </div>
</div>
</body>
</html>