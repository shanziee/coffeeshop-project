<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login - Ngopi Kalcer</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Playfair+Display:wght@700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
        .bg-brand-light { background-color: #f8f5f2; }
        .bg-brand-dark { background-color: #4a3f35; }
        .text-brand-dark { color: #4a3f35; }
        .btn-brand {
            background-color: #c8a063;
            color: #ffffff;
            transition: all 0.3s;
        }
        .btn-brand:hover { background-color: #b08d53; }
    </style>
</head>
<body class="bg-brand-light">

    <div class="flex items-center justify-center min-h-screen p-6">
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
                        <label for="username" class="block text-sm font-medium text-gray-600 mb-2">Username</label>
                        <input type="text" id="username" name="username" value="{{ old('username') }}" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-amber-500" placeholder="admin" required>
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
    </div>

</body>
</html>
