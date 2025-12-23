<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cek Segitiga</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex items-center justify-center h-screen">
    <div class="bg-white p-8 rounded shadow-md w-96">
        <h1 class="text-2xl font-bold mb-4 text-center">Cek Jenis Segitiga</h1>

        @if(session('result'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4 text-center font-bold">
                {{ session('result') }}
            </div>
        @endif

        <form action="{{ route('triangle.check') }}" method="POST" class="space-y-4">
            @csrf
            <div>
                <label class="block text-sm font-bold mb-1">Sisi A</label>
                <input type="number" step="0.01" name="a" value="{{ old('a') }}" class="w-full border p-2 rounded" required>
            </div>
            <div>
                <label class="block text-sm font-bold mb-1">Sisi B</label>
                <input type="number" step="0.01" name="b" value="{{ old('b') }}" class="w-full border p-2 rounded" required>
            </div>
            <div>
                <label class="block text-sm font-bold mb-1">Sisi C</label>
                <input type="number" step="0.01" name="c" value="{{ old('c') }}" class="w-full border p-2 rounded" required>
            </div>
            <button type="submit" class="w-full bg-blue-500 text-white font-bold py-2 px-4 rounded hover:bg-blue-700">
                Cek Segitiga
            </button>
        </form>

        <div class="mt-4 text-center">
            <a href="{{ url('/') }}" class="text-gray-500 text-sm hover:underline">Kembali ke Home</a>
        </div>
    </div>
</body>
</html>
