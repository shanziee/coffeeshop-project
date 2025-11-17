<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Ngopi Kalcer</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Playfair+Display:wght@700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
        .font-display { font-family: 'Playfair Display', serif; }
        .bg-brand-dark { background-color: #2a231f; }
        .text-brand-gold { color: #c8a063; }
    </style>
</head>
<body class="bg-gray-100">

    <div x-data="{ sidebarOpen: false }" class="flex h-screen bg-gray-100">

        <div x-show="sidebarOpen" @click="sidebarOpen = false" class="fixed inset-0 z-20 bg-black opacity-50 transition-opacity lg:hidden" style="display: none;"></div>

        <aside
            x-show="sidebarOpen"
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="-translate-x-full"
            x-transition:enter-end="translate-x-0"
            x-transition:leave="transition ease-in duration-300"
            x-transition:leave-start="translate-x-0"
            x-transition:leave-end="-translate-x-full"
            class="fixed inset-y-0 left-0 z-30 w-64 overflow-y-auto bg-brand-dark text-white shadow-lg lg:static lg:inset-auto lg:translate-x-0 lg:flex lg:flex-shrink-0"
            style="display: none;"
        >
            <div class="flex flex-col h-full">
                <div class="flex items-center justify-center h-20 border-b border-gray-700">
                    <h1 class="text-2xl font-bold font-display">Admin</h1>
                </div>

                <nav class="flex-1 px-4 py-6 space-y-2">
                    <a href="{{ route('admin.dashboard') }}" class="flex items-center px-4 py-2 bg-gray-700 rounded-lg text-white">
                        <svg class="h-6 w-6 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-7-4h10"></path></svg>
                        <span>Dashboard</span>
                    </a>
                    <a href="#" class="flex items-center px-4 py-2 rounded-lg text-gray-300 hover:bg-gray-700 hover:text-white">
                        <svg class="h-6 w-6 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                        <span>Kelola Pesanan</span>
                    </a>
                    <a href="#" class="flex items-center px-4 py-2 rounded-lg text-gray-300 hover:bg-gray-700 hover:text-white">
                        <svg class="h-6 w-6 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
                        <span>Kelola Menu</span>
                    </a>
                    <a href="#" class="flex items-center px-4 py-2 rounded-lg text-gray-300 hover:bg-gray-700 hover:text-white">
                        <svg class="h-6 w-6 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>
                        <span>Laporan</span>
                    </a>
                </nav>
            </div>
        </aside>

        <div class="flex-1 flex flex-col overflow-hidden">
            <header class="flex items-center justify-between h-20 px-6 py-4 bg-white border-b">
                <button @click="sidebarOpen = true" class="text-gray-500 focus:outline-none lg:hidden">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                    </svg>
                </button>

                <div class="flex-1"></div>

                <div class="flex items-center">
                    <form method="POST" action="{{ route('admin.logout') }}">
                        @csrf
                        <button type="submit" class="flex items-center text-sm text-gray-500 hover:text-red-600">
                            <svg class="h-5 w-5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                            <span>Logout</span>
                        </button>
                    </form>
                </div>
            </header>

            <main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-100 p-8">
                <div class="container mx-auto">
                    <h2 class="text-3xl font-bold text-gray-800 mb-6">Dashboard</h2>

                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        <div class="bg-white p-6 rounded-lg shadow-lg">
                            <h3 class="text-lg font-semibold text-gray-600">Pesanan Baru</h3>
                            <p class="text-3xl font-bold text-gray-800">12</p>
                        </div>
                        <div class="bg-white p-6 rounded-lg shadow-lg">
                            <h3 class="text-lg font-semibold text-gray-600">Total Menu Aktif</h3>
                            <p class="text-3xl font-bold text-gray-800">{{-- 12 (Nanti ambil dari DB) --}}</p>
                        </div>
                        <div class="bg-white p-6 rounded-lg shadow-lg">
                            <h3 class="text-lg font-semibold text-gray-600">Pendapatan Hari Ini</h3>
                            <p class="text-3xl font-bold text-green-600">Rp 1.250.000</p>
                        </div>
                    </div>

                    <div class="mt-10 bg-white rounded-lg shadow-lg overflow-hidden">
                        <h3 class="text-xl font-semibold text-gray-800 p-6 border-b">Pesanan Masuk Terbaru</h3>
                        <table class="w-full">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID Pesanan</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Pelanggan</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200">
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">#1001</td>
                                    <td class="px-6 py-4 whitespace-nowrap">Meja 05</td>
                                    <td class="px-6 py-4 whitespace-nowrap">Rp 78.000</td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                            Pending
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        <a href="#" class="text-indigo-600 hover:text-indigo-900">Detail</a>
                                    </td>
                                </tr>
                                </tbody>
                        </table>
                    </div>
                </div>
            </main>
        </div>
    </div>

</body>
</html>
