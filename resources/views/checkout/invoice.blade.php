<!DOCTYPE html>
<html lang="bn">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <title>Invoice - {{ $order->order_number }}</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #f4f4f7;
            color: #1a1a2e;
            line-height: 1.6;
        }

        .invoice-wrapper {
            padding: 2rem;
        }

        .invoice-card {
            max-width: 800px;
            margin: 0 auto;
            background: #fff;
            border-radius: 12px;
            overflow: hidden;
            border: 1px solid #e5e5eb;
        }

        /* ── Top Bar ── */
        .invoice-top-bar {
            background: #1a1a2e;
            padding: 2rem 2rem 1.5rem;
        }

        .top-bar-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
        }

        .brand-name {
            font-size: 22px;
            font-weight: 600;
            color: #fff;
            letter-spacing: -0.3px;
        }

        .brand-sub {
            font-size: 12px;
            color: rgba(255,255,255,0.45);
            margin-top: 3px;
        }

        .inv-label-right {
            text-align: right;
            font-size: 11px;
            color: rgba(255,255,255,0.4);
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .inv-num-right {
            font-size: 13px;
            color: rgba(255,255,255,0.7);
            margin-top: 4px;
            font-family: 'Courier New', monospace;
            text-align: right;
        }

        .top-bar-meta {
            display: flex;
            justify-content: space-between;
            align-items: flex-end;
            margin-top: 1.75rem;
        }

        .order-label {
            font-size: 10px;
            color: rgba(255,255,255,0.4);
            text-transform: uppercase;
            letter-spacing: 1.2px;
        }

        .order-number {
            font-size: 18px;
            font-weight: 600;
            color: #fff;
            font-family: 'Courier New', monospace;
            margin-top: 5px;
        }

        .date-label {
            font-size: 10px;
            color: rgba(255,255,255,0.4);
            text-align: right;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .date-value {
            font-size: 13px;
            color: rgba(255,255,255,0.8);
            text-align: right;
            margin-top: 5px;
        }

        /* ── Body ── */
        .invoice-body {
            padding: 1.75rem 2rem;
        }

        .two-col {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1.5rem;
            margin-bottom: 1.75rem;
        }

        .section-label {
            font-size: 10px;
            font-weight: 600;
            color: #888;
            text-transform: uppercase;
            letter-spacing: 1.2px;
            margin-bottom: 8px;
        }

        .section-value {
            font-size: 14px;
            font-weight: 600;
            color: #1a1a2e;
            line-height: 1.5;
        }

        .section-muted {
            font-size: 13px;
            color: #666;
            line-height: 1.7;
            margin-top: 2px;
        }

        /* ── Badges ── */
        .pay-badge {
            display: inline-block;
            background: #f4f4f7;
            border: 1px solid #e0e0e8;
            border-radius: 6px;
            padding: 4px 10px;
            font-size: 12px;
            font-weight: 600;
            color: #1a1a2e;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .status-wrap {
            display: flex;
            align-items: center;
            gap: 8px;
            margin-top: 2px;
        }

        .status-dot {
            width: 8px;
            height: 8px;
            border-radius: 50%;
            background: #d4a017;
            flex-shrink: 0;
        }

        .status-dot.delivered { background: #2e9e5b; }
        .status-dot.cancelled { background: #d94040; }

        .status-text {
            font-size: 14px;
            font-weight: 600;
            color: #1a1a2e;
        }

        /* ── Divider ── */
        .divider {
            height: 1px;
            background: #ebebf0;
            margin: 0 0 1.75rem;
        }

        /* ── Items Table ── */
        .items-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 13px;
        }

        .items-table thead tr {
            border-bottom: 1px solid #dddde5;
        }

        .items-table th {
            font-size: 10px;
            font-weight: 600;
            color: #888;
            text-transform: uppercase;
            letter-spacing: 1px;
            padding: 0 0 10px;
            text-align: left;
        }

        .items-table th.right { text-align: right; }
        .items-table th.center { text-align: center; }

        .items-table td {
            padding: 13px 0;
            border-bottom: 1px solid #f0f0f5;
            vertical-align: top;
            color: #1a1a2e;
        }

        .items-table td.right { text-align: right; }
        .items-table td.center { text-align: center; color: #888; }

        .items-table tbody tr:last-child td { border-bottom: none; }

        .prod-name {
            font-weight: 600;
            color: #1a1a2e;
        }

        .prod-meta {
            font-size: 11px;
            color: #999;
            margin-top: 3px;
        }

        /* ── Summary ── */
        .summary {
            border-top: 1px solid #ebebf0;
            padding-top: 1rem;
            margin-top: 1.25rem;
        }

        .sum-row {
            display: flex;
            justify-content: flex-end;
            gap: 80px;
            font-size: 13px;
            color: #666;
            padding: 5px 0;
        }

        .sum-row span:last-child {
            min-width: 80px;
            text-align: right;
        }

        .sum-total {
            display: flex;
            justify-content: flex-end;
            gap: 80px;
            font-size: 17px;
            font-weight: 700;
            color: #1a1a2e;
            border-top: 1px solid #dddde5;
            margin-top: 8px;
            padding-top: 12px;
        }

        .sum-total span:last-child {
            min-width: 80px;
            text-align: right;
        }

        /* ── Note ── */
        .note-section {
            margin-top: 1.75rem;
            padding-top: 1.75rem;
            border-top: 1px solid #ebebf0;
        }

        .note-box {
            background: #f8f8fb;
            border-left: 3px solid #c5c5d5;
            border-radius: 0 6px 6px 0;
            padding: 10px 14px;
            font-size: 13px;
            color: #555;
            margin-top: 8px;
            line-height: 1.6;
        }

        /* ── Footer ── */
        .invoice-footer {
            background: #f8f8fb;
            border-top: 1px solid #ebebf0;
            padding: 1.25rem 2rem;
            text-align: center;
        }

        .invoice-footer p {
            font-size: 12px;
            color: #888;
            margin: 2px 0;
        }

        .invoice-footer .fine {
            font-size: 11px;
            color: #bbb;
            margin-top: 8px;
        }

        /* ── Print ── */
        .print-btn {
            display: block;
            max-width: 800px;
            margin: 0 auto 1rem;
            padding: 10px 20px;
            background: #1a1a2e;
            color: #fff;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-size: 13px;
            font-weight: 600;
        }

        .print-btn:hover { background: #2d2d4a; }

        @media print {
            body { background: #fff; }
            .invoice-wrapper { padding: 0; }
            .invoice-card {
                border-radius: 0;
                border: none;
                box-shadow: none;
            }
            .print-btn { display: none; }
        }
    </style>
</head>
<body>

<div class="invoice-wrapper">

    <button class="print-btn" onclick="window.print()">🖨️ Print / Save as PDF</button>

    <div class="invoice-card">

        <div class="invoice-top-bar">
            <div class="top-bar-header">
                <div>
                    <div class="brand-name">{{ \App\Models\Setting::get('site_name', 'Online Shop BD') }}</div>
                    <div class="brand-sub">Your Style, Your Signature</div>
                </div>
                <div>
                    <div class="inv-label-right">Invoice</div>
                    <div class="inv-num-right">{{ $order->order_number }}</div>
                </div>
            </div>
            <div class="top-bar-meta">
                <div>
                    <div class="order-label">অর্ডার নম্বর / Order Number</div>
                    <div class="order-number">{{ $order->order_number }}</div>
                </div>
                <div>
                    <div class="date-label">অর্ডার তারিখ</div>
                    <div class="date-value">{{ $order->created_at->format('d F Y') }}</div>
                </div>
            </div>
        </div>

        <div class="invoice-body">

            <div class="two-col">
                <div>
                    <div class="section-label">বিলকারী ঠিকানা</div>
                    <div class="section-value">{{ \App\Models\Setting::get('site_name', 'Online Shop BD') }}</div>
                    <div class="section-muted">{{ \App\Models\Setting::get('address', 'Dhaka, Bangladesh') }}</div>
                </div>
                <div>
                    <div class="section-label">ডেলিভারি ঠিকানা</div>
                    <div class="section-value">{{ $order->customer_name }}</div>
                    <div class="section-muted">
                        {{ $order->phone }}<br>
                        {{ $order->address }}<br>
                        @if ($order->upazila){{ $order->upazila->name }}, @endif
                        @if ($order->district){{ $order->district->name }}, @endif
                        @if ($order->division){{ $order->division->name }}@endif
                    </div>
                </div>
            </div>

            <div class="divider"></div>

            <div class="two-col">
                <div>
                    <div class="section-label">পেমেন্ট পদ্ধতি</div>
                    <div style="margin-top: 8px;">
                        <span class="pay-badge">{{ $order->payment_method }}</span>
                    </div>
                </div>
                <div>
                    <div class="section-label">অর্ডার স্ট্যাটাস</div>
                    <div class="status-wrap" style="margin-top: 8px;">
                        <div class="status-dot @if($order->status === 'delivered') delivered @elseif($order->status === 'cancelled') cancelled @endif"></div>
                        <div class="status-text">{{ ucfirst($order->status) }}</div>
                    </div>
                </div>
            </div>

            <div class="divider"></div>

            <table class="items-table">
                <thead>
                    <tr>
                        <th style="width: 48%;">বর্ণনা</th>
                        <th class="center" style="width: 14%;">পরিমাণ</th>
                        <th class="right" style="width: 18%;">মূল্য</th>
                        <th class="right" style="width: 20%;">মোট</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($order->items as $item)
                    <tr>
                        <td>
                            <div class="prod-name">{{ $item['product_name'] }}</div>
                            <div class="prod-meta">
                                {{ $item['size'] }}
                                @if ($item['color']) &nbsp;|&nbsp; {{ $item['color'] }} @endif
                            </div>
                        </td>
                        <td class="center">{{ $item['qty'] }}</td>
                        <td class="right">৳{{ number_format($item['unit_price'], 0) }}</td>
                        <td class="right" style="font-weight: 600;">৳{{ number_format($item['line_total'], 0) }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="summary">
                <div class="sum-row">
                    <span>সাবটোটাল</span>
                    <span>৳{{ number_format($order->subtotal, 0) }}</span>
                </div>
                <div class="sum-row">
                    <span>ডেলিভারি চার্জ</span>
                    <span>৳{{ number_format($order->delivery_charge, 0) }}</span>
                </div>
                <div class="sum-total">
                    <span>মোট</span>
                    <span>৳{{ number_format($order->total, 0) }}</span>
                </div>
            </div>

            @if ($order->note)
            <div class="note-section">
                <div class="section-label">বিশেষ নোট</div>
                <div class="note-box">{{ $order->note }}</div>
            </div>
            @endif

        </div>

        <div class="invoice-footer">
            <p>ধন্যবাদ আমাদের সাথে কেনাকাটা করার জন্য! 🥰</p>
            <p>Thank you for shopping with us!</p>
        </div>

    </div>
</div>

</body>
</html>