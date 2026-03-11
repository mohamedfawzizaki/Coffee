<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="{{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@lang('Invoice') #{{ $order->id }}</title>
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #f0f2f5;
            color: #333;
            padding: 20px;
        }

        .invoice-wrapper {
            max-width: 800px;
            margin: 0 auto;
            background: #fff;
            border-radius: 12px;
            box-shadow: 0 4px 24px rgba(0,0,0,0.12);
            overflow: hidden;
        }

        /* Header */
        .invoice-header {
            background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%);
            color: #fff;
            padding: 36px 40px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .invoice-header .brand img {
            height: 60px;
            object-fit: contain;
            filter: brightness(0) invert(1);
        }

        .invoice-header .brand h2 {
            font-size: 22px;
            font-weight: 700;
            margin-top: 8px;
        }

        .invoice-header .invoice-meta {
            text-align: right;
        }

        .invoice-header .invoice-meta h1 {
            font-size: 32px;
            font-weight: 800;
            letter-spacing: 1px;
        }

        .invoice-header .invoice-meta p {
            font-size: 13px;
            opacity: 0.85;
            margin-top: 4px;
        }

        /* Info row */
        .invoice-info {
            display: flex;
            justify-content: space-between;
            padding: 30px 40px;
            border-bottom: 1px solid #eee;
            gap: 20px;
        }

        .invoice-info .info-block h4 {
            font-size: 11px;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: #999;
            margin-bottom: 8px;
        }

        .invoice-info .info-block p {
            font-size: 14px;
            color: #333;
            margin: 2px 0;
        }

        .invoice-info .info-block strong {
            color: #111;
        }

        /* Status badge */
        .status-badge {
            display: inline-block;
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
            text-transform: capitalize;
        }

        .status-completed  { background: #d1fae5; color: #065f46; }
        .status-processing { background: #dbeafe; color: #1e40af; }
        .status-pending    { background: #fef3c7; color: #92400e; }
        .status-cancelled  { background: #fee2e2; color: #991b1b; }

        /* Table */
        .invoice-table {
            width: 100%;
            border-collapse: collapse;
        }

        .invoice-table thead tr {
            background: #f8f9fb;
        }

        .invoice-table thead th {
            padding: 14px 20px;
            font-size: 12px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            color: #666;
            border-bottom: 2px solid #eee;
        }

        .invoice-table tbody tr {
            border-bottom: 1px solid #f0f0f0;
            transition: background 0.15s;
        }

        .invoice-table tbody tr:last-child {
            border-bottom: none;
        }

        .invoice-table tbody td {
            padding: 16px 20px;
            font-size: 14px;
            vertical-align: middle;
        }

        .item-name {
            font-weight: 600;
            color: #111;
        }

        .item-size {
            font-size: 12px;
            color: #888;
            margin-top: 2px;
        }

        .item-note {
            font-size: 12px;
            color: #aaa;
            font-style: italic;
        }

        /* Refunded row */
        .refunded-row {
            background: #fff5f5;
        }

        .refunded-row td {
            opacity: 0.7;
        }

        .refunded-row .item-name {
            text-decoration: line-through;
            color: #999;
        }

        .refunded-badge {
            display: inline-block;
            background: #fee2e2;
            color: #dc2626;
            font-size: 10px;
            font-weight: 700;
            padding: 2px 8px;
            border-radius: 10px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-top: 4px;
        }

        /* Totals */
        .invoice-totals {
            padding: 20px 40px 30px;
            display: flex;
            justify-content: flex-end;
        }

        .totals-table {
            width: 280px;
        }

        .totals-table tr td {
            padding: 6px 0;
            font-size: 14px;
        }

        .totals-table tr td:last-child {
            text-align: right;
            font-weight: 500;
        }

        .totals-table .divider td {
            border-top: 2px solid #eee;
            padding-top: 12px;
        }

        .totals-table .grand-total td {
            font-size: 17px;
            font-weight: 700;
            color: #1e3c72;
        }

        .totals-table .refund-row td {
            color: #dc2626;
            font-weight: 500;
        }

        /* Footer */
        .invoice-footer {
            background: #f8f9fb;
            padding: 20px 40px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-top: 1px solid #eee;
        }

        .invoice-footer p {
            font-size: 12px;
            color: #999;
        }

        /* Print button */
        .print-area {
            max-width: 800px;
            margin: 0 auto 20px;
            display: flex;
            justify-content: flex-end;
            gap: 10px;
        }

        .btn {
            padding: 10px 22px;
            border-radius: 8px;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            border: none;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }

        .btn-primary { background: #2a5298; color: #fff; }
        .btn-secondary { background: #fff; color: #555; border: 1px solid #ddd; }

        @media print {
            body { background: #fff; padding: 0; }
            .print-area { display: none; }
            .invoice-wrapper { box-shadow: none; border-radius: 0; }
        }
    </style>
</head>
<body>

    <div class="print-area">
        <a href="{{ url()->previous() }}" class="btn btn-secondary">
            ← @lang('Back')
        </a>
        <button onclick="window.print()" class="btn btn-primary">
            🖨 @lang('Print Invoice')
        </button>
    </div>

    <div class="invoice-wrapper">

        {{-- Header --}}
        <div class="invoice-header">
            <div class="brand">
                @if($setting && $setting->logo)
                    <img src="{{ $setting->logo }}" alt="Logo">
                @endif
                <h2>{{ $setting->title ?? config('app.name') }}</h2>
            </div>
            <div class="invoice-meta">
                <h1>@lang('INVOICE')</h1>
                <p>#{{ $order->id }}</p>
                <p>{{ $order->created_at->format('d M Y, H:i') }}</p>
            </div>
        </div>

        {{-- Info --}}
        <div class="invoice-info">

            @if($order->customer)
            <div class="info-block">
                <h4>@lang('Customer')</h4>
                <p><strong>{{ $order->customer->name }}</strong></p>
                <p>{{ $order->customer->phone }}</p>
                @if($order->customer->email)
                    <p>{{ $order->customer->email }}</p>
                @endif
            </div>
            @endif

            @if($order->branch)
            <div class="info-block">
                <h4>@lang('Branch')</h4>
                <p><strong>{{ $order->branch->title }}</strong></p>
            </div>
            @endif

            <div class="info-block">
                <h4>@lang('Payment')</h4>
                <p>{{ $order->payment_method }}</p>
                <p>{{ $order->payment_status }}</p>
                @if($order->payment_id)
                    <p>#{{ $order->payment_id }}</p>
                @endif
            </div>

            <div class="info-block">
                <h4>@lang('Status')</h4>
                <p>
                    <span class="status-badge status-{{ $order->status }}">
                        @lang(ucfirst($order->status))
                    </span>
                </p>
                @if($order->place)
                    <p style="margin-top:6px;">{{ $order->place }}</p>
                @endif
            </div>

        </div>

        {{-- Items Table --}}
        <div style="padding: 0 0 0 0; overflow-x:auto;">
            <table class="invoice-table">
                <thead>
                    <tr>
                        <th style="padding-left:40px;">#</th>
                        <th>@lang('Product')</th>
                        <th>@lang('Price')</th>
                        <th>@lang('Qty')</th>
                        <th style="text-align:right; padding-right:40px;">@lang('Total')</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($order->items as $i => $item)
                    <tr class="{{ $item->is_refunded ? 'refunded-row' : '' }}">
                        <td style="padding-left:40px; color:#aaa;">{{ $i + 1 }}</td>
                        <td>
                            <div class="item-name">{{ $item->product?->title }}</div>
                            @if($item->size_id)
                                <div class="item-size">{{ $item->size?->title }}</div>
                            @endif
                            @if($item->note)
                                <div class="item-note">{{ $item->note }}</div>
                            @endif
                            @if($item->is_refunded)
                                <span class="refunded-badge">@lang('Refunded')</span>
                                <span style="font-size:11px; color:#aaa; display:block; margin-top:2px;">
                                    {{ $item->refunded_at?->format('d M Y, H:i') }}
                                </span>
                            @endif
                        </td>
                        <td style="{{ $item->is_refunded ? 'text-decoration:line-through; color:#bbb;' : '' }}">
                            {{ number_format($item->price, 2) }}
                        </td>
                        <td>{{ $item->quantity }}</td>
                        <td style="text-align:right; padding-right:40px; font-weight:600; {{ $item->is_refunded ? 'text-decoration:line-through; color:#bbb;' : '' }}">
                            {{ number_format($item->total, 2) }}
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        {{-- Totals --}}
        <div class="invoice-totals">
            <table class="totals-table">
                <tr>
                    <td>@lang('Sub Total')</td>
                    <td>{{ number_format($order->total, 2) }}</td>
                </tr>

                @php $refundedTotal = $order->items->where('is_refunded', true)->sum('total'); @endphp

                @if($refundedTotal > 0)
                <tr class="refund-row">
                    <td>@lang('Refunded Items')</td>
                    <td>-{{ number_format($refundedTotal, 2) }}</td>
                </tr>
                @endif

                @if($order->discount > 0)
                <tr>
                    <td>@lang('Discount')</td>
                    <td>-{{ number_format($order->discount, 2) }}</td>
                </tr>
                @endif

                @if($order->tax > 0)
                <tr>
                    <td>@lang('Tax')</td>
                    <td>{{ number_format($order->tax, 2) }}</td>
                </tr>
                @endif

                @if($order->coupon)
                <tr>
                    <td>@lang('Coupon') ({{ $order->coupon->code }})</td>
                    <td>-{{ number_format($order->discount, 2) }}</td>
                </tr>
                @endif

                <tr class="divider grand-total">
                    <td>@lang('Grand Total')</td>
                    <td>{{ number_format($order->grand_total, 2) }}</td>
                </tr>
            </table>
        </div>

        {{-- Footer --}}
        <div class="invoice-footer">
            <p>@lang('Thank you for your order!')</p>
            <p>@lang('Generated on') {{ now()->format('d M Y, H:i') }}</p>
        </div>

    </div>

</body>
</html>
