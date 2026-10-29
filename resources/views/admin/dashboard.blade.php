@extends('layouts.app', ['title' => 'Dashboard'])
@section('css')
<style>
.dashboard-card {
    padding: 20px;
    border: 1px solid #e5e7eb;
    border-radius: 10px;
    background: #fff;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
    height: 100%;
}

.dashboard-card h6 {
    font-size: 14px;
    color: #6b7280;
    margin-bottom: 12px;
}

.dashboard-card h3 {
    font-size: 28px;
    font-weight: 700;
    margin-bottom: 0;
    color: #1f2937;
}

.stat-card {
    border: 0;
    border-radius: 14px;
    box-shadow: 0 4px 18px #1720330b;
    height: 100%;
}

.stat-number {
    font-size: 28px;
    font-weight: 700;
}

.panel {
    background: white;
    border-radius: 14px;
    padding: 22px;
    box-shadow: 0 4px 18px #1720330b;
}
</style>
@endsection
@section('content')
<div class="page-wrapper">
    <div class="page-content">

        <div class="container-fluid">

            {{-- Welcome Section --}}
            <div class="row align-items-center mb-4">
                <div class="col-12 col-lg-5">
                    <h2 class="fw-bold mb-1">Dashboard</h2>
                    <h4 class="font-weight-bold">
                        Welcome, {{ Auth::user()->name }}
                    </h4>
                    <p class="text-secondary mb-0">
                        Retail sales and inventory overview
                    </p>
                </div>
            </div>
            <main class="col-md-10 p-4 p-lg-5">
            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            <div class="row g-4 mb-4">

                <div class="col-sm-6 col-xl-3">
                    <div class="card stat-card">
                        <div class="card-body p-4">
                            <div class="text-secondary">Today's Sales</div>
                            <div class="stat-number text-primary">
                                ₹{{ number_format($todaySales, 2) }}
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-sm-6 col-xl-3">
                    <div class="card stat-card">
                        <div class="card-body p-4">
                            <div class="text-secondary">Today's Orders</div>
                            <div class="stat-number text-success">
                                {{ $todayOrders }}
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-sm-6 col-xl-3">
                    <div class="card stat-card">
                        <div class="card-body p-4">
                            <div class="text-secondary">Total Products</div>
                            <div class="stat-number">
                                {{ $totalProducts }}
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-sm-6 col-xl-3">
                    <div class="card stat-card">
                        <div class="card-body p-4">
                            <div class="text-secondary">Low Stock Items</div>
                            <div class="stat-number text-danger">
                                {{ $lowStockProducts->count() }}
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </main>

        </div>
    </div>
</div>
@endsection