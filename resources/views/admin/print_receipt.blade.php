<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Struk #{{ $order->id }}</title>
    <style>
        /* Reset CSS untuk Printer Thermal */
        body {
            font-family: 'Courier New', Courier, monospace; /* Font Monospace agar rapi */
            font-size: 12px;
            margin: 0;
            padding: 10px;
            width: 58mm; /* Sesuaikan dengan lebar kertas printer (58mm atau 80mm) */
            color: #000;
        }
        .text-center { text-align: center; }
        .text-right { text-align: right; }
        .font-bold { font-weight: bold; }
        .divider {
            border-top: 1px dashed #000;
            margin: 10px 0;
        }
        .item-list {
            width: 100%;
            margin-bottom: 5px;
        }
        .item-list td {
            vertical-align: top;
        }
        .header { margin-bottom: 15px; }
        .footer { margin-top: 20px; font-size: 10px; }

        /* Hilangkan elemen browser saat print */
        @media print {
            @page { margin: 0; size: auto; }
            body { padding: 5mm; }
        }
    </style>
</head>
<body onload="window.print()"> <div class="header text-center">
        <div class="font-bold" style="font-size: 16px;">NGOPI KALCER</div>
        <div>Jl. Kopi No. 123, Jakarta</div>
        <div>Telp: 0812-3456-7890</div>
    </div>

    <div class="divider"></div>

    <div style="margin-bottom: 10px;">
        <div>Order ID: #{{ $order->id }}</div>
        <div>Tgl: {{ $order->created_at->format('d/m/Y H:i') }}</div>
        <div>Cust: {{ $order->user->name ?? 'Guest' }}</div>
    </div>

    <div class="divider"></div>

    <table class="item-list">
        @foreach($order->items as $item)
        <tr>
            <td style="width: 50%;">
                {{ $item->product->name }}
                @if($item->name && str_contains($item->name, '('))
                    <br><span style="font-size: 10px;">{{ Str::after($item->name, '(') }}</span> @endif
            </td>
            <td class="text-center" style="width: 20%;">x{{ $item->quantity }}</td>
            <td class="text-right" style="width: 30%;">{{ number_format($item->price * $item->quantity, 0, ',', '.') }}</td>
        </tr>
        @endforeach
    </table>

    <div class="divider"></div>

    <table style="width: 100%;">
        <tr>
            <td>Total</td>
            <td class="text-right font-bold" style="font-size: 14px;">Rp {{ number_format($order->total_price, 0, ',', '.') }}</td>
        </tr>
        <tr>
            <td>Status</td>
            <td class="text-right uppercase">{{ $order->status }}</td>
        </tr>
    </table>

    <div class="divider"></div>

    <div class="footer text-center">
        <div>Terima Kasih!</div>
        <div>Silakan Datang Kembali</div>
        <div>Wifi: NgopiKalcer / Pass: kopi123</div>
    </div>

</body>
</html>
