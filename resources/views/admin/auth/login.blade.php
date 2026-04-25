<!DOCTYPE html>
<html lang="bn">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>অ্যাডমিন লগইন | কাতুয়া শার্ট</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css'])
</head>
<body class="min-h-screen bg-gray-900 flex items-center justify-center px-4">
    <div class="w-full max-w-md">
        <div class="text-center mb-8">
            <h1 class="text-3xl font-bold text-black">Men's <span class="text-amber-400">Signature</span></h1>
            <p class="text-gray-400 mt-1 text-sm">অ্যাডমিন প্যানেল</p>
        </div>

        <div class="bg-white rounded-2xl shadow-xl p-8 border-2 border-gray-300">
            <h2 class="text-xl font-bold text-gray-900 mb-6">লগইন করুন</h2>

            @if($errors->any())
                <div class="bg-red-50 border border-red-200 text-red-700 rounded-xl px-4 py-3 text-sm mb-5">
                    {{ $errors->first() }}
                </div>
            @endif

            <form action="{{ route('admin.login.submit') }}" method="POST" class="space-y-4">
                @csrf
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-1">ইমেইল</label>
                    <input type="email" id="email" name="email" value="{{ old('email') }}" required autofocus
                           class="w-full border border-gray-300 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-amber-400 transition-shadow">
                </div>

                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700 mb-1">পাসওয়ার্ড</label>
                    <input type="password" id="password" name="password" required
                           class="w-full border border-gray-300 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-amber-400 transition-shadow">
                </div>

                <div class="flex items-center gap-2 pt-1">
                    <input type="checkbox" id="remember" name="remember" class="accent-amber-500">
                    <label for="remember" class="text-sm text-gray-600">লগইন মনে রাখুন</label>
                </div>

                <button type="submit"
                        class="w-full bg-gray-900 hover:bg-gray-700 text-white font-semibold py-3 rounded-xl transition-colors mt-2 text-sm">
                    লগইন করুন
                </button>
            </form>
        </div>

        <div class="border-t border-gray-800 mt-10 pt-6 text-center text-xs text-gray-500">
            &copy; {{ date('Y') }} Men's Signature | All rights reserved.
        </div>
    </div>
</body>
</html>
