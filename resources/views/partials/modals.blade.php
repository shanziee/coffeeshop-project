<div x-show="isDetailModalOpen" class="fixed inset-0 bg-black/60 backdrop-blur-sm flex items-center justify-center z-50 p-4" style="display: none;" x-transition>
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

<div x-show="isModalOpen" class="fixed inset-0 bg-black/60 backdrop-blur-sm flex items-end md:items-center justify-center z-50" style="display: none;" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-10" x-transition:enter-end="opacity-100 translate-y-0" x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100 translate-y-0" x-transition:leave-end="opacity-0 translate-y-10">
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
