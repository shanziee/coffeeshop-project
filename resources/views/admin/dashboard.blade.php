<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Ngopi Kalcer</title>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; background-color: #f3f4f6; }
        [x-cloak] { display: none !important; }
    </style>
</head>
<body x-data="{ currentTab: 'dashboard', mobileMenu: false }">

    <div class="flex h-screen overflow-hidden bg-gray-100">

        <aside :class="mobileMenu ? 'translate-x-0' : '-translate-x-full'" class="fixed inset-y-0 left-0 z-50 w-64 bg-[#2a231f] text-white transition-transform duration-300 ease-in-out md:relative md:translate-x-0 shadow-xl flex flex-col justify-between">
            <div>
                <div class="flex items-center justify-center h-20 border-b border-gray-700">
                    <h1 class="text-2xl font-bold text-[#c8a063] tracking-wider">ADMIN PANEL</h1>
                </div>
                <nav class="mt-6 px-4 space-y-2">
                    <button @click="currentTab = 'dashboard'; mobileMenu = false"
                        :class="currentTab === 'dashboard' ? 'bg-[#c8a063] text-white shadow-lg' : 'text-gray-400 hover:bg-white/10 hover:text-white'"
                        class="flex items-center w-full px-4 py-3 text-sm font-bold rounded-xl transition-all duration-200">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path></svg>
                        Dashboard
                    </button>

                    <button @click="currentTab = 'menu'; mobileMenu = false"
                        :class="currentTab === 'menu' ? 'bg-[#c8a063] text-white shadow-lg' : 'text-gray-400 hover:bg-white/10 hover:text-white'"
                        class="flex items-center w-full px-4 py-3 text-sm font-bold rounded-xl transition-all duration-200">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                        Kelola Menu
                    </button>

                    <button @click="currentTab = 'orders'; mobileMenu = false"
                        :class="currentTab === 'orders' ? 'bg-[#c8a063] text-white shadow-lg' : 'text-gray-400 hover:bg-white/10 hover:text-white'"
                        class="flex items-center w-full px-4 py-3 text-sm font-bold rounded-xl transition-all duration-200">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg>
                        Riwayat Pesanan
                    </button>
                </nav>
            </div>

            <div class="p-4 border-t border-gray-700">
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="flex items-center justify-center w-full px-4 py-2 text-sm font-bold text-red-400 bg-red-500/10 rounded-lg hover:bg-red-500 hover:text-white transition">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                        Logout
                    </button>
                </form>
            </div>
        </aside>

        <div class="flex-1 flex flex-col overflow-hidden">

            <header class="flex items-center justify-between px-6 py-4 bg-white shadow-sm md:hidden">
                <span class="text-xl font-bold text-gray-800">Dashboard</span>
                <button @click="mobileMenu = !mobileMenu" class="text-gray-500 hover:text-gray-700">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
                </button>
            </header>

            <main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-100 p-6">

                <div x-show="currentTab === 'dashboard'" x-transition.opacity class="space-y-6">
                    <h2 class="text-2xl font-bold text-gray-800 mb-6">Ringkasan Bisnis</h2>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 flex items-center">
                            <div class="p-4 bg-green-100 rounded-full text-green-600 mr-4">
                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            </div>
                            <div>
                                <p class="text-gray-500 text-sm font-medium">Total Pendapatan</p>
                                <p class="text-2xl font-bold text-gray-800">Rp {{ number_format($totalPendapatan, 0, ',', '.') }}</p>
                            </div>
                        </div>
                        <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 flex items-center">
                            <div class="p-4 bg-blue-100 rounded-full text-blue-600 mr-4">
                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                            </div>
                            <div>
                                <p class="text-gray-500 text-sm font-medium">Total Pesanan</p>
                                <p class="text-2xl font-bold text-gray-800">{{ $totalOrder }} Transaksi</p>
                            </div>
                        </div>
                        <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 flex items-center">
                            <div class="p-4 bg-yellow-100 rounded-full text-yellow-600 mr-4">
                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                            </div>
                            <div>
                                <p class="text-gray-500 text-sm font-medium">Total Menu</p>
                                <p class="text-2xl font-bold text-gray-800">{{ $totalMenu }} Menu</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div x-show="currentTab === 'menu'" x-cloak x-transition.opacity>
                    <div class="flex justify-between items-center mb-6">
                        <h2 class="text-2xl font-bold text-gray-800">Kelola Menu</h2>
                        <button class="bg-[#2a231f] hover:bg-gray-800 text-white px-5 py-2 rounded-lg font-bold text-sm shadow-lg transition flex items-center">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                            Tambah Menu
                        </button>
                    </div>

                    <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">
                        <table class="w-full text-left border-collapse">
                            <thead class="bg-gray-50 text-gray-500 uppercase text-xs font-bold">
                                <tr>
                                    <th class="px-6 py-4">Foto</th>
                                    <th class="px-6 py-4">Nama Menu</th>
                                    <th class="px-6 py-4">Kategori</th>
                                    <th class="px-6 py-4">Harga</th>
                                    <th class="px-6 py-4 text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                                @foreach($products as $item)
                                <tr class="hover:bg-gray-50 transition">
                                    <td class="px-6 py-3">
                                        <img src="{{ asset($item->image) }}" class="h-12 w-12 rounded-lg object-cover bg-gray-200">
                                    </td>
                                    <td class="px-6 py-3 font-bold text-gray-800">{{ $item->name }}</td>
                                    <td class="px-6 py-3">
                                        <span class="px-3 py-1 text-xs rounded-full font-bold {{ $item->category == 'minuman' ? 'bg-blue-100 text-blue-700' : 'bg-orange-100 text-orange-700' }}">
                                            {{ ucfirst($item->category) }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-3 text-gray-600">Rp {{ number_format($item->price, 0, ',', '.') }}</td>
                                    <td class="px-6 py-3 text-center">
                                        <div class="flex items-center justify-center gap-2">
                                            <button class="p-2 text-blue-500 hover:bg-blue-50 rounded-full transition"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg></button>
                                            <button class="p-2 text-red-500 hover:bg-red-50 rounded-full transition"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg></button>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                <div x-show="currentTab === 'orders'" x-cloak x-transition.opacity>
                    <h2 class="text-2xl font-bold text-gray-800 mb-6">Riwayat Pesanan Masuk</h2>

                    <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">
                        <div class="overflow-x-auto">
                            <table class="w-full text-left border-collapse">
                                <thead class="bg-gray-50 text-gray-500 uppercase text-xs font-bold">
                                    <tr>
                                        <th class="px-6 py-4">ID Order</th>
                                        <th class="px-6 py-4">Pelanggan</th>
                                        <th class="px-6 py-4">Tanggal</th>
                                        <th class="px-6 py-4">Status</th>
                                        <th class="px-6 py-4">Total</th>
                                        <th class="px-6 py-4">Detail</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-100">
                                    @forelse($orders as $order)
                                    <tr class="hover:bg-gray-50 transition" x-data="{ expanded: false }">
                                        <td class="px-6 py-4 font-mono text-xs text-gray-500">#{{ $order->id }}</td>
                                        <td class="px-6 py-4 font-bold text-gray-800">{{ $order->user->name ?? 'Guest' }}</td>
                                        <td class="px-6 py-4 text-sm text-gray-500">{{ $order->created_at->format('d M Y, H:i') }}</td>
                                        <td class="px-6 py-4">
                                            <span class="px-3 py-1 text-[10px] uppercase font-bold rounded-full
                                                {{ $order->status == 'paid' ? 'bg-green-100 text-green-700' :
                                                   ($order->status == 'pending' ? 'bg-yellow-100 text-yellow-700' : 'bg-red-100 text-red-700') }}">
                                                {{ $order->status }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 font-bold text-gray-800">Rp {{ number_format($order->total_price, 0, ',', '.') }}</td>
                                        <td class="px-6 py-4">
                                            <button @click="expanded = !expanded" class="text-blue-600 hover:underline text-xs font-bold">
                                                <span x-text="expanded ? 'Tutup' : 'Lihat Item'"></span>
                                            </button>
                                        </td>

                                        <template x-if="expanded">
                                            <tr class="bg-gray-50">
                                                <td colspan="6" class="px-6 py-4">
                                                    <div class="text-sm font-bold text-gray-700 mb-2">Detail Item:</div>
                                                    <ul class="list-disc list-inside text-sm text-gray-600 space-y-1 ml-2">
                                                        @foreach($order->items as $item)
                                                            <li>
                                                                <span class="font-bold">{{ $item->quantity }}x</span> {{ $item->product->name }}
                                                                <span class="text-gray-400 text-xs">(Rp {{ number_format($item->price, 0, ',', '.') }})</span>
                                                            </li>
                                                        @endforeach
                                                    </ul>
                                                </td>
                                            </tr>
                                        </template>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="6" class="px-6 py-8 text-center text-gray-500">Belum ada pesanan masuk.</td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

            </main>
        </div>
    </div>
</body>
</html>
