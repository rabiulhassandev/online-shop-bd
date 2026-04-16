<!DOCTYPE html>
<html lang="bn">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>মেইনটেন্যান্স | কাতুয়া শার্ট</title>
    @vite(['resources/css/app.css'])
</head>
<body class="min-h-screen bg-gray-900 flex items-center justify-center px-4">
    <div class="text-center max-w-md">
        <div class="text-7xl mb-6">🔧</div>
        <h1 class="text-3xl font-bold text-white mb-3">মেইনটেন্যান্স চলছে</h1>
        <p class="text-gray-400 mb-8">আমরা কিছু উন্নতি করছি। অল্প সময়ের মধ্যে ফিরে আসব।</p>
        <p class="text-sm text-gray-500">যোগাযোগ: {{ \App\Models\Setting::get('phone', '01700000000') }}</p>
    </div>
</body>
</html>
