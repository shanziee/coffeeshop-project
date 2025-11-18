<header class="relative h-[85vh] min-h-[600px] flex items-center justify-center overflow-hidden group">
    <div class="absolute inset-0 bg-cover bg-center transition-transform duration-[10s] ease-out group-hover:scale-110"
         style="background-image: url('{{ asset('images/home.png') }}');">
    </div>
    <div class="absolute inset-0 bg-gradient-to-b from-black/70 via-black/40 to-brand-dark/90"></div>

    <div class="relative z-10 text-center px-4 max-w-5xl mx-auto space-y-6"
         x-data="{ show: false }" x-init="setTimeout(() => show = true, 100)">

        <div x-show="show" x-transition:enter="transition ease-out duration-1000 delay-300" x-transition:enter-start="opacity-0 translate-y-10" x-transition:enter-end="opacity-100 translate-y-0"
             class="inline-block px-4 py-1 border border-brand-gold/50 text-brand-gold rounded-full text-xs font-semibold tracking-[0.2em] uppercase mb-2 bg-black/20 backdrop-blur-sm">
            Premium Coffee Experience
        </div>

        <h1 x-show="show" x-transition:enter="transition ease-out duration-1000 delay-500" x-transition:enter-start="opacity-0 translate-y-10" x-transition:enter-end="opacity-100 translate-y-0"
            class="font-display text-5xl md:text-7xl lg:text-8xl font-bold text-white leading-tight drop-shadow-2xl">
            Rasakan <span class="text-brand-gold italic">Estetika</span><br>
            Dalam Setiap Tegukan
        </h1>

        <div x-show="show" x-transition:enter="transition ease-out duration-1000 delay-1000" x-transition:enter-start="opacity-0 translate-y-10" x-transition:enter-end="opacity-100 translate-y-0"
             class="pt-8">
            <a href="#menu-section" class="group bg-brand-gold text-white px-8 py-4 rounded-full font-bold text-lg transition transform hover:scale-105 hover:bg-yellow-600 shadow-[0_0_20px_rgba(200,160,99,0.3)] inline-flex items-center gap-3">
                <span>Pesan Sekarang</span>
                <span>↓</span>
            </a>
        </div>
    </div>

    <div class="absolute bottom-0 left-0 w-full overflow-hidden leading-none">
        <svg class="relative block w-[calc(130%+1.3px)] h-[70px] md:h-[120px]" data-name="Layer 1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1200 120" preserveAspectRatio="none">
            <path d="M321.39,56.44c58-10.79,114.16-30.13,172-41.86,82.39-16.72,168.19-17.73,250.45-.39C823.78,31,906.67,72,985.66,92.83c70.05,18.48,146.53,26.09,214.34,3V0H0V27.35A600.21,600.21,0,0,0,321.39,56.44Z" class="fill-[#f8f5f2]"></path>
        </svg>
    </div>
</header>
