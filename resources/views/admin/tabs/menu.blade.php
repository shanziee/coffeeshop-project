<div class="space-y-8" x-data="{
    editModalOpen: false,
    editUrl: '',
    editData: { name: '', category: '', price: '', stock: '', description: '' }
}">

    {{-- CSS Internal untuk Gambar --}}
    <style>
        .menu-img-custom {
            width: 48px;
            height: 48px;
            object-fit: cover;
            border-radius: 0.75rem;
        }
    </style>

    {{-- Notifikasi Sukses --}}
    @if(session('success'))
    <div x-data="{ show: true }" x-show="show" class="bg-green-100 border border-green-200 text-green-700 px-4 py-3 rounded-xl flex justify-between items-center mb-4">
        <span>{{ session('success') }}</span>
        <button @click="show = false" class="text-green-500 font-bold">&times;</button>
    </div>
    @endif

    {{-- Notifikasi Error Validasi (PENTING AGAR TAHU JIKA GAGAL) --}}
    @if ($errors->any())
    <div class="bg-red-100 border border-red-200 text-red-700 px-4 py-3 rounded-xl mb-4">
        <strong class="font-bold">Gagal Menyimpan!</strong>
        <ul class="list-disc list-inside mt-1">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    {{-- Header Utama --}}
    <div class="flex justify-between items-center">
        <div>
            <h2 class="text-2xl font-bold text-gray-800">Kelola Menu</h2>
            <p class="text-sm text-gray-500 mt-1">Atur daftar menu makanan, minuman, snack, dan stok persediaan.</p>
        </div>
        <button onclick="document.getElementById('addMenuModal').classList.remove('hidden')"
            class="bg-[#2a231f] hover:bg-gray-800 text-white px-5 py-2.5 rounded-xl font-bold text-sm shadow-lg transition-all transform hover:scale-105 flex items-center gap-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
            Tambah Menu Baru
        </button>
    </div>

    {{-- 1. KATEGORI MINUMAN --}}
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-100 bg-blue-50/50 flex items-center gap-3">
            <div class="bg-blue-100 p-2 rounded-lg"><span class="text-xl">☕</span></div>
            <h3 class="text-lg font-bold text-gray-800">Kategori Minuman</h3>
            <span class="text-xs font-medium px-2.5 py-0.5 rounded-full bg-blue-100 text-blue-700">
                {{ $products->where('category', 'minuman')->count() }} Item
            </span>
        </div>
        <table class="w-full text-left border-collapse">
            <thead class="bg-gray-50 text-gray-600 font-medium border-b text-xs uppercase">
                <tr>
                    <th class="px-6 py-4 w-24">No</th>
                    <th class="px-6 py-4 w-24">Foto</th>
                    <th class="px-6 py-4">Nama Menu</th>
                    <th class="px-6 py-4">Harga</th>
                    <th class="px-6 py-4 text-center">Stok</th>
                    <th class="px-6 py-4 text-center w-32">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100 text-sm">
                @forelse($products->where('category', 'minuman') as $index => $item)
                <tr class="hover:bg-blue-50/30 transition group">
                    <td class="px-6 py-3 font-mono text-gray-400">{{ $loop->iteration }}</td>
                    <td class="px-6 py-3"><img src="{{ asset($item->image) }}" class="menu-img-custom"></td>
                    <td class="px-6 py-3">
                        <div class="font-bold text-gray-800">{{ $item->name }}</div>
                        <div class="text-xs text-gray-400">{{ $item->description }}</div>
                    </td>
                    <td class="px-6 py-3 font-medium text-gray-600">Rp {{ number_format($item->price, 0, ',', '.') }}</td>
                    <td class="px-6 py-3 text-center">
                        <span class="px-2 py-1 rounded-full text-xs font-bold {{ $item->stock > 0 ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                            {{ $item->stock > 0 ? $item->stock : 'Habis' }}
                        </span>
                    </td>
                    <td class="px-6 py-3 text-center">
                        <div class="flex justify-center gap-2 opacity-0 group-hover:opacity-100 transition">
                            <button @click="editModalOpen = true; editUrl = '{{ route('admin.menu.update', $item->id) }}'; editData = { name: {{ json_encode($item->name) }}, category: '{{ $item->category }}', price: '{{ $item->price }}', stock: '{{ $item->stock }}', description: {{ json_encode($item->description) }} }" class="p-2 text-blue-600 hover:bg-blue-100 rounded-lg"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg></button>
                            <form action="{{ route('admin.menu.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Hapus?');">@csrf @method('DELETE') <button type="submit" class="p-2 text-red-600 hover:bg-red-100 rounded-lg"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg></button></form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr><td colspan="6" class="px-6 py-8 text-center text-gray-400 italic">Belum ada menu minuman.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- 2. KATEGORI MAKANAN --}}
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-100 bg-orange-50/50 flex items-center gap-3">
            <div class="bg-orange-100 p-2 rounded-lg"><span class="text-xl">🍔</span></div>
            <h3 class="text-lg font-bold text-gray-800">Kategori Makanan</h3>
            <span class="text-xs font-medium px-2.5 py-0.5 rounded-full bg-orange-100 text-orange-700">
                {{ $products->where('category', 'makanan')->count() }} Item
            </span>
        </div>
        <table class="w-full text-left border-collapse">
            <thead class="bg-gray-50 text-gray-600 font-medium border-b text-xs uppercase">
                <tr>
                    <th class="px-6 py-4 w-24">No</th>
                    <th class="px-6 py-4 w-24">Foto</th>
                    <th class="px-6 py-4">Nama Menu</th>
                    <th class="px-6 py-4">Harga</th>
                    <th class="px-6 py-4 text-center">Stok</th>
                    <th class="px-6 py-4 text-center w-32">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100 text-sm">
                @forelse($products->where('category', 'makanan') as $index => $item)
                <tr class="hover:bg-orange-50/30 transition group">
                    <td class="px-6 py-3 font-mono text-gray-400">{{ $loop->iteration }}</td>
                    <td class="px-6 py-3"><img src="{{ asset($item->image) }}" class="menu-img-custom"></td>
                    <td class="px-6 py-3">
                        <div class="font-bold text-gray-800">{{ $item->name }}</div>
                        <div class="text-xs text-gray-400">{{ $item->description }}</div>
                    </td>
                    <td class="px-6 py-3 font-medium text-gray-600">Rp {{ number_format($item->price, 0, ',', '.') }}</td>
                    <td class="px-6 py-3 text-center">
                        <span class="px-2 py-1 rounded-full text-xs font-bold {{ $item->stock > 0 ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                            {{ $item->stock > 0 ? $item->stock : 'Habis' }}
                        </span>
                    </td>
                    <td class="px-6 py-3 text-center">
                        <div class="flex justify-center gap-2 opacity-0 group-hover:opacity-100 transition">
                            <button @click="editModalOpen = true; editUrl = '{{ route('admin.menu.update', $item->id) }}'; editData = { name: {{ json_encode($item->name) }}, category: '{{ $item->category }}', price: '{{ $item->price }}', stock: '{{ $item->stock }}', description: {{ json_encode($item->description) }} }" class="p-2 text-blue-600 hover:bg-blue-100 rounded-lg"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg></button>
                            <form action="{{ route('admin.menu.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Hapus?');">@csrf @method('DELETE') <button type="submit" class="p-2 text-red-600 hover:bg-red-100 rounded-lg"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg></button></form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr><td colspan="6" class="px-6 py-8 text-center text-gray-400 italic">Belum ada menu makanan.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- 3. KATEGORI SNACK --}}
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-100 bg-yellow-50/50 flex items-center gap-3">
            <div class="bg-yellow-100 p-2 rounded-lg"><span class="text-xl">🥨</span></div>
            <h3 class="text-lg font-bold text-gray-800">Kategori Snack</h3>
            <span class="text-xs font-medium px-2.5 py-0.5 rounded-full bg-yellow-100 text-yellow-700">
                {{ $products->where('category', 'snack')->count() }} Item
            </span>
        </div>
        <table class="w-full text-left border-collapse">
            <thead class="bg-gray-50 text-gray-600 font-medium border-b text-xs uppercase">
                <tr>
                    <th class="px-6 py-4 w-24">No</th>
                    <th class="px-6 py-4 w-24">Foto</th>
                    <th class="px-6 py-4">Nama Menu</th>
                    <th class="px-6 py-4">Harga</th>
                    <th class="px-6 py-4 text-center">Stok</th>
                    <th class="px-6 py-4 text-center w-32">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100 text-sm">
                @forelse($products->where('category', 'snack') as $index => $item)
                <tr class="hover:bg-yellow-50/30 transition group">
                    <td class="px-6 py-3 font-mono text-gray-400">{{ $loop->iteration }}</td>
                    <td class="px-6 py-3"><img src="{{ asset($item->image) }}" class="menu-img-custom"></td>
                    <td class="px-6 py-3">
                        <div class="font-bold text-gray-800">{{ $item->name }}</div>
                        <div class="text-xs text-gray-400">{{ $item->description }}</div>
                    </td>
                    <td class="px-6 py-3 font-medium text-gray-600">Rp {{ number_format($item->price, 0, ',', '.') }}</td>
                    <td class="px-6 py-3 text-center">
                        <span class="px-2 py-1 rounded-full text-xs font-bold {{ $item->stock > 0 ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                            {{ $item->stock > 0 ? $item->stock : 'Habis' }}
                        </span>
                    </td>
                    <td class="px-6 py-3 text-center">
                        <div class="flex justify-center gap-2 opacity-0 group-hover:opacity-100 transition">
                            <button @click="editModalOpen = true; editUrl = '{{ route('admin.menu.update', $item->id) }}'; editData = { name: {{ json_encode($item->name) }}, category: '{{ $item->category }}', price: '{{ $item->price }}', stock: '{{ $item->stock }}', description: {{ json_encode($item->description) }} }" class="p-2 text-blue-600 hover:bg-blue-100 rounded-lg"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg></button>
                            <form action="{{ route('admin.menu.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Hapus?');">@csrf @method('DELETE') <button type="submit" class="p-2 text-red-600 hover:bg-red-100 rounded-lg"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg></button></form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr><td colspan="6" class="px-6 py-8 text-center text-gray-400 italic">Belum ada menu snack.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- MODAL TAMBAH MENU --}}
    <div id="addMenuModal" class="fixed inset-0 bg-black/60 backdrop-blur-sm hidden z-50 flex items-center justify-center p-4">
        <div class="bg-white rounded-2xl shadow-2xl w-full max-w-md">
            <div class="p-6 border-b border-gray-100 flex justify-between">
                <h3 class="font-bold">Tambah Menu Baru</h3>
                <button onclick="document.getElementById('addMenuModal').classList.add('hidden')">&times;</button>
            </div>
            <form action="{{ route('admin.menu.store') }}" method="POST" enctype="multipart/form-data" class="p-6 space-y-4">
                @csrf
                <input type="text" name="name" placeholder="Nama Menu" required class="w-full border p-2 rounded">
                <div class="grid grid-cols-2 gap-4">
                    <select name="category" required class="w-full border p-2 rounded">
                        <option value="minuman">Minuman</option>
                        <option value="makanan">Makanan</option>
                        <option value="snack">Snack</option>
                    </select>
                    <input type="number" name="price" placeholder="Harga" required class="w-full border p-2 rounded">
                </div>
                <input type="number" name="stock" placeholder="Stok" required class="w-full border p-2 rounded">
                <input type="file" name="image" required class="w-full border p-2 rounded">
                <textarea name="description" placeholder="Deskripsi" class="w-full border p-2 rounded"></textarea>
                <button type="submit" class="w-full bg-[#2a231f] text-white py-2 rounded">Simpan</button>
            </form>
        </div>
    </div>

    {{-- MODAL EDIT MENU --}}
    <div x-show="editModalOpen" class="fixed inset-0 bg-black/60 z-50 flex items-center justify-center p-4" x-cloak>
        <div class="bg-white rounded-2xl w-full max-w-md">
            <div class="p-6 border-b flex justify-between">
                <h3 class="font-bold">Edit Menu</h3>
                <button @click="editModalOpen = false">&times;</button>
            </div>
            <form :action="editUrl" method="POST" enctype="multipart/form-data" class="p-6 space-y-4">
                @csrf @method('PUT')
                <input type="text" name="name" x-model="editData.name" required class="w-full border p-2 rounded">
                <div class="grid grid-cols-2 gap-4">
                    <select name="category" x-model="editData.category" required class="w-full border p-2 rounded">
                        <option value="minuman">Minuman</option>
                        <option value="makanan">Makanan</option>
                        <option value="snack">Snack</option>
                    </select>
                    <input type="number" name="price" x-model="editData.price" required class="w-full border p-2 rounded">
                </div>
                <input type="number" name="stock" x-model="editData.stock" required class="w-full border p-2 rounded">
                <input type="file" name="image" class="w-full border p-2 rounded">
                <textarea name="description" x-model="editData.description" class="w-full border p-2 rounded"></textarea>
                <button type="submit" class="w-full bg-blue-600 text-white py-2 rounded">Update</button>
            </form>
        </div>
    </div>
</div>
