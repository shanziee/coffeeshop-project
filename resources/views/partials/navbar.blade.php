<nav class="bg-brand-dark text-white p-4 sticky top-0 z-50 shadow-xl border-b border-white/10">
    <div class="container mx-auto flex justify-between items-center">

        <a href="{{ url('/') }}" class="text-2xl font-bold font-display tracking-wider hover:text-brand-gold transition">
            Ngopi Kalcer.
        </a>

        <div class="flex items-center space-x-5">

            {{-- Tombol Keranjang (Selalu Muncul) --}}
            <button @click="isModalOpen = true" class="relative flex items-center space-x-2 hover:text-brand-gold transition duration-300 group">
                <div class="p-2 bg-white/10 rounded-full group-hover:bg-white/20 transition">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>
                </div>
                <span x-show="totalItems > 0" x-text="totalItems" class="absolute -top-1 -right-1 bg-red-500 text-white text-[10px] rounded-full h-4 w-4 flex items-center justify-center font-bold shadow-sm border border-brand-dark"></span>
            </button>

            {{-- LOGIKA TAMPILAN USER (PENTING UNTUK FITUR LOGOUT) --}}
            @auth
                {{-- JIKA SUDAH LOGIN: Tampilkan Nama & Dropdown Logout --}}
                <div x-data="{ open: false }" @click.outside="open = false" class="relative">
                    <button @click="open = !open" class="flex items-center space-x-2 text-white hover:text-brand-gold focus:outline-none transition">
                        <div class="hidden md:flex flex-col text-right leading-tight">
                            <span class="text-[10px] text-gray-400 uppercase tracking-wider">Halo,</span>
                            <span class="font-bold text-sm">{{ Str::limit(auth()->user()->name, 12) }}</span>
                        </div>
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 transform transition-transform duration-200" :class="{ 'rotate-180': open }" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>

                    <div x-show="open"
                        x-transition:enter="transition ease-out duration-200"
                        x-transition:enter-start="opacity-0 scale-95 translate-y-2"
                        x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                        x-transition:leave="transition ease-in duration-150"
                        x-transition:leave-start="opacity-100 scale-100 translate-y-0"
                        x-transition:leave-end="opacity-0 scale-95 translate-y-2"
                        class="absolute right-0 mt-3 w-48 rounded-xl shadow-2xl bg-white ring-1 ring-black ring-opacity-5 z-50 overflow-hidden"
                        style="display: none;"
                    >
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="w-full text-left px-4 py-3 text-sm text-red-600 hover:bg-red-50 transition flex items-center gap-2">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                                </svg>
                                <span class="font-bold">Keluar / Logout</span>
                            </button>
                        </form>
                    </div>
                </div>
            @else
                {{-- JIKA BELUM LOGIN: Tampilkan Tombol Masuk --}}
                <div class="flex items-center gap-3">
                    <a href="{{ route('login') }}" class="text-sm font-bold text-white hover:text-brand-gold transition">
                        Masuk
                    </a>
                    <a href="{{ route('register') }}" class="text-sm font-bold bg-brand-gold text-white px-5 py-2 rounded-full hover:bg-yellow-600 transition shadow-lg transform hover:-translate-y-0.5">
                        Daftar
                    </a>
                </div>
            @endauth
        </div>
    </div>
</nav>
