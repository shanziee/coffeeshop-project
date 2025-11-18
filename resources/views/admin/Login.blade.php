// ... kode bagian atas sama ...
<div class="w-full max-w-md mx-auto bg-white rounded-2xl shadow-xl overflow-hidden">
    <div class="p-8 md:p-12">
        <h1 class="text-3xl font-bold text-brand-dark mb-2 text-center">Admin Login</h1>
        <h2 class="text-xl font-semibold text-gray-700 mb-6 text-center">Ngopi Kalcer</h2>

        @if ($errors->any())
            <div class="mb-4 rounded-lg bg-red-100 p-4 text-sm text-red-700">
                @foreach ($errors->all() as $error)
                    {{ $error }}
                @endforeach
            </div>
        @endif

        <form action="{{ route('admin.login') }}" method="POST">
            @csrf

            <div class="mb-4">
                {{-- UBAH LABEL JADI EMAIL --}}
                <label for="email" class="block text-sm font-medium text-gray-600 mb-2">Email</label>
                {{-- UBAH ID & NAME JADI EMAIL, UBAH PLACEHOLDER --}}
                <input type="text" id="email" name="email" value="{{ old('email') }}" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-amber-500" placeholder="admin@gmail.com" required>
            </div>

            <div class="mb-6">
                <label for="password" class="block text-sm font-medium text-gray-600 mb-2">Password</label>
                <input type="password" id="password" name="password" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-amber-500" placeholder="••••••••" required>
            </div>

            <button type="submit" class="w-full btn-brand font-bold py-3 px-4 rounded-lg transform transition-all duration-300 hover:scale-105">
                Login
            </button>
        </form>
    </div>
</div>
// ... kode bagian bawah sama ...
