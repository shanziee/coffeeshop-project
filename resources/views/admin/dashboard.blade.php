<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Ngopi Kalcer</title>

    {{-- Menggunakan Vite untuk CSS (sama seperti halaman utama) --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    {{-- Font & Icon --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&display=swap" rel="stylesheet">
    <script src="https://unpkg.com/lucide@latest"></script>

    <style>
        body { font-family: 'Inter', sans-serif; background-color: #f3f4f6; }
    </style>
</head>
<body class="flex h-screen overflow-hidden">

    <aside class="w-64 bg-gray-900 text-white flex flex-col hidden md:flex">
        <div class="h-16 flex items-center px-6 bg-gray-800 border-b border-gray-700">
            <h1 class="text-xl font-bold tracking-wider text-yellow-500">NGOPI ADMIN</h1>
        </div>

        <nav class="flex-1 py-6 px-3 space-y-1">
            <a href="#" class="flex items-center px-4 py-3 text-gray-100 bg-gray-800 rounded-lg transition-colors">
                <i data-lucide="layout-dashboard" class="w-5 h-5 mr-3"></i>
                <span class="font-medium">Dashboard</span>
            </a>

            <a href="#" class="flex items-center px-4 py-3 text-gray-400 hover:bg-gray-800 hover:text-white rounded-lg transition-colors">
                <i data-lucide="coffee" class="w-5 h-5 mr-3"></i>
                <span class="font-medium">Kelola Menu</span>
            </a>

            <a href="#" class="flex items-center px-4 py-3 text-gray-400 hover:bg-gray-800 hover:text-white rounded-lg transition-colors">
                <i data-lucide="file-text" class="w-5 h-5 mr-3"></i>
                <span class="font-medium">Riwayat Pesanan</span>
            </a>
        </nav>

        <div class="p-4 border-t border-gray-800">
            <form action="{{ route('admin.logout') }}" method="POST">
                @csrf
                <button type="submit" class="flex items-center w-full px-4 py-2 text-sm text-red-400 hover:text-red-300 hover:bg-gray-800 rounded-lg transition">
                    <i data-lucide="log-out" class="w-4 h-4 mr-3"></i>
                    Logout
                </button>
            </form>
        </div>
    </aside>

    <div class="flex-1 flex flex-col overflow-hidden">

        <header class="h-16 bg-white shadow-sm flex items-center justify-between px-6">
            <div class="md:hidden">
                {{-- Mobile Menu Button Placeholder --}}
                <button class="text-gray-600"><i data-lucide="menu"></i></button>
            </div>
            <div class="text-gray-500 text-sm ml-auto">
                Halo, <span class="font-bold text-gray-800">{{ auth()->guard('admin')->user()->username ?? 'Admin' }}</span>
            </div>
        </header>

        <main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-100 p-6">

            <div class="mb-6">
                <h2 class="text-2xl font-bold text-gray-800">Ringkasan Hari Ini</h2>
                <p class="text-gray-500 text-sm">Pantau performa penjualan coffee shop Anda.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">

                <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 flex items-center">
                    <div class="p-3 rounded-full bg-blue-50 text-blue-600 mr-4">
                        <i data-lucide="shopping-bag" class="w-6 h-6"></i>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-500">Pesanan Masuk (Hari Ini)</p>
                        <p class="text-2xl font-bold text-gray-800">{{ $todaysOrders }}</p>
                    </div>
                </div>

                <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 flex items-center">
                    <div class="p-3 rounded-full bg-yellow-50 text-yellow-600 mr-4">
                        <i data-lucide="coffee" class="w-6 h-6"></i>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-500">Total Menu Aktif</p>
                        <p class="text-2xl font-bold text-gray-800">{{ $totalMenus }}</p>
                    </div>
                </div>

                <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 flex items-center">
                    <div class="p-3 rounded-full bg-green-50 text-green-600 mr-4">
                        <i data-lucide="banknote" class="w-6 h-6"></i>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-500">Pendapatan (Paid)</p>
                        <p class="text-2xl font-bold text-green-600">
                            Rp {{ number_format($todaysRevenue, 0, ',', '.') }}
                        </p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-100 flex justify-between items-center">
                    <h3 class="font-bold text-gray-800">Transaksi Terbaru</h3>
                    {{-- Tombol Lihat Semua (bisa diaktifkan nanti) --}}
                    {{-- <a href="#" class="text-sm text-blue-600 hover:underline">Lihat Semua</a> --}}
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left">
                        <thead>
                            <tr class="bg-gray-50 text-gray-600 text-xs uppercase tracking-wider">
                                <th class="px-6 py-3 font-semibold">ID Order</th>
                                <th class="px-6 py-3 font-semibold">Pelanggan</th>
                                <th class="px-6 py-3 font-semibold">Total</th>
                                <th class="px-6 py-3 font-semibold">Tanggal</th>
                                <th class="px-6 py-3 font-semibold">Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse($recentOrders as $order)
                                <tr class="hover:bg-gray-50 transition">
                                    <td class="px-6 py-4 text-sm font-mono text-gray-500">
                                        {{ $order->order_number }}
                                    </td>
                                    <td class="px-6 py-4 text-sm font-medium text-gray-800">
                                        {{ $order->user->name ?? 'Guest' }}
                                        <div class="text-xs text-gray-400 font-normal">{{ $order->user->email ?? '-' }}</div>
                                    </td>
                                    <td class="px-6 py-4 text-sm font-bold text-gray-700">
                                        Rp {{ number_format($order->total_price, 0, ',', '.') }}
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-500">
                                        {{ $order->created_at->format('d M Y H:i') }}
                                    </td>
                                    <td class="px-6 py-4 text-sm">
                                        @if($order->status == 'paid')
                                            <span class="px-3 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-700 border border-green-200">
                                                Lunas
                                            </span>
                                        @elseif($order->status == 'unpaid')
                                            <span class="px-3 py-1 rounded-full text-xs font-semibold bg-yellow-100 text-yellow-700 border border-yellow-200">
                                                Belum Bayar
                                            </span>
                                        @elseif($order->status == 'cancelled')
                                            <span class="px-3 py-1 rounded-full text-xs font-semibold bg-red-100 text-red-700 border border-red-200">
                                                Batal
                                            </span>
                                        @else
                                            <span class="px-3 py-1 rounded-full text-xs font-semibold bg-gray-100 text-gray-600">
                                                {{ $order->status }}
                                            </span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-12 text-center text-gray-400">
                                        <i data-lucide="inbox" class="w-12 h-12 mx-auto mb-2 opacity-50"></i>
                                        <p>Belum ada pesanan masuk hari ini.</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </main>
    </div>

    {{-- Inisialisasi Icon Lucide --}}
    <script>
        lucide.createIcons();
    </script>
</body>
</html>
