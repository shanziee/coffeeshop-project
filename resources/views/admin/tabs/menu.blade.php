<div class="space-y-8" x-data="{
    editModalOpen: false,
    editUrl: '',
    editData: { name: '', category: '', price: '', description: '' }
}">

    {{-- Notifikasi Sukses --}}
    @if(session('success'))
    <div x-data="{ show: true }" x-show="show" class="bg-green-100 border border-green-200 text-green-700 px-4 py-3 rounded-xl flex justify-between items-center mb-4">
        <span>{{ session('success') }}</span>
        <button @click="show = false" class="text-green-500 font-bold">&times;</button>
    </div>
    @endif

    {{-- Header Utama & Tombol Tambah --}}
    <div class="flex justify-between items-center">
        <div>
            <h2 class="text-2xl font-bold text-gray-800">Kelola Menu</h2>
            <p class="text-sm text-gray-500 mt-1">Atur daftar menu makanan dan minuman cafe Anda.</p>
        </div>
        <button onclick="document.getElementById('addMenuModal').classList.remove('hidden')"
            class="bg-[#2a231f] hover:bg-gray-800 text-white px-5 py-2.5 rounded-xl font-bold text-sm shadow-lg transition-all transform hover:scale-105 flex items-center gap-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
            Tambah Menu Baru
        </button>
    </div>

    {{-- SECTION 1: KATEGORI MINUMAN --}}
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
            <thead class="bg-gray-50 text-gray-600 font-medium border-b text-xs uppercase">
                <tr>
                    <th class="px-6 py-4 w-24">Foto</th>
                    <th class="px-6 py-4">Nama Menu</th>
                    <th class="px-6 py-4">Harga</th>
                    <th class="px-6 py-4 text-center w-32">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100 text-sm">
                @forelse($products->where('category', 'minuman') as $item)
                <tr class="hover:bg-blue-50/30 transition group">
                    <td class="px-6 py-3">
                        <img src="{{ asset($item->image) }}" class="h-12 w-12 rounded-xl object-cover shadow-sm group-hover:scale-110 transition-transform duration-300">
                    </td>
                    <td class="px-6 py-3">
                        <div class="font-bold text-gray-800">{{ $item->name }}</div>
                        <div class="text-xs text-gray-400 mt-0.5 line-clamp-1">{{ $item->description }}</div>
                    </td>
                    <td class="px-6 py-3 font-medium text-gray-600">
                        Rp {{ number_format($item->price, 0, ',', '.') }}
                    </td>
                    <td class="px-6 py-3 text-center">
                        <div class="flex items-center justify-center gap-2 opacity-0 group-hover:opacity-100 transition-opacity">
                            <!-- Tombol Edit -->
                            {{-- PERBAIKAN: Menggunakan route 'admin.menu.update' --}}
                            <button @click="
                                editModalOpen = true;
                                editUrl = '{{ route('admin.menu.update', $item->id) }}';
                                editData = {
                                    name: '{{ addslashes($item->name) }}',
                                    category: '{{ $item->category }}',
                                    price: '{{ $item->price }}',
                                    description: '{{ addslashes($item->description) }}'
                                }"
                                class="p-2 text-blue-600 hover:bg-blue-100 rounded-lg transition" title="Edit">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                            </button>

                            <!-- Tombol Hapus -->
                            {{-- PERBAIKAN: Menggunakan route 'admin.menu.destroy' --}}
                            <form action="{{ route('admin.menu.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus menu ini?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="p-2 text-red-600 hover:bg-red-100 rounded-lg transition" title="Hapus">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="px-6 py-8 text-center text-gray-400 italic bg-gray-50">
                        Belum ada menu minuman.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- SECTION 2: KATEGORI MAKANAN --}}
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
            <thead class="bg-gray-50 text-gray-600 font-medium border-b text-xs uppercase">
                <tr>
                    <th class="px-6 py-4 w-24">Foto</th>
                    <th class="px-6 py-4">Nama Menu</th>
                    <th class="px-6 py-4">Harga</th>
                    <th class="px-6 py-4 text-center w-32">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100 text-sm">
                @forelse($products->where('category', 'makanan') as $item)
                <tr class="hover:bg-orange-50/30 transition group">
                    <td class="px-6 py-3">
                        <img src="{{ asset($item->image) }}" class="h-12 w-12 rounded-xl object-cover shadow-sm group-hover:scale-110 transition-transform duration-300">
                    </td>
                    <td class="px-6 py-3">
                        <div class="font-bold text-gray-800">{{ $item->name }}</div>
                        <div class="text-xs text-gray-400 mt-0.5 line-clamp-1">{{ $item->description }}</div>
                    </td>
                    <td class="px-6 py-3 font-medium text-gray-600">
                        Rp {{ number_format($item->price, 0, ',', '.') }}
                    </td>
                    <td class="px-6 py-3 text-center">
                        <div class="flex items-center justify-center gap-2 opacity-0 group-hover:opacity-100 transition-opacity">
                            <!-- Tombol Edit -->
                            {{-- PERBAIKAN: Menggunakan route 'admin.menu.update' --}}
                            <button @click="
                                editModalOpen = true;
                                editUrl = '{{ route('admin.menu.update', $item->id) }}';
                                editData = {
                                    name: '{{ addslashes($item->name) }}',
                                    category: '{{ $item->category }}',
                                    price: '{{ $item->price }}',
                                    description: '{{ addslashes($item->description) }}'
                                }"
                                class="p-2 text-blue-600 hover:bg-blue-100 rounded-lg transition" title="Edit">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                            </button>

                            <!-- Tombol Hapus -->
                            {{-- PERBAIKAN: Menggunakan route 'admin.menu.destroy' --}}
                            <form action="{{ route('admin.menu.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus menu ini?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="p-2 text-red-600 hover:bg-red-100 rounded-lg transition" title="Hapus">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="px-6 py-8 text-center text-gray-400 italic bg-gray-50">
                        Belum ada menu makanan.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- MODAL TAMBAH MENU --}}
    <div id="addMenuModal" class="fixed inset-0 bg-black/60 backdrop-blur-sm hidden z-50 flex items-center justify-center p-4">
        <div class="bg-white rounded-2xl shadow-2xl w-full max-w-md overflow-hidden">
            <div class="p-6 border-b border-gray-100 flex justify-between items-center">
                <h3 class="text-lg font-bold text-gray-800">Tambah Menu Baru</h3>
                <button onclick="document.getElementById('addMenuModal').classList.add('hidden')" class="text-gray-400 hover:text-gray-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>
            {{-- PERBAIKAN: Menggunakan route 'admin.menu.store' --}}
            <form action="{{ route('admin.menu.store') }}" method="POST" enctype="multipart/form-data" class="p-6 space-y-4">
                @csrf
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-1">Nama Menu</label>
                    <input type="text" name="name" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-transparent">
                </div>
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-1">Kategori</label>
                    <select name="category" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-transparent">
                        <option value="minuman">Minuman</option>
                        <option value="makanan">Makanan</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-1">Harga (Rp)</label>
                    <input type="number" name="price" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-transparent">
                </div>
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-1">Gambar</label>
                    <input type="file" name="image" required class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-amber-50 file:text-amber-700 hover:file:bg-amber-100">
                </div>
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-1">Deskripsi</label>
                    <textarea name="description" rows="2" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-transparent"></textarea>
                </div>
                <div class="pt-4">
                    <button type="submit" class="w-full bg-[#2a231f] text-white font-bold py-3 rounded-xl hover:bg-gray-800 transition shadow-lg">Simpan Menu</button>
                </div>
            </form>
        </div>
    </div>

    {{-- MODAL EDIT MENU (Alpine.js) --}}
    <div x-show="editModalOpen" class="fixed inset-0 bg-black/60 backdrop-blur-sm z-50 flex items-center justify-center p-4" x-cloak>
        <div class="bg-white rounded-2xl shadow-2xl w-full max-w-md overflow-hidden" @click.outside="editModalOpen = false">
            <div class="p-6 border-b border-gray-100 flex justify-between items-center">
                <h3 class="text-lg font-bold text-gray-800">Edit Menu</h3>
                <button @click="editModalOpen = false" class="text-gray-400 hover:text-gray-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>
            <form :action="editUrl" method="POST" enctype="multipart/form-data" class="p-6 space-y-4">
                @csrf
                @method('PUT')
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-1">Nama Menu</label>
                    <input type="text" name="name" x-model="editData.name" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-transparent">
                </div>
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-1">Kategori</label>
                    <select name="category" x-model="editData.category" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-transparent">
                        <option value="minuman">Minuman</option>
                        <option value="makanan">Makanan</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-1">Harga (Rp)</label>
                    <input type="number" name="price" x-model="editData.price" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-transparent">
                </div>
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-1">Ganti Gambar (Opsional)</label>
                    <input type="file" name="image" class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-amber-50 file:text-amber-700 hover:file:bg-amber-100">
                </div>
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-1">Deskripsi</label>
                    <textarea name="description" x-model="editData.description" rows="2" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-transparent"></textarea>
                </div>
                <div class="pt-4">
                    <button type="submit" class="w-full bg-blue-600 text-white font-bold py-3 rounded-xl hover:bg-blue-700 transition shadow-lg">Update Menu</button>
                </div>
            </form>
        </div>
    </div>

</div>
