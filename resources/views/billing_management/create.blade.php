@extends('layouts.app')
@section('css')
@endsection
<style>
    .page {
        padding: 28px;
    }

    .section-title {
        font-size: 15px;
        font-weight: bold;
        margin-bottom: 10px;
    }

    .field-label {
        font-size: 12px;
        font-weight: bold;
        margin: 0 0 4px 7px;
    }

    .form-control, .form-select {
        border: 1px solid #8fa2bf;
        border-radius: 5px;
        font-size: 13px;
        min-height: 38px;
    }

    .form-control:focus, .form-select:focus {
        border-color: #3378b9;
        box-shadow: 0 0 0 2px #3378b922;
    }

    .customer-grid {
        display: grid;
        grid-template-columns: minmax(220px, 300px)
                                minmax(220px, 300px);
        gap: 24px;
        margin-bottom: 30px;
    }

    .main-grid {
        display: grid;
        grid-template-columns: minmax(0, 2fr)
                                minmax(250px, 1fr);
        gap: 24px;
    }

    .table-wrap {
        border: 1px solid #8fa2bf;
        border-radius: 6px;
        overflow-x: auto;
    }

    .product-table {
        width: 100%;
        border-collapse: collapse;
    }

    .product-table th {
        background: #e2e8f0;
        padding: 10px;
        text-align: left;
        white-space: nowrap;
    }

    .product-table td {
        padding: 7px;
        border-top: 1px solid #a0afc5;
    }

    .product-table .form-select,
    .product-table .form-control {
        min-width: 75px;
        min-height: 32px;
        padding: 5px;
    }

    .add-row {
        background: white;
        border: 0;
        border-top: 1px solid #8fa2bf;
        color: #8da0bd;
        width: 100%;
        padding: 9px;
        text-align: left;
    }

    .btn-add {
        background: #3378b9;
        color: white;
        border: 0;
        border-radius: 6px;
        padding: 10px 22px;
        font-weight: bold;
    }

    .stock-alert {
        border: 1px solid #ed7900;
        background: #fffbed;
        border-radius: 6px;
        padding: 14px;
        color: #95420b;
        min-height: 220px;
    }

    .stock-alert h6 {
        font-weight: bold;
        margin-bottom: 14px;
    }

    .stock-alert li {
        font-size: 11px;
        margin-bottom: 12px;
    }

    .payment-grid {
        display: grid;
        grid-template-columns: minmax(330px, 1fr)
                                minmax(180px, .75fr);
        gap: 30px;
        margin-top: 18px;
    }

    .payment-card {
        background: #f0f4f8;
        border: 1px solid #8fa2bf;
        border-radius: 5px;
        padding: 14px;
    }

    .total-row {
        display: flex;
        justify-content: space-between;
        margin-bottom: 10px;
    }

    .amount-section {
        border-top: 1px dashed #8fa2bf;
        padding-top: 10px;
    }

    .amount-section label {
        font-weight: bold;
        margin-bottom: 5px;
    }

    .balance {
        display: flex;
        justify-content: space-between;
        margin-top: 20px;
        font-weight: bold;
        gap: 10px;
    }

    .generate-btn {
        width: 100%;
        max-width: 205px;
        background: #148342;
        color: white;
        border: 0;
        border-radius: 6px;
        padding: 13px;
        font-weight: bold;
    }

    .generate-btn:hover {
        background: #106c36;
    }

    .hint {
        color: #607491;
        font-size: 10px;
        line-height: 1.6;
        margin-top: 10px;
    }

    @media (max-width: 768px) {
        .page { padding: 18px 12px; }
        .customer-grid, .main-grid, .payment-grid {
            grid-template-columns: 1fr;
        }
        .topbar { padding: 15px; }
        .topbar h4 { font-size: 16px; }
        .topbar small { display: none; }
    }
</style>
@section('content')
    <div class="page-wrapper">
        <div class="page-content">

            <div class="container">
                <div class="d-flex justify-content-between">
                    <h2>Store Billing - New Order</h2>
                </div>
                <hr>

                <div id="stepper1" class="bs-stepper">
                    <div class="card">
                        <div class="card-body">
                            <div class="bs-stepper-content">
                                @if ($errors->any())
                                    <div class="alert alert-danger">
                                        <strong>Please check your order:</strong>
                                        <ul class="mb-0 mt-1">
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif

                                <form id="orderForm" method="POST"
                                    action="{{ route('billing.store') }}">
                                    @csrf


                                    <div class="customer-grid">
                                        <div>
                                            <label class="field-label" for="customer_email">
                                                Customer Email
                                            </label>
                                            <input type="email" id="customer_email"
                                                name="customer_email" class="form-control"
                                                value="{{ old('customer_email') }}"
                                                placeholder="e.g. admin@example.com" required>
                                        </div>

                                        <div>
                                            <label class="field-label" for="customer_name">
                                                Customer Name
                                            </label>
                                            <input type="text" id="customer_name"
                                                name="customer_name" class="form-control"
                                                value="{{ old('customer_name') }}"
                                                placeholder="Auto-filled if email exists" required>
                                        </div>
                                    </div>

                                    <div class="main-grid">
                                        <section>
                                            <h5 class="section-title">Products</h5>

                                            <div class="table-wrap">
                                                <table class="product-table">
                                                    <thead>
                                                    <tr>
                                                        <th style="width:43%">Product</th>
                                                        <th style="width:15%">Qty</th>
                                                        <th style="width:17%">Price</th>
                                                        <th style="width:20%">Line Total</th>
                                                        <th></th>
                                                    </tr>
                                                    </thead>
                                                    <tbody id="productRows">
                                                    <tr class="product-row">
                                                        <td>
                                                            <select name="items[0][product_id]"
                                                                    class="form-select product-select"
                                                                    required>
                                                                <option value="">Select product</option>
                                                                @foreach ($products as $product)
                                                                    <option
                                                                        value="{{ $product->id }}"
                                                                        data-price="{{ $product->price }}"
                                                                        data-tax="{{ $product->tax_percentage }}"
                                                                        data-stock="{{ $product->stock_on_hand }}">
                                                                        {{ $product->product_name }}
                                                                        — {{ $product->stock_on_hand }} left
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                        </td>
                                                        <td>
                                                            <input type="number"
                                                                name="items[0][quantity]"
                                                                class="form-control qty-input"
                                                                value="1" min="1" required>
                                                        </td>
                                                        <td class="price-cell">₹0.00</td>
                                                        <td class="line-cell">₹0.00</td>
                                                        <td>
                                                            <button type="button"
                                                                    class="btn btn-sm text-danger remove-row"
                                                                    aria-label="Remove product">×</button>
                                                        </td>
                                                    </tr>
                                                    </tbody>
                                                </table>

                                                <button type="button" id="addRow" class="add-row">
                                                    + dropdown to add product row
                                                </button>
                                            </div>

                                            <div class="text-end mt-2">
                                                <button type="button" id="addProduct"
                                                        class="btn-add">+ Add Product</button>
                                            </div>
                                        </section>

                                        <aside class="stock-alert">
                                            <h6>⚠ Low Stock Alert</h6>
                                            <ul class="list-unstyled mb-0">
                                                @forelse ($lowStockProducts as $product)
                                                    <li>
                                                        • {{ $product->product_name }}
                                                        — {{ $product->stock_on_hand }} units left
                                                    </li>
                                                @empty
                                                    <li>No low-stock products.</li>
                                                @endforelse
                                            </ul>
                                        </aside>
                                    </div>

                                    <div class="payment-grid">
                                        <section>
                                            <h5 class="section-title">Payment</h5>

                                            <div class="payment-card">
                                                <div class="total-row">
                                                    <span>Subtotal</span>
                                                    <strong id="subtotal">₹0.00</strong>
                                                </div>

                                                <div class="total-row">
                                                    <span>Tax</span>
                                                    <strong id="taxTotal">₹0.00</strong>
                                                </div>

                                                <div class="total-row">
                                                    <span>Grand Total</span>
                                                    <strong id="grandTotal">₹0.00</strong>
                                                </div>

                                                <div class="amount-section">
                                                    <label for="amount_given">
                                                        Amount Given by Customer
                                                    </label>
                                                    <input type="number" id="amount_given"
                                                        name="amount_given" min="0" step="0.01"
                                                        class="form-control"
                                                        value="{{ old('amount_given') }}"
                                                        placeholder="₹250">
                                                </div>

                                                <div class="balance">
                                                    <span>Balance to Return:</span>
                                                    <span id="balance">₹0.00</span>
                                                </div>
                                            </div>
                                        </section>

                                        <section class="pt-md-4">
                                            <button type="submit" class="generate-btn mt-2">
                                                Generate Bill
                                            </button>
                                            <p class="hint">
                                                → Creates the bill page<br>
                                                → Updates stock after successful order
                                            </p>
                                        </section>
                                    </div>
                                </form>
                            </div>

                        </div>
                    </div>
                </div>
                <!--end stepper one-->
            </div>
        </div>
    </div>
@endsection

@push('script')
<script>
document.addEventListener('DOMContentLoaded', function () {

    const emailInput = document.getElementById('customer_email');
    const nameInput = document.getElementById('customer_name');

    let timer;

    emailInput.addEventListener('input', function () {
        clearTimeout(timer);

        const email = this.value.trim();

        if (!email || !email.includes('@')) {
            return;
        }

        timer = setTimeout(async function () {
            try {
                const url = new URL(
                    @json(route('billing.customer')),
                    window.location.origin
                );

                url.searchParams.set('email', email);

                const response = await fetch(url, {
                    headers: {
                        'Accept': 'application/json'
                    }
                });

                if (!response.ok) return;

                const data = await response.json();

                if (data.exists) {
                    // Existing customer: auto-fill the name.
                    nameInput.value = data.name;
                } else {
                    // New email: allow manual name entry.
                    nameInput.value = '';
                }
            } catch (error) {
                console.error('Customer lookup failed:', error);
            }
        }, 300);
    });

});
</script>
@endpush
@push('script')
<script>
(() => {
    const rows = document.getElementById('productRows');
    const money = value =>
        '₹' + Number(value || 0).toFixed(2);

    let rowIndex = 1;

    function calculateTotals() {
        let subtotal = 0;
        let taxTotal = 0;

        rows.querySelectorAll('.product-row').forEach(row => {
            const select = row.querySelector('.product-select');
            const qtyInput = row.querySelector('.qty-input');
            const option = select.selectedOptions[0];

            const price = Number(option?.dataset.price || 0);
            const taxRate = Number(option?.dataset.tax || 0);
            const stock = Number(option?.dataset.stock || 0);
            const qty = Number(qtyInput.value || 0);

            const lineSubtotal = price * qty;
            const lineTax = lineSubtotal * taxRate / 100;

            subtotal += lineSubtotal;
            taxTotal += lineTax;

            row.querySelector('.price-cell').textContent = money(price);
            row.querySelector('.line-cell').textContent =
                money(lineSubtotal + lineTax);

            qtyInput.setCustomValidity(
                option?.value && qty > stock
                    ? `Only ${stock} units are available.`
                    : ''
            );
        });

        subtotal = Math.round((subtotal + Number.EPSILON) * 100) / 100;
        taxTotal = Math.round((taxTotal + Number.EPSILON) * 100) / 100;

        const grandTotal = subtotal + taxTotal;
        const amount = Number(
            document.getElementById('amount_given').value || 0
        );

        document.getElementById('subtotal').textContent = money(subtotal);
        document.getElementById('taxTotal').textContent = money(taxTotal);
        document.getElementById('grandTotal').textContent = money(grandTotal);

        const difference = amount - grandTotal;

        document.getElementById('balance').textContent =
            difference >= 0
                ? money(difference) + ' change'
                : money(-difference) + ' due';
    }

    function addProductRow() {
        const firstSelect = rows.querySelector('.product-select');
        const newRow = rows.querySelector('.product-row').cloneNode(true);

        newRow.querySelector('.product-select').value = '';
        newRow.querySelector('.product-select').name =
            `items[${rowIndex}][product_id]`;

        const qty = newRow.querySelector('.qty-input');
        qty.name = `items[${rowIndex}][quantity]`;
        qty.value = 1;
        qty.setCustomValidity('');

        newRow.querySelector('.price-cell').textContent = '₹0.00';
        newRow.querySelector('.line-cell').textContent = '₹0.00';

        rows.appendChild(newRow);
        rowIndex++;
        updateProductOptions();
        calculateTotals();
    }

    function updateProductOptions() {
        const selectedIds = [...rows.querySelectorAll('.product-select')]
            .map(select => select.value)
            .filter(Boolean);

        rows.querySelectorAll('.product-select').forEach(select => {
            [...select.options].forEach(option => {
                if (!option.value) return;

                option.disabled =
                    selectedIds.includes(option.value) &&
                    select.value !== option.value;
            });
        });
    }

    document.getElementById('addRow')
        .addEventListener('click', addProductRow);

    document.getElementById('addProduct')
        .addEventListener('click', addProductRow);

    rows.addEventListener('change', event => {
        if (event.target.matches('.product-select')) {
            updateProductOptions();
        }
        calculateTotals();
    });

    rows.addEventListener('input', calculateTotals);

    rows.addEventListener('click', event => {
        const button = event.target.closest('.remove-row');
        if (!button) return;

        const allRows = rows.querySelectorAll('.product-row');

        if (allRows.length === 1) {
            const row = allRows[0];
            row.querySelector('.product-select').value = '';
            row.querySelector('.qty-input').value = 1;
        } else {
            button.closest('.product-row').remove();
        }

        updateProductOptions();
        calculateTotals();
    });

    document.getElementById('amount_given')
        .addEventListener('input', calculateTotals);

    // Auto-fill customer name when the email already exists.
    const emailInput = document.getElementById('customer_email');
    let lookupTimer;

    emailInput.addEventListener('input', () => {
        clearTimeout(lookupTimer);

        const email = emailInput.value.trim();
        if (!email.includes('@')) return;

        lookupTimer = setTimeout(async () => {
            try {
                const url = new URL(
                    @json(route('billing.customer')),
                    window.location.origin
                );
                url.searchParams.set('email', email);

                const response = await fetch(url, {
                    headers: { Accept: 'application/json' }
                });

                if (!response.ok) return;

                const result = await response.json();

                if (result.exists) {
                    document.getElementById('customer_name').value =
                        result.name || '';
                }
            } catch (error) {
                console.error('Customer lookup failed.');
            }
        }, 300);
    });

    document.getElementById('orderForm').addEventListener('submit', event => {
        const selected = [...rows.querySelectorAll('.product-select')]
            .filter(select => select.value);

        if (!selected.length) {
            event.preventDefault();
            alert('Please select at least one product.');
            return;
        }

        const ids = selected.map(select => select.value);

        if (new Set(ids).size !== ids.length) {
            event.preventDefault();
            alert('Each product can be added only once.');
        }
    });

    calculateTotals();
})();
</script>
@endpush