<main id="menu-section" class="container mx-auto p-6 md:p-12 min-h-screen relative z-20 -mt-10">

    <div class="text-center mb-8">
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

                    <button type="button" @click="openDetail(menu)" class="w-full bg-brand-dark text-white py-3 rounded-xl font-semibold hover:bg-gray-800 transition flex justify-center items-center gap-2 group-hover:shadow-lg">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" /></svg>
                        <span>Pilih</span>
                    </button>
                </div>
            </div>
        </template>
    </div>
</main>
