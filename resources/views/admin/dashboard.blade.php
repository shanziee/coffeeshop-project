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

                <div x-show="currentTab === 'dashboard'" x-transition.opacity>
                    @include('admin.tabs.stats')
                </div>

                <div x-show="currentTab === 'menu'" x-cloak x-transition.opacity>
                    @include('admin.tabs.menu')
                </div>

                <div x-show="currentTab === 'orders'" x-cloak x-transition.opacity>
                    @include('admin.tabs.orders')
                </div>

            </main>
        </div>
    </div>
</body>
</html>
