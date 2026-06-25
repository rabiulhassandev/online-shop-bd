<!DOCTYPE html>
<html lang="bn">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Men's Signature ওয়েবসাইট আপডেট চলছে। উন্নত শপিং অভিজ্ঞতার জন্য আমরা সাময়িকভাবে রক্ষণাবেক্ষণ করছি।">
    <meta name="robots" content="noindex, nofollow">
    <title>সাইট আপডেট চলছে | Men's Signature</title>
    @vite(['resources/css/app.css'])
</head>
<body class="min-h-screen bg-gray-900 flex items-center justify-center px-4">
    <div class="text-center max-w-md">
        <div class="text-7xl mb-6">🔧</div>
        <h1 class="text-3xl font-bold text-amber-400 mb-3">মেইনটেন্যান্স চলছে</h1>
        <p class="text-gray-400 mb-8">আমরা আপনার শপিং অভিজ্ঞতা আরও উন্নত করতে ওয়েবসাইট আপডেটের কাজ করছি।</p>
        <p class="text-sm text-gray-500">যোগাযোগ: {{ \App\Models\Setting::get('phone', '01700000000') }}</p>
    </div>
</body>
</html>
