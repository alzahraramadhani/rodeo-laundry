<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Order;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Carbon\Carbon;

class AdminDashboardController extends Controller
{
    public function index(Request $request)
    {
        $totalOrders = Order::count();

        // Tanggal yang dipilih (default hari ini)
        $selectedDate = $request->query('date', Carbon::today()->toDateString());
        $isDateFiltered = $request->filled('date');

        // Total pendapatan pada tanggal terpilih
        $todayRevenue = Payment::where('status', 'completed')
            ->whereDate('created_at', $selectedDate)
            ->sum('amount');

        if (!$isDateFiltered && $todayRevenue == 0) {
            $todayRevenue = Payment::where('status', 'completed')->sum('amount');
        }

        $activeCustomers = Customer::count();

        $activeMachineQueue = Order::whereIn('status', ['pending', 'processing'])->count();
        $urgentCount = Order::where('status', 'processing')->count();

        // Query pesanan terbaru dengan filter status jika ada
        $query = Order::with(['customer', 'items.service'])->latest();

        if ($request->filled('status') && $request->status !== 'all') {
            $query->where('status', $request->status);
        }

        if ($request->filled('search')) {
            $search = trim($request->search);
            $cleanNumeric = preg_replace('/[^0-9]/', '', $search);

            $query->where(function ($q) use ($search, $cleanNumeric) {
                $q->where('id', 'like', "%{$search}%");
                if (!empty($cleanNumeric)) {
                    $q->orWhere('id', (int)$cleanNumeric);
                }
                $q->orWhereHas('customer', function ($cq) use ($search) {
                    $cq->where('name', 'like', "%{$search}%")
                       ->orWhere('phone', 'like', "%{$search}%");
                });
            });
        }

        $recentOrders = $query->paginate(10)->withQueryString();

        return view('admin.dashboard', compact(
            'totalOrders',
            'todayRevenue',
            'selectedDate',
            'isDateFiltered',
            'activeCustomers',
            'activeMachineQueue',
            'urgentCount',
            'recentOrders'
        ));
    }

    public function updateOrderStatus(Request $request, Order $order)
    {
        $request->validate([
            'status' => ['required', Rule::in(['pending', 'processing', 'ready', 'completed', 'cancelled'])],
        ]);

        $order->update(['status' => $request->status]);

        return back()->with('success', 'Status pesanan #RD-' . str_pad($order->id, 4, '0', STR_PAD_LEFT) . ' diperbarui.');
    }
}
