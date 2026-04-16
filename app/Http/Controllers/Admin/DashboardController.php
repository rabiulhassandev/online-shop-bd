<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use Illuminate\View\View;

class DashboardController extends Controller
{
    /**
     * Show the admin dashboard with key stats.
     */
    public function index(): View
    {
        $totalOrders = Order::count();
        $totalRevenue = Order::whereIn('status', ['confirmed', 'shipped', 'delivered'])->sum('total');
        $pendingOrders = Order::where('status', 'pending')->count();
        $todayOrders = Order::whereDate('created_at', today())->count();

        $recentOrders = Order::select(['id', 'order_number', 'customer_name', 'phone', 'total', 'status', 'created_at'])
            ->latest()
            ->limit(10)
            ->get();

        $lowStockProducts = Product::where('total_stock', '<', 5)
            ->where('is_active', true)
            ->select(['id', 'name', 'slug', 'total_stock'])
            ->orderBy('total_stock')
            ->get();

        return view('admin.dashboard', compact(
            'totalOrders',
            'totalRevenue',
            'pendingOrders',
            'todayOrders',
            'recentOrders',
            'lowStockProducts',
        ));
    }
}
