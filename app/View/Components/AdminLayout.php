<?php

namespace App\View\Components;

use App\Models\Delivery;
use App\Models\Order;
use App\Models\Payment;
use Illuminate\Support\Str;
use Illuminate\View\Component;
use Illuminate\View\View;

class AdminLayout extends Component
{
    public ?string $title;

    public function __construct(?string $title = null)
    {
        $this->title = $title;
    }

    /**
     * Mengumpulkan pemberitahuan operasional terkini untuk admin
     */
    protected function getNotifications(): array
    {
        $notifications = [];

        try {
            // 1. Pesanan Baru Masuk (Status Pending / Antrian)
            $pendingOrders = Order::with('customer', 'items.service')
                ->where('status', 'pending')
                ->latest()
                ->take(4)
                ->get();

            foreach ($pendingOrders as $order) {
                $customerName = $order->customer ? $order->customer->name : 'Pelanggan';
                $itemCount = $order->items ? $order->items->count() : 0;
                $notifications[] = [
                    'id' => 'order-pending-' . $order->id,
                    'type' => 'order_pending',
                    'category' => 'Pesanan Baru',
                    'title' => 'Pesanan Baru Masuk #RD-' . str_pad($order->id, 4, '0', STR_PAD_LEFT),
                    'message' => "{$customerName} memesan {$itemCount} layanan • Rp " . number_format($order->total_price, 0, ',', '.'),
                    'time' => $order->created_at ? $order->created_at->diffForHumans() : 'Baru saja',
                    'timestamp' => $order->created_at ? $order->created_at->timestamp : 0,
                    'url' => route('admin.dashboard', ['search' => '#RD-' . str_pad($order->id, 4, '0', STR_PAD_LEFT)]),
                    'badge' => 'Antrian Masuk',
                    'badge_color' => 'bg-amber-100 text-amber-800',
                    'icon_bg' => 'bg-amber-50 text-amber-600',
                    'icon' => 'clock',
                ];
            }

            // 2. Pesanan Siap Diambil / Diantar (Status Ready)
            $readyOrders = Order::with('customer')
                ->where('status', 'ready')
                ->latest()
                ->take(3)
                ->get();

            foreach ($readyOrders as $order) {
                $customerName = $order->customer ? $order->customer->name : 'Pelanggan';
                $notifications[] = [
                    'id' => 'order-ready-' . $order->id,
                    'type' => 'order_ready',
                    'category' => 'Siap Ambil',
                    'title' => 'Cucian Siap Diambil #RD-' . str_pad($order->id, 4, '0', STR_PAD_LEFT),
                    'message' => "Pakaian milik {$customerName} telah selesai dicuci dan siap diserahkan.",
                    'time' => $order->updated_at ? $order->updated_at->diffForHumans() : 'Hari ini',
                    'timestamp' => $order->updated_at ? $order->updated_at->timestamp : 0,
                    'url' => route('admin.dashboard', ['status' => 'ready']),
                    'badge' => 'Siap Ambil',
                    'badge_color' => 'bg-blue-100 text-blue-800',
                    'icon_bg' => 'bg-blue-50 text-blue-600',
                    'icon' => 'check',
                ];
            }

            // 3. Pengantaran Driver Berjalan / Terjadwal
            $deliveries = Delivery::with('order.customer')
                ->whereIn('status', ['scheduled', 'on-way'])
                ->latest()
                ->take(3)
                ->get();

            foreach ($deliveries as $deliv) {
                $order = $deliv->order;
                $orderId = $order ? '#RD-' . str_pad($order->id, 4, '0', STR_PAD_LEFT) : 'Pesanan';
                $driverName = $deliv->driver ?: 'Kurir';
                $isOngoing = $deliv->status === 'on-way';

                $notifications[] = [
                    'id' => 'delivery-' . $deliv->id,
                    'type' => 'delivery',
                    'category' => 'Pengantaran',
                    'title' => $isOngoing ? "Driver Sedang Antar ({$driverName})" : "Jadwal Antar Baru ({$driverName})",
                    'message' => "Pengantaran untuk {$orderId} menuju " . ($deliv->address ? Str::limit($deliv->address, 35) : 'Alamat Pelanggan'),
                    'time' => $deliv->updated_at ? $deliv->updated_at->diffForHumans() : 'Hari ini',
                    'timestamp' => $deliv->updated_at ? $deliv->updated_at->timestamp : 0,
                    'url' => route('admin.deliveries.index'),
                    'badge' => $isOngoing ? 'Sedang Diantar' : 'Dijadwalkan',
                    'badge_color' => $isOngoing ? 'bg-indigo-100 text-indigo-800' : 'bg-slate-100 text-slate-800',
                    'icon_bg' => 'bg-indigo-50 text-indigo-600',
                    'icon' => 'truck',
                ];
            }

            // 4. Pembayaran Selesai Terbaru
            $recentPayments = Payment::with('order.customer')
                ->where('status', 'completed')
                ->latest()
                ->take(3)
                ->get();

            foreach ($recentPayments as $payment) {
                $order = $payment->order;
                $orderId = $order ? '#RD-' . str_pad($order->id, 4, '0', STR_PAD_LEFT) : '';
                $method = strtoupper($payment->payment_method ?? 'CASH');

                $notifications[] = [
                    'id' => 'payment-' . $payment->id,
                    'type' => 'payment',
                    'category' => 'Pembayaran',
                    'title' => "Pembayaran {$method} Diterima",
                    'message' => "Penerimaan dana Rp " . number_format($payment->amount, 0, ',', '.') . ($orderId ? " untuk nota {$orderId}" : ''),
                    'time' => $payment->created_at ? $payment->created_at->diffForHumans() : 'Hari ini',
                    'timestamp' => $payment->created_at ? $payment->created_at->timestamp : 0,
                    'url' => route('admin.payments.index'),
                    'badge' => 'Lunas',
                    'badge_color' => 'bg-emerald-100 text-emerald-800',
                    'icon_bg' => 'bg-emerald-50 text-emerald-600',
                    'icon' => 'cash',
                ];
            }

            // Urutkan berdasarkan waktu paling baru
            usort($notifications, fn($a, $b) => $b['timestamp'] <=> $a['timestamp']);

            return array_slice($notifications, 0, 8);
        } catch (\Throwable $e) {
            return [];
        }
    }

    /**
     * Get the view / contents that represents the component.
     */
    public function render(): View
    {
        $notifications = $this->getNotifications();
        $unreadCount = count($notifications);

        return view('layouts.admin', [
            'title' => $this->title,
            'adminNotifications' => $notifications,
            'adminUnreadCount' => $unreadCount,
        ]);
    }
}
