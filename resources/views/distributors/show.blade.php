<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('تفاصيل شركة التوزيع') }}
        </h2>
    </x-slot>

    <div class="py-10">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow sm:rounded-lg p-6">
                <h3 class="text-lg font-bold mb-4 text-indigo-700">{{ $distributor->name }}</h3>

                <div class="grid grid-cols-2 gap-4">
                    <div><strong>المدير:</strong> {{ $distributor->manager_name ?? '—' }}</div>
                    <div><strong>البريد الإلكتروني:</strong> {{ $distributor->email ?? '—' }}</div>

                    <div><strong>الهاتف:</strong> {{ $distributor->phone ?? '—' }}</div>
                    <div><strong>المفوض:</strong> {{ $distributor->delegate_name ?? '—' }}</div>

                    <div><strong>هاتف المفوض:</strong> {{ $distributor->delegate_phone ?? '—' }}</div>
                    <div><strong>المنطقة:</strong> {{ $distributor->region ?? '—' }}</div>

                    <div><strong>المدينة:</strong> {{ $distributor->city ?? '—' }}</div>
                    <div><strong>العنوان:</strong> {{ $distributor->address ?? '—' }}</div>

                    <div><strong>خط العرض:</strong> {{ $distributor->latitude ?? '—' }}</div>
                    <div><strong>خط الطول:</strong> {{ $distributor->longitude ?? '—' }}</div>
                </div>

                <div class="mt-6 flex justify-between">
                    <a href="{{ route('distributors.index') }}" class="px-4 py-2 bg-gray-200 text-gray-700 rounded hover:bg-gray-300">
                        ← رجوع
                    </a>

                    @if ($distributor->latitude && $distributor->longitude)
                        <a href="https://www.google.com/maps?q={{ $distributor->latitude }},{{ $distributor->longitude }}" target="_blank"
                           class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700">
                            عرض على الخريطة 🌍
                        </a>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
