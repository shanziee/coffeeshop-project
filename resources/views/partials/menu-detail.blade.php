<div x-show="isDetailModalOpen"
     x-transition:enter="transition ease-out duration-300"
     x-transition:enter-start="opacity-0 transform scale-95"
     x-transition:enter-end="opacity-100 transform scale-100"
     x-transition:leave="transition ease-in duration-200"
     x-transition:leave-start="opacity-100 transform scale-100"
     x-transition:leave-end="opacity-0 transform scale-95"
     class="fixed inset-0 bg-black bg-opacity-60 flex items-center justify-center p-4 z-50"
     style="display: none;">

    <div class="bg-white rounded-2xl shadow-2xl w-full max-w-3xl overflow-hidden flex flex-col md:flex-row relative" @click.outside="isDetailModalOpen = false">

        <button @click="isDetailModalOpen = false" class="absolute top-4 right-4 text-gray-500 hover:text-gray-800 z-10 bg-white rounded-full p-1 shadow-sm">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>

        <div class="w-full md:w-1/2 h-64 md:h-auto bg-gray-100 relative">
             <template x-if="selectedMenu">
                <img :src="selectedMenu.image" :alt="selectedMenu.name" class="w-full h-full object-cover">
             </template>
        </div>

        <div class="w-full md:w-1/2 p-8 flex flex-col justify-between">
            <template x-if="selectedMenu">
                <div>
                    <h2 x-text="selectedMenu.name" class="font-display text-3xl font-bold text-brand-dark mb-2"></h2>
                    <p x-text="formatCurrency(selectedMenu.price)" class="text-2xl text-brand-gold font-semibold mb-4"></p>
                    <p x-text="selectedMenu.description" class="text-gray-600 leading-relaxed mb-6"></p>

                    <div class="mb-6">
                        <h4 class="text-sm font-bold text-gray-700 uppercase tracking-wider mb-2">Catatan Tambahan</h4>
                        <textarea class="w-full border border-gray-300 rounded-lg p-3 text-sm focus:ring-2 focus:ring-brand-gold outline-none" rows="2" placeholder="Contoh: Kurangi gula, banyakin es..."></textarea>
                    </div>
                </div>
            </template>

            <div>
                <div class="flex items-center justify-between mb-6 bg-gray-50 p-4 rounded-xl">
                    <span class="text-gray-700 font-medium">Jumlah</span>
                    <div class="flex items-center space-x-4">
                        <button @click="if(detailQuantity > 1) detailQuantity--" class="w-8 h-8 rounded-full bg-white shadow text-brand-dark hover:bg-gray-100 font-bold flex items-center justify-center transition">-</button>
                        <span x-text="detailQuantity" class="text-xl font-bold text-brand-dark w-6 text-center"></span>
                        <button @click="detailQuantity++" class="w-8 h-8 rounded-full bg-white shadow text-brand-dark hover:bg-gray-100 font-bold flex items-center justify-center transition">+</button>
                    </div>
                </div>

                <button @click="processAddToOrder()" class="w-full btn-brand font-bold py-4 rounded-xl text-lg shadow-lg transform transition hover:-translate-y-1 flex justify-center items-center space-x-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>
                    <span>Tambah ke Pesanan - </span>
                    <template x-if="selectedMenu">
                        <span x-text="formatCurrency(selectedMenu.price * detailQuantity)"></span>
                    </template>
                </button>
            </div>
        </div>
    </div>
</div>
