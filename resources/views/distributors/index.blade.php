<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('شركات التوزيع') }}
        </h2>
    </x-slot>

    <div class="py-10">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-md sm:rounded-lg p-6">

                {{-- زر إضافة شركة جديدة --}}
                <div class="flex justify-between items-center mb-6">
                    <a href="{{ route('distributors.create') }}" 
                       class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg transition">
                        ➕ {{ __('إضافة شركة جديدة') }}
                    </a>
                </div>

                {{-- فلاتر البحث --}}
                <div class="mb-6">
                    <form method="GET" action="{{ route('beneficiaries.index') }}" class="flex flex-wrap items-end gap-4">

                        {{-- مربع البحث --}}
                        <div class="flex-1 min-w-[200px]">
                            <label for="search" class="block text-sm text-gray-600 mb-1">{{ __('بحث بالاسم أو المدير') }}</label>
                            <input type="text" name="search" id="search"
                                value="{{ request('search') }}"
                                placeholder="{{ __('ابحث هنا...') }}"
                                class="border border-gray-300 rounded-md px-3 py-2 w-full focus:ring focus:ring-indigo-200">
                        </div>

                        {{-- ✅ فلتر المنطقة - أصبح مربع إدخال نصي --}}
                        <div class="w-40 min-w-[120px]">
                            <label for="region" class="block text-sm text-gray-600 mb-1">{{ __('المنطقة') }}</label>
                            <input type="text" name="region" id="region"
                                   value="{{ request('region') }}"
                                   placeholder="{{ __('الكل') }}"
                                   class="border border-gray-300 rounded-md px-3 py-2 w-full focus:ring focus:ring-indigo-200">
                        </div>

                        {{-- ✅ فلتر المدينة - أصبح مربع إدخال نصي --}}
                        <div class="w-40 min-w-[120px]">
                            <label for="city" class="block text-sm text-gray-600 mb-1">{{ __('المدينة') }}</label>
                            <input type="text" name="city" id="city"
                                   value="{{ request('city') }}"
                                   placeholder="{{ __('الكل') }}"
                                   class="border border-gray-300 rounded-md px-3 py-2 w-full focus:ring focus:ring-indigo-200">
                        </div>

                        {{-- زر تصفية --}}
                        <div>
                            <button type="submit"
                                class="bg-blue-600 hover:bg-blue-700 text-white font-bold px-4 py-2 rounded-md shadow-sm">
                                {{ __('تصفية') }}
                            </button>
                        </div>
                    </form>
                </div>


                {{-- رسالة نجاح --}}
                @if(session('success'))
                    <div class="mb-4 p-3 bg-green-100 border border-green-300 text-green-800 rounded">
                        {{ session('success') }}
                    </div>
                @endif

                {{-- جدول عرض الشركات --}}
                <div class="overflow-x-auto">
                    <table class="min-w-full border border-gray-200 text-center">
                        <thead class="bg-gray-100">
                            <tr>
                                <th class="px-3 py-2 border">#</th>
                                <th class="px-3 py-2 border">اسم الشركة</th>
                                <th class="px-3 py-2 border">المدير</th>
                                <th class="px-3 py-2 border">الهاتف</th>
                                <th class="px-3 py-2 border">المدينة</th>
                                <th class="px-3 py-2 border">الموقع</th>
                                <th class="px-3 py-2 border">العمليات</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($distributors as $distributor)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-3 py-2 border">{{ $loop->iteration }}</td>
                                    <td class="px-3 py-2 border font-semibold text-indigo-700">
                                        {{ $distributor->name }}
                                    </td>
                                    <td class="px-3 py-2 border">{{ $distributor->manager_name ?? '-' }}</td>
                                    <td class="px-3 py-2 border">{{ $distributor->phone ?? '-' }}</td>
                                    <td class="px-3 py-2 border">{{ $distributor->city ?? '-' }}</td>

                                    {{-- عرض الخريطة --}}
                                    <td class="px-3 py-2 border">
                                        @if($distributor->latitude && $distributor->longitude)
                                            <a href="https://www.google.com/maps?q={{ $distributor->latitude }},{{ $distributor->longitude }}" 
                                               target="_blank" 
                                               class="text-blue-600 hover:underline">
                                               عرض على الخريطة 🗺️
                                            </a>
                                        @else
                                            <span class="text-gray-400">غير متوفر</span>
                                        @endif
                                    </td>

                                    {{-- عمليات --}}
                                    <td class="px-3 py-2 border">
                                        <div class="flex justify-center space-x-2 space-x-reverse">
                                            <a href="{{ route('distributors.show', $distributor->id) }}" class="text-blue-600 hover:text-blue-800">عرض</a>
                                            <a href="{{ route('distributors.edit', $distributor->id) }}" class="text-yellow-600 hover:text-yellow-800">تعديل</a>
                                           <button 
                                            class="text-red-600 hover:text-red-800 delete-btn"
                                            data-id="{{ $distributor->id }}">
                                                حذف
                                            </button>

                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="py-4 text-gray-500">لا توجد شركات توزيع مسجلة بعد.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>

    <script>
document.addEventListener('DOMContentLoaded', function () {
    const deleteButtons = document.querySelectorAll('.delete-btn');

    deleteButtons.forEach(button => {
        button.addEventListener('click', function () {
            const id = this.getAttribute('data-id');

            if (confirm('هل أنت متأكد أنك تريد حذف هذه الشركة؟')) {
                fetch(`/distributors/${id}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert(data.message);
                        // إزالة الصف مباشرة بدون تحديث الصفحة
                        this.closest('tr').remove();
                    } else {
                        alert('حدث خطأ أثناء الحذف');
                    }
                })
                .catch(error => console.error('Error:', error));
            }
        });
    });
});
</script>

</x-app-layout>
