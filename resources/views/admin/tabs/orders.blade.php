<div>
    <h2 class="text-2xl font-bold text-gray-800 mb-6">Kelola & Riwayat Pesanan</h2>

    {{-- Pesan Sukses (Jika ada update) --}}
    @if(session('success'))
    <div x-data="{ show: true }" x-show="show" class="mb-4 bg-green-100 border border-green-200 text-green-700 px-4 py-3 rounded-xl flex justify-between items-center">
        <span>{{ session('success') }}</span>
        <button @click="show = false" class="text-green-500 font-bold">&times;</button>
    </div>
    @endif

    <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead class="bg-gray-50 text-gray-500 uppercase text-xs font-bold">
                    <tr>
                        <th class="px-6 py-4">ID</th>
                        <th class="px-6 py-4">Pelanggan</th>
                        <th class="px-6 py-4">Waktu</th>
                        <th class="px-6 py-4">Status</th>
                        <th class="px-6 py-4">Total</th>
                        <th class="px-6 py-4 text-center">Aksi</th> </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($orders as $order)
                    <tr class="hover:bg-gray-50 transition" x-data="{ expanded: false }">
                        <td class="px-6 py-4 font-mono text-xs text-gray-500">#{{ $order->id }}</td>
                        <td class="px-6 py-4 font-bold text-gray-800">{{ $order->user->name ?? 'Guest' }}</td>
                        <td class="px-6 py-4 text-sm text-gray-500">{{ $order->created_at->format('d/m/y H:i') }}</td>

                        <td class="px-6 py-4">
                            <span class="px-3 py-1 text-[10px] uppercase font-bold rounded-full
                                {{ $order->status == 'paid' ? 'bg-green-100 text-green-700' :
                                   ($order->status == 'pending' ? 'bg-yellow-100 text-yellow-700' : 'bg-red-100 text-red-700') }}">
                                {{ $order->status }}
                            </span>
                        </td>

                        <td class="px-6 py-4 font-bold text-gray-800">Rp {{ number_format($order->total_price, 0, ',', '.') }}</td>

                        <td class="px-6 py-4 text-center">
                            <div class="flex items-center justify-center gap-2">

                                {{-- Tombol DETAIL (Expand) --}}
                                <button @click="expanded = !expanded" class="p-2 text-gray-500 hover:bg-gray-100 rounded-lg transition" title="Lihat Detail Item">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                </button>

                                {{-- Tombol PRINT STRUK --}}
                                <a href="{{ route('admin.orders.print', $order->id) }}" target="_blank" class="p-2 text-blue-600 hover:bg-blue-50 rounded-lg transition" title="Cetak Struk">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
                                </a>

                                {{-- Tombol MARK AS PAID (Hanya jika status belum paid) --}}
                                @if($order->status != 'paid')
                                    <form action="{{ route('admin.orders.markPaid', $order->id) }}" method="POST" onsubmit="return confirm('Tandai pesanan ini sebagai LUNAS/PAID?');">
                                        @csrf
                                        <button type="submit" class="p-2 text-green-600 hover:bg-green-50 rounded-lg transition" title="Tandai Sudah Bayar">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                        </button>
                                    </form>
                                @endif

                            </div>
                        </td>

                        <template x-if="expanded">
                            <tr class="bg-gray-50 border-b border-gray-100">
                                <td colspan="6" class="px-6 py-4">
                                    <div class="flex flex-col sm:flex-row gap-6">
                                        <div class="flex-1">
                                            <div class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Detail Item</div>
                                            <ul class="space-y-2">
                                                @foreach($order->items as $item)
                                                    <li class="flex justify-between text-sm bg-white p-2 rounded border border-gray-100">
                                                        <span>
                                                            <span class="font-bold text-brand-dark">{{ $item->quantity }}x</span> {{ $item->product->name }}
                                                            @if($item->name && str_contains($item->name, '('))
                                                                <span class="text-xs text-gray-400">{{ Str::after($item->name, '(') }}</span>
                                                            @endif
                                                        </span>
                                                        <span class="font-mono text-gray-600">Rp {{ number_format($item->price * $item->quantity, 0, ',', '.') }}</span>
                                                    </li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        </template>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-6 py-8 text-center text-gray-500">Belum ada pesanan masuk.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
