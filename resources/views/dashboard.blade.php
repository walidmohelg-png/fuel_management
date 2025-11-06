<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight text-right">
            {{ __('لوحة التحكم') }}
        </h2>
    </x-slot>

    <div class="py-10 bg-gray-50">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            {{-- بطاقة الإحصائيات --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                <div class="bg-white p-6 rounded-2xl shadow text-center border-r-4 border-blue-700">
                    <h3 class="text-lg font-semibold text-gray-700 mb-2">شركات التوزيع</h3>
                    <p class="text-3xl font-bold text-blue-800">12</p>
                </div>
                <div class="bg-white p-6 rounded-2xl shadow text-center border-r-4 border-indigo-700">
                    <h3 class="text-lg font-semibold text-gray-700 mb-2">الشركات المستفيدة</h3>
                    <p class="text-3xl font-bold text-indigo-800">27</p>
                </div>
                <div class="bg-white p-6 rounded-2xl shadow text-center border-r-4 border-blue-500">
                    <h3 class="text-lg font-semibold text-gray-700 mb-2">الوثائق المنتهية</h3>
                    <p class="text-3xl font-bold text-blue-600">5</p>
                </div>
            </div>

            {{-- مساحة مستقبلية للرسوم البيانية --}}
            <div class="bg-white p-8 rounded-2xl shadow">
                <h3 class="text-xl font-semibold text-blue-900 mb-4 text-right">الرسوم البيانية (قريباً)</h3>
                <div class="h-64 flex items-center justify-center text-gray-400">
                    <p>🔍 سيتم عرض الرسوم البيانية هنا لاحقاً</p>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
