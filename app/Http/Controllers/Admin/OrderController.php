<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\StreamedResponse;

class OrderController extends Controller
{
    /**
     * List orders with optional status filter and search.
     */
    public function index(Request $request): View
    {
        $orders = Order::query()
            ->when($request->filled('status'), fn ($q) => $q->where('status', $request->status))
            ->when($request->filled('search'), function ($q) use ($request) {
                $q->where('order_number', 'like', "%{$request->search}%")
                    ->orWhere('phone', 'like', "%{$request->search}%");
            })
            ->latest()
            ->paginate(20)
            ->withQueryString();

        $statusCounts = Order::query()
            ->selectRaw('status, COUNT(*) as count')
            ->groupBy('status')
            ->pluck('count', 'status')
            ->toArray();

        return view('admin.orders.index', compact('orders', 'statusCounts'));
    }

    /**
     * Show a single order's details.
     */
    public function show(Order $order): View
    {
        return view('admin.orders.show', compact('order'));
    }

    /**
     * Update the status of an order.
     */
    public function updateStatus(Request $request, Order $order): RedirectResponse
    {
        $request->validate([
            'status' => ['required', 'in:pending,confirmed,shipped,delivered,cancelled'],
        ]);

        $order->update(['status' => $request->status]);

        return back()->with('success', 'অর্ডার স্ট্যাটাস আপডেট হয়েছে।');
    }

    /**
     * Export orders to CSV.
     */
    public function export(Request $request): StreamedResponse
    {
        $orders = Order::query()
            ->when($request->filled('status'), fn ($q) => $q->where('status', $request->status))
            ->latest()
            ->get();

        $headers = [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="orders-'.now()->format('Y-m-d').'.csv"',
        ];

        return response()->streamDownload(function () use ($orders): void {
            $handle = fopen('php://output', 'w');

            // BOM for Excel UTF-8 support
            fwrite($handle, "\xEF\xBB\xBF");

            fputcsv($handle, ['Order #', 'Customer', 'Phone', 'Address', 'Total (BDT)', 'Payment', 'Status', 'Date']);

            foreach ($orders as $order) {
                fputcsv($handle, [
                    $order->order_number,
                    $order->customer_name,
                    $order->phone,
                    $order->address,
                    $order->total,
                    $order->payment_method,
                    $order->status,
                    $order->created_at->format('Y-m-d H:i'),
                ]);
            }

            fclose($handle);
        }, "orders-{$this->date()}.csv", $headers);
    }

    /**
     * Get today's date string for filenames.
     */
    private function date(): string
    {
        return now()->format('Y-m-d');
    }
}
