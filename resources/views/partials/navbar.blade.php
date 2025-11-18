<nav class="bg-brand-dark text-white p-4 sticky top-0 z-50 shadow-xl border-b border-white/10">
    <div class="container mx-auto flex justify-between items-center">
        <a href="{{ url('/') }}" class="text-2xl font-bold font-display tracking-wider hover:text-brand-gold transition">Ngopi Kalcer.</a>

        <div class="flex items-center space-x-5">
            {{-- Tombol Keranjang --}}
            <button @click="isModalOpen = true" class="relative flex items-center space-x-2 hover:text-brand-gold transition duration-300 group">
                <div class="p-2 bg-white/10 rounded-full group-hover:bg-white/20 transition">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>
                </div>
                <span x-show="totalItems > 0" x-text="totalItems" class="absolute -top-1 -right-1 bg-red-500 text-white text-[10px] rounded-full h-4 w-4 flex items-center justify-center font-bold shadow-sm border border-brand-dark"></span>
            </button>

            @auth
                {{-- Dropdown Menu Logout (Menggunakan Alpine.js) --}}
                <div x-data="{ open: false }" @click.outside="open = false" class="relative">
                    <button @click="open = !open" class="flex items-center space-x-2 text-white hover:text-brand-gold focus:outline-none">
                        <div class="hidden md:flex flex-col text-right leading-tight">
                            <span class="text-xs text-gray-400">Halo,</span>
                            <span class="font-semibold text-sm">{{ Str::limit(auth()->user()->name, 10) }}</span>
                        </div>
                        {{-- Icon dropdown --}}
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 transform transition-transform" :class="{ 'rotate-180': open }" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>

                    <div x-show="open"
                        x-transition:enter="transition ease-out duration-200"
                        x-transition:enter-start="opacity-0 scale-95"
                        x-transition:enter-end="opacity-100 scale-100"
                        x-transition:leave="transition ease-in duration-150"
                        x-transition:leave-start="opacity-100 scale-100"
                        x-transition:leave-end="opacity-0 scale-95"
                        class="absolute right-0 mt-2 w-40 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 z-20"
                        style="display: none;"
                    >
                        <form method="POST" action="{{ route('logout') }}" class="py-1">
                            @csrf
                            <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-red-500 hover:text-white transition">
                                <span class="font-semibold">Logout</span>
                            </button>
                        </form>
                    </div>
                </div>
            @else
                <a href="{{ url('/login') }}" class="text-sm font-bold bg-brand-gold text-white px-5 py-2 rounded-full hover:bg-yellow-600 transition shadow-lg">Login</a>
            @endauth
        </div>
    </div>
</nav>
