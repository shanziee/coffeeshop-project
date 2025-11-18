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

<body x-data="menuApp()">

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
    </header>

    <main id="menu-section" class="container mx-auto p-6 md:p-12 min-h-screen relative z-20">

        <div class="text-center mb-8 mt-8">
            <span class="text-brand-gold font-bold tracking-widest uppercase text-sm">Our Favorites</span>
            <h2 class="font-display text-4xl md:text-5xl font-bold text-brand-dark mt-2">Menu Pilihan</h2>
            <div class="w-24 h-1 bg-brand-gold mx-auto mt-4 rounded-full"></div>
        </div>

        <div class="max-w-3xl mx-auto mb-12 space-y-6">
            <div class="relative">
                <input type="text" x-model="searchQuery" placeholder="Cari menu favoritmu..."
                       class="w-full px-6 py-4 rounded-full border-2 border-gray-200 focus:border-brand-gold focus:ring-0 outline-none text-gray-700 shadow-sm transition pl-12">
                <svg class="w-6 h-6 text-gray-400 absolute left-4 top-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
            </div>

            <div class="flex justify-center gap-4">
                <button @click="activeTab = 'minuman'"
                        :class="activeTab === 'minuman' ? 'bg-brand-dark text-white border-brand-dark' : 'bg-transparent text-brand-dark border-brand-dark hover:bg-brand-dark/5'"
                        class="px-6 py-2 rounded-full font-bold border-2 transition-all duration-300 w-32">
                    Minuman
                </button>
                <button @click="activeTab = 'makanan'"
                        :class="activeTab === 'makanan' ? 'bg-brand-dark text-white border-brand-dark' : 'bg-transparent text-brand-dark border-brand-dark hover:bg-brand-dark/5'"
                        class="px-6 py-2 rounded-full font-bold border-2 transition-all duration-300 w-32">
                    Makanan
                </button>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            <template x-if="filteredMenus.length === 0">
                <div class="col-span-full text-center py-12 text-gray-500">
                    <p class="text-xl">Menu tidak ditemukan.</p>
                </div>
            </template>

            <template x-for="menu in filteredMenus" :key="menu.id">
                <div class="bg-white rounded-2xl shadow-lg overflow-hidden hover:shadow-2xl transition-all duration-300 hover:-translate-y-2 group border border-gray-100 flex flex-col">
                    <div class="relative overflow-hidden h-64">
                        <img :src="menu.image" class="w-full h-full object-cover group-hover:scale-110 transition duration-700">
                        <div class="absolute inset-0 bg-black/20 group-hover:bg-transparent transition duration-300"></div>
                    </div>
                    <div class="p-6 relative flex flex-col flex-grow">
                        <div class="absolute -top-6 right-6 bg-brand-gold text-white px-4 py-2 rounded-lg shadow-md font-bold text-lg">
                            <span x-text="formatCurrency(menu.price)"></span>
                        </div>
                        <h3 x-text="menu.name" class="font-display text-2xl font-bold text-brand-dark mb-2"></h3>
                        <p class="text-gray-500 text-sm leading-relaxed mb-6 line-clamp-2 flex-grow" x-text="menu.description"></p>

                        <button @click="openDetail(menu)" class="w-full bg-brand-dark text-white py-3 rounded-xl font-semibold hover:bg-gray-800 transition flex justify-center items-center gap-2 group-hover:shadow-lg">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" /></svg>
                            <span>Pilih</span>
                        </button>
                    </div>
                </div>
            </template>
        </div>
    </main>

    <footer class="bg-brand-dark text-white py-12 mt-20 border-t border-white/10">
        <div class="container mx-auto px-6">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 text-center md:text-left">

                <div>
                    <h3 class="font-display text-2xl font-bold mb-4 text-brand-gold">Ngopi Kalcer.</h3>
                    <p class="text-gray-400 text-sm leading-relaxed max-w-xs mx-auto md:mx-0">
                        Tempat di mana estetika bertemu rasa. Kami menyajikan kopi pilihan nusantara dengan sentuhan modern untuk menemani setiap cerita hari-harimu.
                    </p>
                </div>

                <div>
                    <h3 class="font-display text-xl font-bold mb-4 text-brand-gold">Contact Us</h3>
                    <ul class="space-y-3 text-sm text-gray-300">
                        <li class="flex flex-col md:flex-row items-center md:items-start gap-2 justify-center md:justify-start">
                            <span class="font-bold text-brand-gold">Ihsan:</span> <span>0857-7749-6199</span>
                        </li>
                        <li class="flex flex-col md:flex-row items-center md:items-start gap-2 justify-center md:justify-start">
                            <span class="font-bold text-brand-gold">Aji:</span> <span>0858-7620-0487</span>
                        </li>
                        <li class="flex flex-col md:flex-row items-center md:items-start gap-2 justify-center md:justify-start">
                            <span class="font-bold text-brand-gold">Haikal:</span> <span>0813-5803-3317</span>
                        </li>
                    </ul>
                </div>

                <div>
                    <h3 class="font-display text-xl font-bold mb-4 text-brand-gold">Alamat</h3>
                    <p class="text-gray-400 text-sm leading-relaxed">
                        Jl. Kopi No. 123,<br>
                        Jakarta Selatan,<br>
                        Indonesia
                    </p>
                </div>

            </div>

            <div class="text-center border-t border-white/10 pt-8 mt-8 text-gray-500 text-xs">
                &copy; 2025 Ngopi Kalcer. All Rights Reserved.
            </div>
        </div>
    </footer>

    <div x-show="isDetailModalOpen"
         class="fixed inset-0 bg-black/60 backdrop-blur-sm flex items-center justify-center z-50 p-4"
         style="display: none;"
         x-transition>

        <div class="bg-white w-full max-w-3xl rounded-2xl shadow-2xl overflow-hidden flex flex-col md:flex-row relative" @click.outside="isDetailModalOpen = false">

            <button @click="isDetailModalOpen = false" class="absolute top-4 right-4 z-10 bg-white rounded-full p-1 shadow hover:bg-gray-100">
                <svg class="w-6 h-6 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>

            <div class="w-full md:w-1/2 h-64 md:h-auto bg-gray-100 relative">
                 <template x-if="selectedMenu">
                    <img :src="selectedMenu.image" class="w-full h-full object-cover">
                 </template>
            </div>

            <div class="w-full md:w-1/2 p-8 flex flex-col justify-between">
                <template x-if="selectedMenu">
                    <div>
                        <span x-text="selectedMenu.category" class="text-xs font-bold text-brand-gold uppercase tracking-widest"></span>
                        <h2 x-text="selectedMenu.name" class="font-display text-3xl font-bold text-brand-dark mb-2"></h2>
                        <p x-text="formatCurrency(selectedMenu.price)" class="text-2xl font-semibold text-gray-800 mb-4"></p>
                        <p x-text="selectedMenu.description" class="text-gray-600 text-sm leading-relaxed mb-6"></p>

                        <div x-show="selectedMenu.category === 'minuman'" class="mb-6">
                            <h4 class="text-sm font-bold text-gray-700 mb-3">Level Gula</h4>
                            <div class="grid grid-cols-4 gap-2">
                                <div class="relative">
                                    <input type="radio" id="sugar0" name="sugar" value="0%" class="peer hidden" x-model="detailSugar">
                                    <label for="sugar0" class="block text-center border border-gray-300 rounded-lg py-2 text-xs font-semibold text-gray-500 cursor-pointer hover:bg-gray-50 transition select-none">0%</label>
                                </div>
                                <div class="relative">
                                    <input type="radio" id="sugar50" name="sugar" value="50%" class="peer hidden" x-model="detailSugar">
                                    <label for="sugar50" class="block text-center border border-gray-300 rounded-lg py-2 text-xs font-semibold text-gray-500 cursor-pointer hover:bg-gray-50 transition select-none">Less</label>
                                </div>
                                <div class="relative">
                                    <input type="radio" id="sugar100" name="sugar" value="100%" class="peer hidden" x-model="detailSugar">
                                    <label for="sugar100" class="block text-center border border-gray-300 rounded-lg py-2 text-xs font-semibold text-gray-500 cursor-pointer hover:bg-gray-50 transition select-none">Normal</label>
                                </div>
                                <div class="relative">
                                    <input type="radio" id="sugar125" name="sugar" value="125%" class="peer hidden" x-model="detailSugar">
                                    <label for="sugar125" class="block text-center border border-gray-300 rounded-lg py-2 text-xs font-semibold text-gray-500 cursor-pointer hover:bg-gray-50 transition select-none">Extra</label>
                                </div>
                            </div>
                        </div>
                    </div>
                </template>

                <div>
                    <div class="flex items-center justify-between mb-6 bg-gray-50 p-3 rounded-xl">
                        <span class="text-gray-700 font-medium text-sm">Jumlah</span>
                        <div class="flex items-center space-x-4">
                            <button @click="if(detailQuantity > 1) detailQuantity--" class="w-8 h-8 rounded-full bg-white shadow text-gray-600 hover:text-brand-dark font-bold">-</button>
                            <span x-text="detailQuantity" class="text-lg font-bold w-6 text-center"></span>
                            <button @click="detailQuantity++" class="w-8 h-8 rounded-full bg-white shadow text-gray-600 hover:text-brand-dark font-bold">+</button>
                        </div>
                    </div>

                    <button @click="addToCartFromDetail()" class="w-full bg-brand-dark text-white py-4 rounded-xl font-bold text-lg hover:bg-gray-800 transition shadow-lg flex justify-center items-center gap-2">
                        <span>Masuk Keranjang</span>
                        <template x-if="selectedMenu">
                            <span class="text-sm font-normal opacity-80" x-text="'(' + formatCurrency(selectedMenu.price * detailQuantity) + ')'"></span>
                        </template>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div x-show="isModalOpen"
         class="fixed inset-0 bg-black/60 backdrop-blur-sm flex items-end md:items-center justify-center z-50"
         style="display: none;"
         x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-10" x-transition:enter-end="opacity-100 translate-y-0" x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100 translate-y-0" x-transition:leave-end="opacity-0 translate-y-10">

        <div class="bg-white w-full md:max-w-lg md:rounded-2xl rounded-t-2xl shadow-2xl flex flex-col max-h-[90vh]" @click.outside="isModalOpen = false">
            <div class="p-6 border-b border-gray-100 flex justify-between items-center bg-gray-50 md:rounded-t-2xl">
                <div>
                    <h3 class="font-display text-2xl font-bold text-brand-dark">Keranjang Saya</h3>
                    <p class="text-sm text-gray-500">Periksa pesanan Anda sebelum bayar</p>
                </div>
                <button @click="isModalOpen = false" class="p-2 hover:bg-gray-200 rounded-full transition"><svg class="w-6 h-6 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg></button>
            </div>

            <div class="p-6 overflow-y-auto flex-1 space-y-4">
                <template x-if="cart.length === 0">
                    <div class="text-center py-12">
                        <p class="text-gray-500 font-medium">Keranjang masih kosong.</p>
                        <button @click="isModalOpen = false" class="mt-4 text-brand-gold font-bold hover:underline text-sm">Tambah Menu</button>
                    </div>
                </template>

                <template x-for="item in cart" :key="item.cartId">
                    <div class="flex justify-between items-center bg-white border border-gray-100 p-4 rounded-xl shadow-sm">
                        <div class="flex items-center gap-4">
                            <div class="bg-gray-100 h-16 w-16 rounded-lg bg-cover bg-center" :style="`background-image: url(${item.image})`"></div>
                            <div>
                                <h4 x-text="item.name" class="font-bold text-brand-dark"></h4>
                                <div class="flex flex-col">
                                    <span x-text="formatCurrency(item.price)" class="text-xs text-gray-500"></span>
                                    <template x-if="item.sugar">
                                        <span class="text-[10px] bg-gray-100 text-gray-600 px-2 py-0.5 rounded mt-1 w-max">Gula: <span x-text="item.sugar"></span></span>
                                    </template>
                                </div>
                            </div>
                        </div>
                        <div class="flex flex-col items-end gap-2">
                            <span x-text="formatCurrency(item.price * item.quantity)" class="font-bold text-brand-dark"></span>
                            <button @click="removeItem(item.cartId)" class="text-xs text-red-500 hover:underline">Hapus</button>
                        </div>
                    </div>
                </template>
            </div>

            <div x-show="cart.length > 0" class="p-6 border-t border-gray-100 bg-gray-50 md:rounded-b-2xl">
                <div class="space-y-3 mb-6 text-sm">
                    <div class="flex justify-between text-gray-600"><span>Subtotal</span><span x-text="formatCurrency(subTotal)"></span></div>
                    <div class="flex justify-between text-gray-600"><span>Pajak (10%)</span><span x-text="formatCurrency(tax)"></span></div>
                    <div class="border-t border-gray-300 my-2"></div>
                    <div class="flex justify-between text-xl font-bold text-brand-dark"><span>Total Bayar</span><span x-text="formatCurrency(grandTotal)"></span></div>
                </div>
                <button @click="processPayment()" class="w-full bg-brand-dark text-white font-bold py-4 rounded-xl shadow-lg hover:bg-gray-800 transition">Bayar Sekarang</button>
            </div>
        </div>
    </div>

    <div x-show="showReceipt" class="fixed inset-0 bg-black/80 backdrop-blur-sm flex items-center justify-center z-50 p-4" style="display: none;" x-transition>
        <div class="bg-white w-full max-w-sm p-0 shadow-2xl relative transform transition-all scale-100" @click.outside="closeReceipt()">
            <div class="bg-white p-8 relative pattern-paper">
                <div class="text-center border-b-2 border-dashed border-gray-300 pb-6 mb-6">
                    <h2 class="font-display text-3xl font-bold text-black uppercase tracking-widest mb-1">Ngopi Kalcer</h2>
                    <p class="font-mono text-xs text-gray-500">Jl. Kopi No. 123, Jakarta</p>
                    <p class="font-mono text-xs text-gray-400 mt-1" x-text="receiptDate"></p>
                </div>
                <div class="space-y-3 font-mono text-sm text-gray-800 mb-6">
                    <template x-for="item in receiptItems" :key="item.cartId">
                        <div class="flex justify-between items-end">
                            <div>
                                <div class="font-bold" x-text="item.name"></div>
                                <div class="text-xs text-gray-500">
                                    <span x-text="item.quantity"></span> x <span x-text="formatCurrency(item.price)"></span>
                                    <span x-show="item.sugar" x-text="'(' + item.sugar + ')'"></span>
                                </div>
                            </div>
                            <span x-text="formatCurrency(item.price * item.quantity)"></span>
                        </div>
                    </template>
                </div>
                <div class="border-t-2 border-dashed border-gray-300 pt-4 space-y-2 font-mono text-sm">
                    <div class="flex justify-between text-gray-500"><span>Subtotal</span><span x-text="formatCurrency(receiptSubTotal)"></span></div>
                    <div class="flex justify-between text-gray-500"><span>Tax (10%)</span><span x-text="formatCurrency(receiptTax)"></span></div>
                    <div class="flex justify-between font-bold text-xl text-black mt-4 pt-2 border-t border-gray-200"><span>TOTAL</span><span x-text="formatCurrency(receiptTotal)"></span></div>
                </div>
                <div class="absolute -bottom-3 left-0 w-full h-6 bg-white" style="clip-path: polygon(0% 0%, 5% 100%, 10% 0%, 15% 100%, 20% 0%, 25% 100%, 30% 0%, 35% 100%, 40% 0%, 45% 100%, 50% 0%, 55% 100%, 60% 0%, 65% 100%, 70% 0%, 75% 100%, 80% 0%, 85% 100%, 90% 0%, 95% 100%, 100% 0%);"></div>
            </div>
            <div class="p-4 bg-transparent mt-4">
                <button @click="closeReceipt()" class="w-full bg-gray-900 hover:bg-black text-white py-3 font-bold rounded-xl shadow-lg transition">Tutup</button>
            </div>
        </div>
    </div>

    <script>
        function menuApp() {
            return {
                cart: [],
                activeTab: 'minuman',
                searchQuery: '',

                // State Modal
                isModalOpen: false,         // Modal Keranjang
                isDetailModalOpen: false,   // Modal Detail Menu
                showReceipt: false,         // Modal Struk

                isLoggedIn: {{ auth()->check() ? 'true' : 'false' }},

                // State Detail Menu Sementara
                selectedMenu: null,
                detailQuantity: 1,
                detailSugar: '100%', // Default Sugar

                // Data Struk
                receiptItems: [],
                receiptTotal: 0,
                receiptSubTotal: 0,
                receiptTax: 0,
                receiptDate: '',
                orderId: '',

                // MENU DATA
                menus: [
                    { id: 1, name: 'Caffe Latte', price: 28000, category: 'minuman', description: 'Espresso dengan susu segar yang lembut.', image: '{{ asset('images/menu/cafe-latte.png') }}' },
                    { id: 2, name: 'Matcha Latte', price: 26000, category: 'minuman', description: 'Bubuk matcha Jepang asli dengan susu.', image: '{{ asset('images/menu/Matcha-Lattee.png') }}' },
                    { id: 3, name: 'Signature Americano', price: 22000, category: 'minuman', description: 'Espresso shot ganda dengan air panas.', image: '{{ asset('images/menu/Signature-Americano.png') }}' },
                    { id: 4, name: 'Signature Chocolate', price: 28000, category: 'minuman', description: 'Cokelat premium Belgia yang kaya rasa.', image: '{{ asset('images/menu/signature-chocolate.png') }}' },
                    { id: 5, name: 'Espresso', price: 18000, category: 'minuman', description: 'Ekstrak kopi murni yang kuat dan nikmat.', image: '{{ asset('images/menu/espresso.png') }}' },
                    { id: 9, name: 'Kopi Tubruk', price: 20000, category: 'minuman', description: 'Kopi hitam tradisional dengan ampas.', image: '{{ asset('images/menu/kopi-tubruk.png') }}' },
                    { id: 6, name: 'Butter Croissant', price: 22000, category: 'makanan', description: 'Pastry renyah dengan mentega Prancis.', image: '{{ asset('images/menu/butter-croissant.png') }}' },
                    { id: 7, name: 'Choco Chip Cookies', price: 15000, category: 'makanan', description: 'Kue kering manis dengan butiran cokelat.', image: '{{ asset('images/menu/choco-chip-cookies.png') }}' },
                    { id: 8, name: 'Tuna Sandwich', price: 30000, category: 'makanan', description: 'Roti lapis isi tuna dan sayuran segar.', image: '{{ asset('images/menu/tuna-sandwich.png') }}' },
                    { id: 10, name: 'Red Velvet Cake', price: 32000, category: 'makanan', description: 'Kue lembut dengan krim keju yang manis.', image: '{{ asset('images/menu/red-velvet-cake.png') }}' },
                    { id: 11, name: 'Kentang Goreng', price: 20000, category: 'makanan', description: 'Kentang goreng renyah bumbu spesial.', image: '{{ asset('images/menu/kentang-goreng.png') }}' },
                    { id: 12, name: 'Banana Bread', price: 25000, category: 'makanan', description: 'Roti pisang lembut, manis alami.', image: '{{ asset('images/menu/banana-bread.png') }}' }
                ],

                get filteredMenus() {
                    return this.menus.filter(menu => {
                        const matchesCategory = menu.category === this.activeTab;
                        const matchesSearch = menu.name.toLowerCase().includes(this.searchQuery.toLowerCase());
                        return matchesCategory && matchesSearch;
                    });
                },

                // --- FUNGSI PEMESANAN BARU ---

                // 1. Buka Modal Detail
                openDetail(menu) {
                    this.selectedMenu = menu;
                    this.detailQuantity = 1;
                    this.detailSugar = '100%'; // Reset Sugar ke Normal
                    this.isDetailModalOpen = true;
                },

                // 2. Masukkan ke Keranjang (Dengan Opsi Gula)
                addToCartFromDetail() {
                    if (!this.selectedMenu) return;

                    // Cek apakah item dengan opsi yang SAMA persis sudah ada di cart?
                    // Tapi untuk simplifikasi agar fitur "beda gula = beda item" jalan, kita push sebagai item baru.

                    const cartItem = {
                        ...this.selectedMenu,
                        quantity: this.detailQuantity,
                        sugar: this.selectedMenu.category === 'minuman' ? this.detailSugar : null,
                        cartId: Date.now() + Math.random() // ID unik untuk keranjang agar bisa beda gula
                    };

                    this.cart.push(cartItem);
                    this.isDetailModalOpen = false; // Tutup detail
                    this.isModalOpen = true;        // Buka keranjang otomatis
                },

                // Hapus item dari keranjang
                removeItem(cartId) {
                    this.cart = this.cart.filter(item => item.cartId !== cartId);
                },

                get totalItems() { return this.cart.reduce((sum, i) => sum + i.quantity, 0); },
                get subTotal() { return this.cart.reduce((sum, i) => sum + (i.price * i.quantity), 0); },
                get tax() { return this.subTotal * 0.1; },
                get grandTotal() { return this.subTotal + this.tax; },

                formatCurrency(val) {
                    return new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0 }).format(val);
                },

                async processPayment() {
                    if (!this.isLoggedIn) {
                        alert('Silakan Login terlebih dahulu!');
                        window.location.href = '/login';
                        return;
                    }

                    // Kirim data, sertakan info gula di nama item agar muncul di Midtrans dashboard jika perlu
                    const orderData = {
                        total_price: this.grandTotal,
                        items: this.cart.map(item => ({
                            id: item.id,
                            price: item.price,
                            quantity: item.quantity,
                            name: item.name + (item.sugar ? ` (${item.sugar})` : '')
                        }))
                    };

                    try {
                        const response = await fetch("{{ route('checkout.process') }}", {
                            method: "POST",
                            headers: { "Content-Type": "application/json", "X-CSRF-TOKEN": "{{ csrf_token() }}" },
                            body: JSON.stringify(orderData)
                        });
                        const data = await response.json();
                        if (data.snap_token) {
                            window.snap.pay(data.snap_token, {
                                onSuccess: (result) => { this.generateReceipt(result); },
                                onPending: (result) => { alert("Menunggu pembayaran!"); },
                                onError: (result) => { alert("Pembayaran gagal!"); },
                                onClose: () => { alert("Anda menutup popup."); }
                            });
                        } else { alert("Gagal mendapatkan Token Pembayaran."); }
                    } catch (error) {
                        console.error(error);
                        alert("Terjadi kesalahan sistem.");
                    }
                },

                generateReceipt(result) {
                    this.receiptItems = JSON.parse(JSON.stringify(this.cart));
                    this.receiptSubTotal = this.subTotal;
                    this.receiptTax = this.tax;
                    this.receiptTotal = this.grandTotal;
                    this.receiptDate = new Date().toLocaleString('id-ID');
                    this.orderId = result.order_id;
                    this.isModalOpen = false;
                    this.showReceipt = true;
                    this.cart = [];
                },

                closeReceipt() {
                    this.showReceipt = false;
                }
            };
        }
    </script>
</body>
</html>
