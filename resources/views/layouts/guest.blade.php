<!DOCTYPE html>
<html lang="ar" dir="rtl"> <!-- تم التأكد من lang="ar" و dir="rtl" -->
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <!-- تم تعديل خلفية الجسم لتكون بيضاء (من تعريفاتنا المخصصة) -->
    <body class="bg-background-white font-sans antialiased"> 
        <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gray-100">
            <div>
                <a href="/">
                    <x-application-logo class="w-20 h-20 fill-current text-gray-500" />
                </a>
            </div>

            <!-- تم إضافة text-right و rtl:text-right هنا لتصحيح اتجاه النص داخل النموذج -->
            <div class="w-full sm:max-w-md mt-6 px-6 py-4 bg-white shadow-md overflow-hidden sm:rounded-lg text-right rtl:text-right">
                {{ $slot }}
            </div>
        </div>
    </body>
</html>