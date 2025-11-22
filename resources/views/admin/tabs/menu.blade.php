<div class="space-y-8">
    {{-- Header Utama & Tombol Tambah --}}
    <div class="flex justify-between items-center">
        <div>
            <h2 class="text-2xl font-bold text-gray-800">Kelola Menu</h2>
            <p class="text-sm text-gray-500 mt-1">Atur daftar menu makanan dan minuman cafe Anda.</p>
        </div>
        <button onclick="document.getElementById('modalTambah').classList.remove('hidden')"
            class="bg-[#2a231f] hover:bg-gray-800 text-white px-5 py-2.5 rounded-xl font-bold text-sm shadow-lg transition-all transform hover:scale-105 flex items-center gap-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
            Tambah Menu Baru
        </button>
    </div>

    {{-- SECTION 1: KATEGORI MINUMAN (TOP) --}}
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-100 bg-blue-50/50 flex items-center gap-3">
            <div class="bg-blue-100 p-2 rounded-lg">
                <span class="text-xl">☕</span>
            </div>
            <h3 class="text-lg font-bold text-gray-800">Kategori Minuman</h3>
            <span class="text-xs font-medium px-2.5 py-0.5 rounded-full bg-blue-100 text-blue-700">
                {{ $products->where('category', 'minuman')->count() }} Item
            </span>
        </div>

        <table class="w-full text-left border-collapse">
            <thead class="bg-gray-50 text-gray-500 uppercase text-xs font-bold">
                <tr>
                    <th class="px-6 py-4 w-24">Foto</th>
                    <th class="px-6 py-4">Nama Menu</th>
                    <th class="px-6 py-4">Harga</th>
                    <th class="px-6 py-4 text-center w-32">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($products->where('category', 'minuman') as $item)
                <tr class="hover:bg-blue-50/30 transition group">
                    <td class="px-6 py-3">
                        <img src="{{ asset($item->image) }}" class="h-12 w-12 rounded-xl object-cover shadow-sm group-hover:scale-110 transition-transform duration-300">
                    </td>
                    <td class="px-6 py-3">
                        <div class="font-bold text-gray-800">{{ $item->name }}</div>
                        <div class="text-xs text-gray-400 mt-0.5">Stok Tersedia</div>
                    </td>
                    <td class="px-6 py-3 font-medium text-gray-600">
                        Rp {{ number_format($item->price, 0, ',', '.') }}
                    </td>
                    <td class="px-6 py-3 text-center">
                        <div class="flex items-center justify-center gap-2 opacity-0 group-hover:opacity-100 transition-opacity">
                            <button class="p-2 text-blue-600 hover:bg-blue-100 rounded-lg transition" title="Edit">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                            </button>
                            <button class="p-2 text-red-600 hover:bg-red-100 rounded-lg transition" title="Hapus">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                            </button>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="px-6 py-8 text-center text-gray-400 italic bg-gray-50">
                        Belum ada menu minuman yang ditambahkan.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- SECTION 2: KATEGORI MAKANAN (BOTTOM) --}}
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-100 bg-orange-50/50 flex items-center gap-3">
            <div class="bg-orange-100 p-2 rounded-lg">
                <span class="text-xl">🍔</span>
            </div>
            <h3 class="text-lg font-bold text-gray-800">Kategori Makanan</h3>
            <span class="text-xs font-medium px-2.5 py-0.5 rounded-full bg-orange-100 text-orange-700">
                {{ $products->where('category', 'makanan')->count() }} Item
            </span>
        </div>

        <table class="w-full text-left border-collapse">
            <thead class="bg-gray-50 text-gray-500 uppercase text-xs font-bold">
                <tr>
                    <th class="px-6 py-4 w-24">Foto</th>
                    <th class="px-6 py-4">Nama Menu</th>
                    <th class="px-6 py-4">Harga</th>
                    <th class="px-6 py-4 text-center w-32">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($products->where('category', 'makanan') as $item)
                <tr class="hover:bg-orange-50/30 transition group">
                    <td class="px-6 py-3">
                        <img src="{{ asset($item->image) }}" class="h-12 w-12 rounded-xl object-cover shadow-sm group-hover:scale-110 transition-transform duration-300">
                    </td>
                    <td class="px-6 py-3">
                        <div class="font-bold text-gray-800">{{ $item->name }}</div>
                        <div class="text-xs text-gray-400 mt-0.5">Stok Tersedia</div>
                    </td>
                    <td class="px-6 py-3 font-medium text-gray-600">
                        Rp {{ number_format($item->price, 0, ',', '.') }}
                    </td>
                    <td class="px-6 py-3 text-center">
                        <div class="flex items-center justify-center gap-2 opacity-0 group-hover:opacity-100 transition-opacity">
                            <button class="p-2 text-blue-600 hover:bg-blue-100 rounded-lg transition" title="Edit">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                            </button>
                            <button class="p-2 text-red-600 hover:bg-red-100 rounded-lg transition" title="Hapus">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                            </button>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="px-6 py-8 text-center text-gray-400 italic bg-gray-50">
                        Belum ada menu makanan yang ditambahkan.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
