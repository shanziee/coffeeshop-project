<nav class="bg-brand-dark text-white p-4 sticky top-0 z-50 shadow-xl border-b border-white/10">
    <div class="container mx-auto flex justify-between items-center">
        <a href="{{ url('/') }}" class="text-2xl font-bold font-display tracking-wider hover:text-brand-gold transition">Ngopi Kalcer.</a>

        <div class="flex items-center space-x-5">
            <button @click="isModalOpen = true" class="relative flex items-center space-x-2 hover:text-brand-gold transition duration-300 group">
                <div class="p-2 bg-white/10 rounded-full group-hover:bg-white/20 transition">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>
                </div>
                <span x-show="totalItems > 0" x-text="totalItems" class="absolute -top-1 -right-1 bg-red-500 text-white text-[10px] rounded-full h-4 w-4 flex items-center justify-center font-bold shadow-sm border border-brand-dark"></span>
            </button>

            @auth
                <div class="hidden md:flex flex-col text-right leading-tight">
                    <span class="text-xs text-gray-400">Halo,</span>
                    <span class="font-semibold text-sm">{{ Str::limit(auth()->user()->name, 10) }}</span>
                </div>
            @else
                <a href="{{ url('/login') }}" class="text-sm font-bold bg-brand-gold text-white px-5 py-2 rounded-full hover:bg-yellow-600 transition shadow-lg">Login</a>
            @endauth
        </div>
    </div>
</nav>
