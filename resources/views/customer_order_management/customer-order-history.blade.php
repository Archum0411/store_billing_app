@extends('layouts.app')

@section('css')
<style>
    .history-page {
        --history-primary: #487fff;
        --history-ink: #20243a;
        --history-muted: #788096;
        --history-border: #e9eaf1;
        color: var(--history-ink);
    }

    .history-heading {
        margin-bottom: 1.5rem;
    }

    .history-heading h2 {
        margin-bottom: .35rem;
        font-weight: 700;
    }

    .history-heading p,
    .history-muted {
        color: var(--history-muted);
    }

    .history-search,
    .history-summary,
    .order-card {
        border: 1px solid var(--history-border);
        border-radius: 16px;
        background: #fff;
        box-shadow: 0 8px 26px rgba(34, 39, 68, .045);
    }

    .history-search {
        padding: 1.25rem;
    }

    .history-search .form-label {
        color: var(--history-ink);
        font-weight: 600;
    }

    .history-search .form-control {
        min-height: 46px;
        border-color: var(--history-border);
        border-radius: 10px;
    }

    .history-search .btn {
        min-height: 46px;
        border: 0;
        border-radius: 10px;
        background: var(--history-primary);
        font-weight: 600;
    }

    .history-summary {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 1rem;
        margin: 1.25rem 0;
        padding: 1.1rem 1.25rem;
    }

    .history-summary-label {
        display: block;
        margin-bottom: .2rem;
        color: var(--history-muted);
        font-size: .82rem;
    }

    .history-summary-value {
        font-size: 1.2rem;
        font-weight: 700;
    }

    .order-list {
        display: grid;
        gap: 1rem;
    }

    .order-card {
        overflow: hidden;
    }

    .order-card-header {
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
        gap: 1rem;
        padding: 1.1rem 1.25rem;
        border-bottom: 1px solid var(--history-border);
    }

    .order-number {
        margin: 0 0 .25rem;
        font-size: 1.05rem;
        font-weight: 700;
    }

    .order-date {
        color: var(--history-muted);
        font-size: .9rem;
    }

    .order-total {
        color: var(--history-primary);
        font-size: 1.2rem;
        font-weight: 700;
        white-space: nowrap;
    }

    .order-card-body {
        padding: 1rem 1.25rem 1.15rem;
    }

    .order-items {
        width: 100%;
        border-collapse: collapse;
    }

    .order-items th {
        padding: .55rem .5rem;
        color: var(--history-muted);
        font-size: .78rem;
        font-weight: 600;
        text-align: left;
        text-transform: uppercase;
    }

    .order-items td {
        padding: .75rem .5rem;
        border-top: 1px solid #f0f1f5;
        vertical-align: middle;
    }

    .order-items th:last-child,
    .order-items td:last-child {
        text-align: right;
    }

    .order-item-name {
        font-weight: 600;
    }

    .order-totals {
        display: flex;
        justify-content: flex-end;
        gap: 1.5rem;
        margin-top: 1rem;
        padding-top: .9rem;
        border-top: 1px dashed var(--history-border);
    }

    .order-total-label {
        display: block;
        color: var(--history-muted);
        font-size: .78rem;
    }

    .order-total-value {
        font-weight: 600;
    }

    .history-state {
        padding: 2rem 1rem;
        border: 1px dashed var(--history-border);
        border-radius: 16px;
        color: var(--history-muted);
        text-align: center;
    }

    .history-state i {
        display: block;
        margin-bottom: .65rem;
        color: var(--history-primary);
        font-size: 2rem;
    }

    @media (max-width: 575.98px) {
        .history-summary,
        .order-card-header {
            align-items: flex-start;
        }

        .order-card-header {
            flex-direction: column;
            gap: .45rem;
        }

        .order-totals {
            justify-content: space-between;
            gap: .75rem;
        }

        .order-items th,
        .order-items td {
            padding-right: .25rem;
            padding-left: .25rem;
        }
    }
</style>
@endsection

@section('content')
<div class="page-wrapper">
    <div class="page-content">
        <div class="container history-page py-3">
            <header class="history-heading">
                <h2>Customer Order History</h2>
                <p class="mb-0">Search by customer email to review orders and purchased items.</p>
            </header>

            <form id="searchForm" class="history-search">
                <div class="row align-items-end g-3">
                    <div class="col-12 col-lg-8">
                        <label for="email" class="form-label">Customer email</label>
                        <input
                            type="email"
                            class="form-control"
                            id="email"
                            name="email"
                            placeholder="name@example.com"
                            autocomplete="email"
                            required
                            value="{{ old('email') }}"
                        >
                    </div>
                    <div class="col-12 col-lg-4">
                        <button id="searchButton" type="submit" class="btn btn-primary w-100">
                            <i class="fa-solid fa-magnifying-glass me-2" aria-hidden="true"></i>
                            Search order history
                        </button>
                    </div>
                </div>
            </form>

            <div id="message" class="mt-3" role="status" aria-live="polite"></div>
            <section id="customerResults" class="mt-3" aria-live="polite">
                <div class="history-state">
                    <i class="fa-solid fa-receipt" aria-hidden="true"></i>
                    Enter a customer email to see their order history.
                </div>
            </section>
        </div>
    </div>
</div>
@endsection

@push('script')
<script>
(() => {
    const form = document.getElementById('searchForm');
    const emailInput = document.getElementById('email');
    const searchButton = document.getElementById('searchButton');
    const message = document.getElementById('message');
    const results = document.getElementById('customerResults');
    const historyUrl = @json(route('customer.order.history'));

    const formatCurrency = value => new Intl.NumberFormat(undefined, {
        style: 'currency',
        currency: 'INR'
    }).format(Number(value) || 0);

    const formatDate = value => {
        if (!value) {
            return 'Date unavailable';
        }

        const date = new Date(value);
        return Number.isNaN(date.getTime())
            ? 'Date unavailable'
            : new Intl.DateTimeFormat(undefined, {
                dateStyle: 'medium',
                timeStyle: 'short'
            }).format(date);
    };

    const createElement = (tag, className, text) => {
        const element = document.createElement(tag);
        if (className) {
            element.className = className;
        }
        if (text !== undefined) {
            element.textContent = text;
        }
        return element;
    };

    const showState = (icon, text) => {
        const state = createElement('div', 'history-state');
        state.appendChild(createElement('i', icon));
        state.appendChild(document.createTextNode(text));
        results.replaceChildren(state);
    };

    const renderOrder = order => {
        const card = createElement('article', 'order-card');
        const header = createElement('div', 'order-card-header');
        const headingGroup = document.createElement('div');
        headingGroup.appendChild(createElement('h3', 'order-number', `Order #${order.id}`));
        headingGroup.appendChild(createElement('div', 'order-date', formatDate(order.created_at)));
        header.appendChild(headingGroup);
        header.appendChild(createElement('div', 'order-total', formatCurrency(order.grand_total)));
        card.appendChild(header);

        const body = createElement('div', 'order-card-body');
        const table = createElement('table', 'order-items');
        const tableHead = document.createElement('thead');
        const headerRow = document.createElement('tr');
        ['Product', 'Qty', 'Unit price', 'Line total'].forEach(label => {
            headerRow.appendChild(createElement('th', '', label));
        });
        tableHead.appendChild(headerRow);
        table.appendChild(tableHead);

        const tableBody = document.createElement('tbody');
        const items = Array.isArray(order.items) ? order.items : [];
        if (!items.length) {
            const emptyRow = document.createElement('tr');
            const emptyCell = createElement('td', 'history-muted', 'No item details available for this order.');
            emptyCell.colSpan = 4;
            emptyRow.appendChild(emptyCell);
            tableBody.appendChild(emptyRow);
        } else {
            items.forEach(item => {
                const row = document.createElement('tr');
                const productName = item.product?.product_name || item.product_name || 'Product unavailable';
                row.appendChild(createElement('td', 'order-item-name', productName));
                row.appendChild(createElement('td', '', item.quantity ?? 0));
                row.appendChild(createElement('td', '', formatCurrency(item.unit_price ?? item.price)));
                row.appendChild(createElement('td', '', formatCurrency(item.line_total ?? (Number(item.unit_price ?? item.price) * Number(item.quantity)))));
                tableBody.appendChild(row);
            });
        }
        table.appendChild(tableBody);
        body.appendChild(table);

        const totals = createElement('div', 'order-totals');
        [
            ['Subtotal', order.subtotal],
            ['Tax', order.tax_total],
            ['Total', order.grand_total]
        ].forEach(([label, amount]) => {
            const total = document.createElement('div');
            total.appendChild(createElement('span', 'order-total-label', label));
            total.appendChild(createElement('span', 'order-total-value', formatCurrency(amount)));
            totals.appendChild(total);
        });
        body.appendChild(totals);
        card.appendChild(body);

        return card;
    };

    form.addEventListener('submit', async event => {
        event.preventDefault();
        message.replaceChildren();
        message.className = 'mt-3';
        searchButton.disabled = true;
        searchButton.innerHTML = '<span class="spinner-border spinner-border-sm me-2" aria-hidden="true"></span>Loading...';
        showState('fa-solid fa-spinner fa-spin', 'Loading order history...');

        try {
            const response = await fetch(
                `${historyUrl}?email=${encodeURIComponent(emailInput.value.trim())}`,
                { headers: { Accept: 'application/json' } }
            );
            const data = await response.json();

            if (!response.ok) {
                const validationMessage = data.errors?.email?.[0];
                throw new Error(validationMessage || data.message || 'Unable to load order history.');
            }

            const orders = Array.isArray(data.orders) ? data.orders : [];
            if (!orders.length) {
                showState('fa-regular fa-folder-open', 'No orders found for this customer.');
                return;
            }

            const totalSpent = orders.reduce(
                (sum, order) => sum + (Number(order.grand_total) || 0),
                0
            );

            const summary = createElement('div', 'history-summary');
            const customer = document.createElement('div');
            customer.appendChild(createElement('span', 'history-summary-label', 'Customer'));
            customer.appendChild(createElement(
                'strong',
                'history-summary-value',
                data.customer?.name || 'Customer'
            ));
            customer.appendChild(createElement(
                'div',
                'history-muted',
                data.customer?.email || emailInput.value.trim()
            ));
            summary.appendChild(customer);

            const stats = document.createElement('div');
            stats.className = 'text-end';
            stats.appendChild(createElement('span', 'history-summary-label', `${orders.length} order${orders.length === 1 ? '' : 's'}`));
            stats.appendChild(createElement('strong', 'history-summary-value', formatCurrency(totalSpent)));
            summary.appendChild(stats);

            const orderList = createElement('div', 'order-list');
            orders.forEach(order => orderList.appendChild(renderOrder(order)));
            results.replaceChildren(summary, orderList);
        } catch (error) {
            showState('fa-solid fa-triangle-exclamation', error.message || 'Unable to load order history.');
        } finally {
            searchButton.disabled = false;
            searchButton.innerHTML = '<i class="fa-solid fa-magnifying-glass me-2" aria-hidden="true"></i>Search order history';
        }
    });
})();
</script>
@endpush
