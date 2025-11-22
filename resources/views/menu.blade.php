<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menu - Ngopi Kalcer</title>

    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ env('MIDTRANS_CLIENT_KEY') }}"></script>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;800&family=Playfair+Display:ital,wght@0,400;0,700;1,400&family=Space+Mono&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        html { scroll-behavior: smooth; }
        body { font-family: 'Inter', sans-serif; background-color: #f8f5f2; }
        .font-display { font-family: 'Playfair Display', serif; }
        .font-mono { font-family: 'Space Mono', monospace; }
        .bg-brand-dark { background-color: #2a231f; }
        .text-brand-dark { color: #2a231f; }
        .text-brand-gold { color: #c8a063; }
        .bg-brand-gold { background-color: #c8a063; }
        .pattern-paper {
            background-image: radial-gradient(#e5e7eb 1px, transparent 1px);
            background-size: 10px 10px;
        }
        /* Custom Radio Button untuk Gula */
        input[type="radio"]:checked + label {
            background-color: #c8a063;
            color: white;
            border-color: #c8a063;
        }
    </style>
</head>

{{-- PERUBAHAN: Menambahkan parameter kedua $orders ke menuApp --}}
<body x-data="menuApp({{ Js::from($menus) }}, {{ Js::from($orders ?? []) }})">

    @include('partials.navbar')

    @include('partials.hero')

    @include('partials.menu-content')

    @include('partials.footer')

    {{-- Pastikan kode Sidebar Keranjang/Riwayat Baru ada di dalam sini --}}
    @include('partials.modals')

    @include('partials.scripts')

</body>
</html>
