<?php

namespace App\Http\Controllers;
use App\Models\Customers;
use App\Models\Order;
use App\Models\Products;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    public function index()
    {
        $todaySales = Order::whereDate('created_at', today())
            ->sum('grand_total');

        $todayOrders = Order::whereDate('created_at', today())
            ->count();

        $totalProducts = Products::count();

        $lowStockProducts = Products::where('stock_on_hand', '<=', 10)
            ->orderBy('stock_on_hand')
            ->get();

        $recentOrders = Order::with('customer')
            ->latest()
            ->take(5)
            ->get();

        $salesChart = Order::select(
                DB::raw('DATE(created_at) as sale_date'),
                DB::raw('SUM(grand_total) as total')
            )
            ->where('created_at', '>=', now()->subDays(6)->startOfDay())
            ->groupBy(DB::raw('DATE(created_at)'))
            ->orderBy('sale_date')
            ->get();

        return view('admin.dashboard', compact(
            'todaySales',
            'todayOrders',
            'totalProducts',
            'lowStockProducts',
            'recentOrders',
            'salesChart'
        ));
    }
}
