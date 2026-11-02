<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Rekapitulasi Transaksi - Rodeo Laundry</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    
    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            font-family: 'Plus Jakarta Sans', -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
        }

        body {
            background-color: #f1f5f9;
            color: #0f172a;
            padding: 30px 20px;
            font-size: 12px;
            line-height: 1.4;
        }

        .report-page {
            max-width: 1050px;
            margin: 0 auto;
            background: #ffffff;
            padding: 40px;
            border-radius: 16px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
            border: 1px solid #e2e8f0;
        }

        /* Top Bar Floating Controls (Hidden on Print) */
        .floating-controls {
            max-width: 1050px;
            margin: 0 auto 20px auto;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
            background: #1e1b4b;
            color: white;
            padding: 12px 20px;
            border-radius: 14px;
            box-shadow: 0 4px 16px rgba(30, 27, 75, 0.2);
        }

        .floating-controls h4 {
            font-size: 13px;
            font-weight: 700;
            color: #bff108;
        }

        .floating-controls .actions {
            display: flex;
            gap: 8px;
        }

        .btn {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 8px 16px;
            border-radius: 10px;
            font-size: 12px;
            font-weight: 700;
            cursor: pointer;
            text-decoration: none;
            border: none;
            transition: all 0.2s ease;
        }

        .btn-print {
            background: #bff108;
            color: #1e1b4b;
        }

        .btn-print:hover {
            background: #d2f738;
        }

        .btn-csv {
            background: #ffffff;
            color: #1e1b4b;
        }

        .btn-csv:hover {
            background: #f8fafc;
        }

        .btn-close {
            background: rgba(255, 255, 255, 0.15);
            color: white;
        }

        .btn-close:hover {
            background: rgba(255, 255, 255, 0.25);
        }

        /* Report Header */
        .report-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            padding-bottom: 20px;
            border-bottom: 2px solid #1e1b4b;
            margin-bottom: 24px;
        }

        .brand-section {
            display: flex;
            align-items: center;
            gap: 14px;
        }

        .brand-logo {
            width: 50px;
            height: 50px;
            background: #1e1b4b;
            color: #bff108;
            border-radius: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
            font-weight: 900;
        }

        .brand-title {
            font-size: 20px;
            font-weight: 800;
            color: #1e1b4b;
            letter-spacing: -0.5px;
        }

        .brand-subtitle {
            font-size: 11px;
            color: #64748b;
            margin-top: 2px;
        }

        .header-meta {
            text-align: right;
        }

        .report-badge {
            display: inline-block;
            background: #eef2ff;
            color: #3730a3;
            font-size: 11px;
            font-weight: 800;
            padding: 4px 12px;
            border-radius: 20px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 6px;
        }

        .report-doc-title {
            font-size: 18px;
            font-weight: 800;
            color: #1e1b4b;
        }

        .report-period {
            font-size: 12px;
            font-weight: 700;
            color: #0284c7;
            margin-top: 2px;
        }

        .report-date {
            font-size: 11px;
            color: #64748b;
            margin-top: 2px;
        }

        /* Summary Metric Cards */
        .summary-grid {
            display: grid;
            grid-template-columns: repeat(5, 1fr);
            gap: 12px;
            margin-bottom: 24px;
        }

        .summary-card {
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 12px;
            padding: 12px 14px;
        }

        .summary-label {
            font-size: 10px;
            font-weight: 700;
            text-transform: uppercase;
            color: #64748b;
            letter-spacing: 0.5px;
        }

        .summary-value {
            font-size: 17px;
            font-weight: 800;
            color: #1e1b4b;
            margin-top: 4px;
        }

        .summary-card.highlight {
            background: #1e1b4b;
            color: white;
            border-color: #1e1b4b;
        }

        .summary-card.highlight .summary-label {
            color: #94a3b8;
        }

        .summary-card.highlight .summary-value {
            color: #bff108;
        }

        /* Data Table */
        .table-container {
            width: 100%;
            overflow-x: auto;
            margin-bottom: 30px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 11px;
        }

        th {
            background: #1e1b4b;
            color: #ffffff;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            padding: 10px 10px;
            text-align: left;
            font-size: 10px;
            border: 1px solid #1e1b4b;
        }

        td {
            padding: 9px 10px;
            border-bottom: 1px solid #e2e8f0;
            color: #1e293b;
            vertical-align: middle;
        }

        tr:nth-child(even) td {
            background-color: #f8fafc;
        }

        .text-center { text-align: center; }
        .text-right { text-align: right; }

        .status-pill {
            display: inline-block;
            padding: 2px 8px;
            border-radius: 12px;
            font-size: 9.5px;
            font-weight: 700;
            text-align: center;
        }

        .status-completed { background: #dcfce7; color: #15803d; }
        .status-ready { background: #dbeafe; color: #1d4ed8; }
        .status-processing { background: #fef3c7; color: #b45309; }
        .status-pending { background: #f1f5f9; color: #475569; }
        .status-cancelled { background: #ffe4e6; color: #be123c; }

        .table-total-row td {
            background: #f1f5f9;
            font-weight: 800;
            font-size: 12px;
            border-top: 2px solid #cbd5e1;
            border-bottom: 2px solid #cbd5e1;
            padding: 12px 10px;
        }

        /* Signatures */
        .signature-section {
            display: flex;
            justify-content: space-between;
            margin-top: 40px;
            padding-top: 20px;
            page-break-inside: avoid;
        }

        .notes-box {
            width: 55%;
            font-size: 11px;
            color: #64748b;
        }

        .notes-box ul {
            margin-left: 16px;
            margin-top: 4px;
        }

        .signature-box {
            width: 35%;
            text-align: center;
        }

        .signature-line {
            margin-top: 60px;
            border-bottom: 1px solid #0f172a;
            display: inline-block;
            width: 180px;
        }

        /* Print Media Styles */
        @media print {
            body {
                background: #ffffff;
                padding: 0;
            }

            .report-page {
                box-shadow: none;
                border: none;
                padding: 10px 0;
                max-width: 100%;
            }

            .no-print, .floating-controls {
                display: none !important;
            }

            th {
                background: #1e1b4b !important;
                color: #ffffff !important;
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }

            .summary-card.highlight {
                background: #1e1b4b !important;
                color: white !important;
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }

            .summary-card.highlight .summary-value {
                color: #bff108 !important;
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }

            .status-pill {
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }

            tr {
                page-break-inside: avoid;
            }
        }
    </style>
</head>
<body>

    <!-- Floating Bar for Quick Print & CSV Download (Hidden during print) -->
    <div class="floating-controls no-print">
        <div style="display: flex; align-items: center; gap: 8px;">
            <span style="font-size: 16px;">📄</span>
            <div>
                <h4>Laporan Siap Dicetak & Diunduh</h4>
                <div style="font-size: 11px; color: #cbd5e1;">Pastikan printer atau pilihan "Save as PDF" aktif pada dialog browser.</div>
            </div>
        </div>
        <div class="actions">
            <button onclick="window.print()" class="btn btn-print">
                🖨️ Cetak / Simpan PDF
            </button>
            <a href="{{ route('admin.reports.export', request()->all()) }}" class="btn btn-csv">
                📥 Unduh Excel (CSV)
            </a>
            <button onclick="window.close()" class="btn btn-close">
                ✕ Tutup
            </button>
        </div>
    </div>

    <!-- Official Report Document Canvas -->
    <div class="report-page">

        <!-- Header -->
        <div class="report-header">
            <div class="brand-section">
                <div class="brand-logo">R</div>
                <div>
                    <h1 class="brand-title">RODEO LAUNDRY & DRY CLEANING</h1>
                    <p class="brand-subtitle">
                        Gg. Rodeo, RT.04/RW.10, Sumberejo, Kec. Batu, Kota Batu, Jawa Timur 65318<br>
                        Buka Setiap Hari: 07.00 - 21.00 WIB | WhatsApp: +62 813-5805-5257
                    </p>
                </div>
            </div>
            <div class="header-meta">
                <span class="report-badge">Dokumen Resmi Outlet</span>
                <h2 class="report-doc-title">REKAPITULASI TRANSAKSI</h2>
                <div class="report-period">{{ $periodLabel }}</div>
                <div class="report-date">Waktu Cetak: {{ \Carbon\Carbon::now()->isoFormat('D MMMM Y, HH:mm') }} WIB</div>
            </div>
        </div>

        <!-- Metric Summary Cards -->
        <div class="summary-grid">
            <div class="summary-card">
                <div class="summary-label">Total Pesanan</div>
                <div class="summary-value">{{ number_format($totalOrders, 0, ',', '.') }}</div>
            </div>

            <div class="summary-card highlight">
                <div class="summary-label">Total Omset / Pendapatan</div>
                <div class="summary-value">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</div>
            </div>

            <div class="summary-card">
                <div class="summary-label">Pesanan Selesai</div>
                <div class="summary-value" style="color: #16a34a;">{{ $completedCount }}</div>
            </div>

            <div class="summary-card">
                <div class="summary-label">Sedang Dikerjakan</div>
                <div class="summary-value" style="color: #d97706;">{{ $processingCount }}</div>
            </div>

            <div class="summary-card">
                <div class="summary-label">Dibatalkan</div>
                <div class="summary-value" style="color: #e11d48;">{{ $cancelledCount }}</div>
            </div>
        </div>

        <!-- Orders Table -->
        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th class="text-center" style="width: 35px;">NO</th>
                        <th style="width: 90px;">NO. NOTA</th>
                        <th style="width: 105px;">TGL & WAKTU</th>
                        <th>NAMA PELANGGAN</th>
                        <th>RINCIAN LAYANAN & ITEM</th>
                        <th class="text-center" style="width: 75px;">METODE</th>
                        <th class="text-right" style="width: 95px;">TOTAL (RP)</th>
                        <th class="text-center" style="width: 95px;">STATUS</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($orders as $idx => $order)
                        @php
                            $itemsSummary = $order->items->map(function($it) {
                                $sName = $it->service ? $it->service->name : 'Layanan';
                                return "{$sName} ({$it->quantity})";
                            })->implode(', ');

                            $statusClass = match($order->status) {
                                'completed' => 'status-completed',
                                'ready' => 'status-ready',
                                'processing' => 'status-processing',
                                'pending' => 'status-pending',
                                'cancelled' => 'status-cancelled',
                                default => 'status-pending',
                            };

                            $statusLabel = match($order->status) {
                                'completed' => 'Selesai',
                                'ready' => 'Siap Ambil',
                                'processing' => 'Sedang Cuci',
                                'pending' => 'Antrian',
                                'cancelled' => 'Dibatalkan',
                                default => ucfirst($order->status),
                            };

                            $payMethod = $order->payment ? strtoupper($order->payment->payment_method ?? 'CASH') : 'CASH';
                        @endphp
                        <tr>
                            <td class="text-center">{{ $idx + 1 }}</td>
                            <td>
                                <strong style="color: #1e1b4b; font-family: monospace;">#RD-{{ str_pad($order->id, 4, '0', STR_PAD_LEFT) }}</strong>
                            </td>
                            <td>
                                {{ $order->created_at ? $order->created_at->format('d/m/Y H:i') : '-' }}
                            </td>
                            <td>
                                <strong>{{ $order->customer ? $order->customer->name : 'Pelanggan Walk-In' }}</strong>
                                <div style="font-size: 10px; color: #64748b;">{{ $order->customer ? ($order->customer->phone ?? '-') : '-' }}</div>
                            </td>
                            <td>
                                {{ $itemsSummary ?: 'Pencucian Laundry' }}
                            </td>
                            <td class="text-center font-bold" style="font-size: 10px;">
                                {{ $payMethod }}
                            </td>
                            <td class="text-right font-bold" style="color: #1e1b4b;">
                                {{ number_format($order->total_price, 0, ',', '.') }}
                            </td>
                            <td class="text-center">
                                <span class="status-pill {{ $statusClass }}">
                                    {{ $statusLabel }}
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center" style="padding: 40px; color: #94a3b8;">
                                Tidak ada transaksi pesanan yang sesuai dengan filter periode ini.
                            </td>
                        </tr>
                    @endforelse

                    @if($orders->count() > 0)
                        <tr class="table-total-row">
                            <td colspan="6" class="text-right" style="text-transform: uppercase;">
                                GRAND TOTAL TRANSAKSI BERHASIL:
                            </td>
                            <td class="text-right" style="color: #1e1b4b; font-size: 13px;">
                                Rp {{ number_format($totalRevenue, 0, ',', '.') }}
                            </td>
                            <td class="text-center">
                                {{ $orders->where('status', '!=', 'cancelled')->count() }} Order
                            </td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>

        <!-- Footer Notes & Signatures -->
        <div class="signature-section">
            <div class="notes-box">
                <strong>Catatan Rekapitulasi:</strong>
                <ul>
                    <li>Laporan ini digenerate secara otomatis oleh Sistem Informasi POS Rodeo Laundry.</li>
                    <li>Total omset hanya mengkalkulasi pesanan yang berstatus aktif (tidak dibatalkan).</li>
                    <li>Gunakan rekonsiliasi data ini sebagai acuan pembukuan kas harian/bulanan.</li>
                </ul>
            </div>

            <div class="signature-box">
                <div>Kota Batu, {{ \Carbon\Carbon::now()->isoFormat('D MMMM Y') }}</div>
                <div style="font-weight: 700; margin-top: 4px;">Penanggung Jawab Outlet,</div>
                <div class="signature-line"></div>
                <div style="font-weight: 800; color: #1e1b4b; margin-top: 6px;">Admin Kasir Rodeo</div>
            </div>
        </div>

    </div>

    <script>
        // Auto trigger print saat halaman siap jika diinginkan
        window.addEventListener('load', function() {
            setTimeout(function() {
                window.print();
            }, 600);
        });
    </script>
</body>
</html>
