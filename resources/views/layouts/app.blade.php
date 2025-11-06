<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'نظام إدارة الوقود') }}</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100 font-sans antialiased">

    <div class="flex min-h-screen">

        {{-- الشريط الجانبي --}}
        <aside class="w-64 bg-blue-900 text-white flex flex-col">
            <div class="p-4 text-center border-b border-blue-700">
                <h1 class="text-2xl font-bold">⚙️ نظام الوقود</h1>
            </div>

            <nav class="flex-1 p-4 space-y-2">
                <a href="{{ route('dashboard') }}" class="block px-4 py-2 rounded hover:bg-blue-800 {{ request()->routeIs('dashboard') ? 'bg-blue-800' : '' }}">
                    🏠 لوحة التحكم
                </a>
                <a href="{{ route('distributors.index') }}" class="block px-4 py-2 rounded hover:bg-blue-800 {{ request()->is('distributors*') ? 'bg-blue-800' : '' }}">
                    🏢 شركات التوزيع
                </a>
                <a href="{{ route('beneficiaries.index') }}" class="block px-4 py-2 rounded hover:bg-blue-800 {{ request()->is('beneficiaries*') ? 'bg-blue-800' : '' }}">
                    🧾 الشركات المستفيدة
                </a>
                <a href="{{ route('fuel_stations.index') }}" class="block px-4 py-2 rounded hover:bg-blue-800 {{ request()->is('beneficiaries*') ? 'bg-blue-800' : '' }}">
                    🛢️ محطات الوقود
                </a>

                <a href="#" class="block px-4 py-2 rounded hover:bg-blue-800">
                    ⚙️ الإعدادات
                </a>
            </nav>

            {{-- تسجيل الخروج --}}
            <div class="p-4 border-t border-blue-700">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="w-full text-right text-red-300 hover:text-red-400">
                        🚪 تسجيل الخروج
                    </button>
                </form>
            </div>
        </aside>

        {{-- محتوى الصفحة --}}
        <main class="flex-1">
            {{-- الشريط العلوي --}}
            <header class="bg-white shadow p-4 flex justify-between items-center">
                <h2 class="text-lg font-semibold text-blue-900">
                    {{ $header ?? 'الصفحة الرئيسية' }}
                </h2>

                <div class="text-gray-700">
                    مرحباً، {{ Auth::user()->name ?? 'مستخدم' }}
                </div>
            </header>

            {{-- المحتوى الرئيسي --}}
            <div class="p-6">
                {{ $slot }}
            </div>
        </main>
    </div>

</body>
</html>
