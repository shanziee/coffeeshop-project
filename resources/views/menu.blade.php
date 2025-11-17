<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menu - Ngopi Kalcer</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;700&family=Playfair+Display:wght@700&display=swap" rel="stylesheet">

    <style>
        /* ... (Style Anda tetap sama) ... */
        html { scroll-behavior: smooth; }
        body { font-family: 'Inter', sans-serif; background-color: #f8f5f2; }
        .font-display { font-family: 'Playfair Display', serif; }
        .bg-brand-dark { background-color: #2a231f; }
        .bg-brand-light { background-color: #f8f5f2; }
        .text-brand-dark { color: #2a231f; }
        .text-brand-gold { color: #c8a063; }
        .btn-brand { background-color: #c8a063; color: #ffffff; transition: all 0.3s; }
        .btn-brand:hover { background-color: #b08d53; }
        .btn-outline-brand { border: 2px solid #c8a063; color: #c8a063; transition: all 0.3s; }
        .btn-outline-brand:hover { background-color: #c8a063; color: white; }
        input[type='number']::-webkit-inner-spin-button,
        input[type='number']::-webkit-outer-spin-button { -webkit-appearance: none; margin: 0; }
        input[type='number'] { -moz-appearance: textfield; }
    </style>
</head>

<body x-data="{
    activeTab: 'minuman',
    searchQuery: '',
    isModalOpen: false,
    isSuccess: false,
    isLoginModalOpen: false,
    cart: [],
    biayaLayanan: 4000,
    isLoggedIn: {{ auth()->check() ? 'true' : 'false' }},

    // ARRAY MENU ANDA - pastikan tidak ada kesalahan sintaks
    menus: [
        // Minuman
        { id: 1, name: 'Caffe Latte', price: 28000, description: 'Perpaduan seimbang antara espresso kaya rasa dan susu steam yang lembut.', image: '{{ asset('images/menu/cafe-latte.png') }}', category: 'minuman' },
        { id: 2, name: 'Matcha Latte', price: 26000, description: 'Bubuk matcha premium dari Jepang dengan susu pilihan, disajikan hangat atau dingin.', image: '{{ asset('images/menu/Matcha-Lattee.png') }}', category: 'minuman' },
        { id: 3, name: 'Signature Americano', price: 22000, description: 'Espresso shot ganda disajikan dengan air panas, untuk rasa kopi yang kuat.', image: '{{ asset('images/menu/Signature-Americano.png') }}', category: 'minuman' },
        { id: 4, name: 'Signature Chocolate', price: 28000, description: 'Cokelat premium hangat atau dingin, disajikan dengan susu lembut.', image: '{{ asset('images/menu/signature-chocolate.png') }}', category: 'minuman' },
        { id: 5, name: 'Espresso', price: 18000, description: 'Ekstrak kopi murni kaya rasa (single shot) untuk penikmat kopi sejati.', image: '{{ asset('images/menu/espresso.png') }}', category: 'minuman' },
        { id: 9, name: 'Kopi Tubruk', price: 20000, description: 'Kopi hitam tradisional Indonesia diseduh langsung dengan air panas.', image: '{{ asset('images/menu/kopi-tubruk.png') }}', category: 'minuman' },
        // Makanan
        { id: 6, name: 'Butter Croissant', price: 22000, description: 'Pastry renyah dengan mentega premium, teman sempurna untuk kopi Anda.', image: '{{ asset('images/menu/butter-croissant.png') }}', category: 'makanan' },
        { id: 7, name: 'Choco Chip Cookies', price: 15000, description: 'Kue kering renyah dengan butiran cokelat yang meleleh di mulut.', image: '{{ asset('images/menu/choco-chip-cookies.png') }}', category: 'makanan' },
        { id: 8, name: 'Tuna Sandwich', price: 30000, description: 'Roti gandum utuh diisi dengan salad tuna, sayuran segar, dan mayones.', image: '{{ asset('images/menu/tuna-sandwich.png') }}', category: 'makanan' },
        { id: 10, name: 'Red Velvet Cake', price: 32000, description: 'Kue lembut dengan lapisan krim keju yang mewah, cocok untuk bersantai.', image: '{{ asset('images/menu/red-velvet-cake.png') }}', category: 'makanan' },
        { id: 11, name: 'Kentang Goreng', price: 20000, description: 'Kentang renyah di luar dan lembut di dalam, disajikan dengan saus pilihan.', image: '{{ asset('images/menu/kentang-goreng.png') }}', category: 'makanan' },
        { id: 12, name: 'Banana Bread', price: 25000, description: 'Kue pisang panggang yang hangat dan kaya rasa, dengan aroma kayu manis.', image: '{{ asset('images/menu/banana-bread.png') }}', category: 'makanan' }
    ],

    // FUNGSI PINTAR UNTUK MEMFILTER
    get filteredMenus() {
        // 1. Mulai dengan filter berdasarkan tab (Minuman/Makanan)
        let items = this.menus.filter(menu => menu.category === this.activeTab);

        // 2. Jika ada query pencarian, filter lagi
        if (this.searchQuery.trim() !== '') {
            items = items.filter(menu =>
                menu.name.toLowerCase().includes(this.searchQuery.trim().toLowerCase())
            );
        }

        return items;
    },

    // FUNGSI-FUNGSI LAINNYA
    attemptAddToCart(item) {
        if (this.isLoggedIn) {
            this.addToCart(item);
        } else {
            this.isLoginModalOpen = true;
        }
    },
    addToCart(item) {
        let found = this.cart.find(p => p.id === item.id);
        if (found) {
            found.quantity++;
        } else {
            this.cart.push({ ...item, quantity: 1 });
        }
    },
    updateQuantity(id, amount) {
        let found = this.cart.find(p => p.id === id);
        if (found) {
            found.quantity += amount;
            if (found.quantity <= 0) {
                this.removeFromCart(id);
            }
        }
    },
    removeFromCart(id) {
        this.cart = this.cart.filter(p => p.id !== id);
    },
    get totalItems() {
        return this.cart.reduce((sum, item) => sum + item.quantity, 0);
    },
    get subTotal() {
        return this.cart.reduce((sum, item) => sum + (item.price * item.quantity), 0);
    },
    get totalHarga() {
        return this.subTotal > 0 ? this.subTotal + this.biayaLayanan : 0;
    },
    formatCurrency(amount) {
        return new Intl.NumberFormat('id-ID', {
            style: 'currency',
            currency: 'IDR',
            minimumFractionDigits: 0
        }).format(amount);
    },
    submitCheckout() {
        console.log('Pesanan Disubmit:', this.cart);
        this.cart = [];
        this.isModalOpen = false;
        this.isSuccess = true;
    }
}">

    <nav class="bg-brand-dark text-white p-4 sticky top-0 z-50 shadow-lg">
        <div class="container mx-auto flex justify-between items-center">
            <a href="{{ url('/') }}" class="text-2xl font-bold font-display">Ngopi Kalcer</a>
            <div class="hidden md:flex space-x-6">
                <a href="#menu" class="hover:text-brand-gold transition-colors duration-300">Menu</a>
                <a href="#" class="hover:text-brand-gold transition-colors duration-300">Tentang Kami</a>
                <a href="#" class="hover:text-brand-gold transition-colors duration-300">Kontak</a>
            </div>
            <div class="flex items-center space-x-4">
                <button @click="isModalOpen = true" class="relative flex items-center space-x-2 hover:text-brand-gold transition-colors duration-300">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" /></svg>
                    <span>Pilihan Anda</span>
                    <span x-show="totalItems > 0" x-text="totalItems" class="absolute -top-2 -right-3 bg-red-500 text-white text-xs rounded-full h-5 w-5 flex items-center justify-center font-bold" style="display: none;"></span>
                </button>
                @auth
                    <a href="#" class="flex items-center space-x-2 hover:text-brand-gold transition-colors duration-300">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" /></svg>
                        <span>{{ Str::limit(auth()->user()->name, 10) }}</span>
                    </a>
                @else
                    <a href="{{ url('/login') }}" class="flex items-center space-x-2 hover:text-brand-gold transition-colors duration-300">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" /></svg>
                        <span>Login</span>
                    </a>
                @endauth
            </div>
        </div>
    </nav>

    <header class="relative h-screen bg-cover bg-center" style="background-image: url('{{ asset('images/home.png') }}');">
        <div class="absolute inset-0 bg-black bg-opacity-50"></div>
        <div class="relative z-10 flex flex-col items-center justify-center h-full text-center text-white p-4">
            <h1 class="font-display text-5xl md:text-7xl font-bold mb-4">The Finest Coffee Experience</h1>
            <p class="text-xl md:text-2xl mb-8 max-w-2xl">Selamat datang di Ngopi Kalcer. Cita rasa sempurna di setiap cangkir.</p>
            <a href="#menu" class="btn-brand font-bold py-3 px-8 rounded-lg text-lg transform transition-all duration-300 hover:scale-105">
                Lihat Menu
            </a>
        </div>
    </header>

    <main id="menu" class="container mx-auto p-6 md:p-12 min-h-screen">

        <h2 class="font-display text-4xl font-bold text-brand-dark text-center mb-10">Menu Pilihan Kami</h2>

        <div class="mb-8 w-full max-w-lg mx-auto">
            <label for="search" class="sr-only">Cari Menu</label>
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                    <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd" /></svg>
                </div>
                <input
                    type="text"
                    name="search"
                    id="search"
                    x-model.debounce.300ms="searchQuery"
                    class="block w-full pl-12 pr-4 py-3 border border-gray-300 rounded-full bg-white text-gray-900 placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-brand-gold focus:border-brand-gold"
                    placeholder="Cari menu favorit Anda...">
            </div>
        </div>

        <div class="flex justify-center space-x-4 mb-10">
            <button
                @click="activeTab = 'minuman'; searchQuery = ''"
                :class="activeTab === 'minuman' ? 'btn-brand' : 'btn-outline-brand'"
                class="font-bold py-2 px-8 rounded-full transition-all duration-300 text-lg"
            >
                Minuman
            </button>
            <button
                @click="activeTab = 'makanan'; searchQuery = ''"
                :class="activeTab === 'makanan' ? 'btn-brand' : 'btn-outline-brand'"
                class="font-bold py-2 px-8 rounded-full transition-all duration-300 text-lg"
            >
                Makanan
            </button>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            <template x-for="menu in filteredMenus" :key="menu.id">
                <div class="bg-white rounded-lg shadow-lg overflow-hidden transition-all duration-300 hover:shadow-2xl hover:-translate-y-2 group">
                    <img :src="menu.image" :alt="menu.name" class="w-full h-64 object-cover transition-all duration-500 group-hover:scale-110">
                    <div class="p-6">
                        <h3 x-text="menu.name" class="font-display text-2xl font-bold text-brand-dark mb-2"></h3>
                        <p x-text="formatCurrency(menu.price)" class="text-brand-gold text-xl font-semibold mb-4"></p>
                        <p x-text="menu.description" class="text-gray-600 text-sm mb-6"></p>
                        <button @click="attemptAddToCart(menu)" class="w-full btn-brand font-bold py-3 rounded-lg hover:scale-105">
                            Pilih
                        </button>
                    </div>
                </div>
            </template>
        </div>

        <div x-show="filteredMenus.length === 0" class="text-center text-gray-500 py-16" style="display: none;">
            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
            </svg>
            <h3 class="mt-2 text-lg font-medium text-gray-900">Menu Tidak Ditemukan</h3>
            <p class="mt-1 text-sm text-gray-500">Coba ubah kata kunci pencarian Anda atau periksa kategori lain.</p>
        </div>

    </main>

    <footer class="bg-brand-dark text-gray-300 p-10">
        <div class="container mx-auto grid grid-cols-1 md:grid-cols-3 gap-8">
            <div>
                <h3 class="font-display text-2xl text-white mb-4">Ngopi Kalcer</h3>
                <p class="text-sm">Jalan Kopi No. 123, Jakarta, Indonesia</p>
                <p class="text-sm">contact@ngopikalcer.com</p>
            </div>
            <div>
                <h4 class="text-lg font-semibold text-white mb-4">Link Cepat</h4>
                <ul class="space-y-2 text-sm">
                    <li><a href="#" class="hover:text-brand-gold transition-colors duration-300">Tentang Kami</a></li>
                    <li><a href="#menu" class="hover:text-brand-gold transition-colors duration-300">Menu</a></li>
                    <li><a href="#" class="hover:text-brand-gold transition-colors duration-300">Lokasi</a></li>
                </ul>
            </div>
            <div>
                <h4 class="text-lg font-semibold text-white mb-4">Ikuti Kami</h4>
                <div class="flex space-x-4">
                    <a href="#" class="hover:text-brand-gold transition-colors duration-300">Instagram</a>
                    <a href="#" class="hover:text-brand-gold transition-colors duration-300">Facebook</a>
                    <a href="#" class="hover:text-brand-gold transition-colors duration-300">Twitter</a>
                </div>
            </div>
        </div>
        <div class="text-center text-gray-500 text-sm mt-10 border-t border-gray-700 pt-6">
            © 2025 Ngopi Kalcer. All rights reserved.
        </div>
    </footer>

    <div x-show="isModalOpen"
         x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
         class="fixed inset-0 bg-black bg-opacity-60 flex items-center justify-center p-4 z-50"
         @keydown.escape.window="isModalOpen = false"
         style="display: none;">

        <div class="bg-white rounded-xl shadow-xl w-full max-w-lg p-8 overflow-y-auto" style="max-height: 90vh;" @click.outside="isModalOpen = false">
            <h2 class="font-display text-3xl font-bold text-brand-dark text-center mb-6">Pilihan Anda</h2>
            <template x-if="cart.length === 0">
                <p class="text-gray-500 text-center my-10">Pilihan Anda masih kosong. Silakan pilih menu.</p>
            </template>
            <div x-show="cart.length > 0" style="display: none;">
                <div class="space-y-4 mb-5 max-h-64 overflow-y-auto pr-2">
                    <template x-for="item in cart" :key="item.id">
                        <div class="flex justify-between items-center">
                            <div>
                                <span class="font-bold text-lg text-gray-700" x-text="item.name"></span>
                                <div class="flex items-center space-x-3 mt-1">
                                    <button @click="updateQuantity(item.id, -1)" class="text-red-600 font-bold text-lg p-1 rounded-full hover:bg-red-100 w-6 h-6 flex items-center justify-center transition-all duration-200">
                                        &minus;
                                    </button>
                                    <span x-text="item.quantity" class="font-bold text-lg"></span>
                                    <button @click="updateQuantity(item.id, 1)" class="text-green-600 font-bold text-lg p-1 rounded-full hover:bg-green-100 w-6 h-6 flex items-center justify-center transition-all duration-200">
                                        &plus;
                                    </button>
                                </div>
                            </div>
                            <span class="font-bold text-gray-800 text-lg" x-text="formatCurrency(item.price * item.quantity)"></span>
                        </div>
                    </template>
                </div>
                <hr class="my-5">
                <div class="space-y-2 mb-5">
                    <div class="flex justify-between items-center text-gray-600">
                        <span>Subtotal</span>
                        <span class="font-medium" x-text="formatCurrency(subTotal)"></span>
                    </div>
                    <div class="flex justify-between items-center text-gray-600">
                        <span>Biaya Layanan</span>
                        <span class="font-medium" x-text="formatCurrency(biayaLayanan)"></span>
                    </div>
                </div>
                <div class="flex justify-between items-center text-2xl font-bold mb-6">
                    <span class="text-gray-700">Total</span>
                    <span class="text-brand-dark" x-text="formatCurrency(totalHarga)"></span>
                </div>
                <h3 class="text-lg font-semibold mb-3 text-brand-dark">Pilih Pembayaran</h3>
                <div class="grid grid-cols-2 gap-4 mb-5">
                    <label class="flex items-center p-4 border rounded-lg cursor-pointer ring-2 ring-transparent has-[:checked]:ring-brand-gold has-[:checked]:bg-amber-50 transition-all duration-200">
                        <input type="radio" name="payment" class="h-5 w-5 text-amber-600 border-gray-300 focus:ring-amber-500">
                        <span class="ml-3 font-medium text-gray-700">QRIS</span>
                    </label>
                    <label class="flex items-center p-4 border rounded-lg cursor-pointer ring-2 ring-transparent has-[:checked]:ring-brand-gold has-[:checked]:bg-amber-50 transition-all duration-200">
                        <input type="radio" name="payment" class="h-5 w-5 text-amber-600 border-gray-300 focus:ring-amber-500">
                        <span class="ml-3 font-medium text-gray-700">E-Wallet</span>
                    </label>
                </div>
                <div class="mb-6">
                    <label for="nomor_meja" class="text-lg font-semibold block mb-2 text-brand-dark">Nomor Meja</label>
                    <input type="text" id="nomor_meja" class="w-full p-4 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-brand-gold text-lg transition-all duration-200">
                </div>
                <button @click="submitCheckout()" class="w-full btn-brand font-bold py-4 rounded-lg text-lg transform transition-all duration-300 hover:scale-105">
                    Konfirmasi Pesanan
                </button>
                <button @click="cart = []" class="w-full text-center text-red-600 mt-4 text-sm hover:underline">
                    Kosongkan Pilihan
                </button>
            </div>
        </div>
    </div>

    <div x-show="isSuccess" x-transition class="fixed inset-0 bg-black bg-opacity-60 flex items-center justify-center p-4 z-50" style="display: none;">
        <div class="bg-white rounded-xl shadow-xl w-full max-w-sm p-10 text-center" @click.outside="isSuccess = false">
            <div class="text-green-500 mb-6">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-20 w-20 mx-auto" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" /></svg>
            </div>
            <h2 class="font-display text-3xl font-bold text-brand-dark mb-4">Pembayaran Berhasil</h2>
            <p class="text-gray-600 mb-6">Pesanan Anda sedang diproses. Terima kasih!</p>
            <button @click="isSuccess = false" class="w-full btn-brand font-bold py-3 rounded-lg transform transition-all duration-300 hover:scale-105">
                Tutup
            </button>
        </div>
    </div>

    <div x-show="isLoginModalOpen"
         x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
         class="fixed inset-0 bg-black bg-opacity-60 flex items-center justify-center p-4 z-50"
         @keydown.escape.window="isLoginModalOpen = false"
         style="display: none;">

        <div class="bg-white rounded-xl shadow-xl w-full max-w-md p-8 text-center" @click.outside="isLoginModalOpen = false">
            <div class="text-amber-500 mb-6">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-20 w-20 mx-auto" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.876c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" /></svg>
            </div>
            <h2 class="font-display text-3xl font-bold text-brand-dark mb-4">Anda Harus Login</h2>
            <p class="text-gray-600 mb-8">Silakan login atau daftar terlebih dahulu untuk melanjutkan pemesanan.</p>
            <a href="{{ url('/login') }}" class="w-full block text-center btn-brand font-bold py-3 rounded-lg transform transition-all duration-300 hover:scale-105 mb-3">
                Login Sekarang
            </a>
            <a href="{{ url('/register') }}" class="w-full block text-center btn-outline-brand font-bold py-3 rounded-lg transform transition-all duration-300 hover:scale-105">
                Daftar Akun
            </a>
            <button @click="isLoginModalOpen = false" class="w-full text-center text-gray-500 mt-6 text-sm hover:underline">
                Tutup
            </button>
        </div>
    </div>

</body>
</html>
