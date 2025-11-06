<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('إدارة محطات الوقود') }}
        </h2>
    </x-slot>

    <div class="py-10">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-xl sm:rounded-2xl p-6 border border-gray-100">

                {{-- ✅ زر إضافة محطة جديدة --}}
                <div class="flex justify-between items-center mb-6">
                    <h3 class="text-lg font-semibold text-gray-700">قائمة المحطات</h3>
                    <a href="{{ route('fuel_stations.create.step1') }}"
                       class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg shadow transition duration-150">
                        ➕ {{ __('إضافة محطة جديدة') }}
                    </a>
                </div>

                {{-- ✅ فلاتر البحث --}}
                <div class="mb-8">
                    <form method="GET" action="{{ route('fuel_stations.index') }}" class="flex flex-wrap items-end gap-4">
                        <div class="flex-1 min-w-[200px]">
                            <label for="search" class="block text-sm text-gray-600 mb-1">{{ __('بحث بالاسم أو المالك') }}</label>
                            <input type="text" name="search" id="search"
                                   value="{{ request('search') }}"
                                   placeholder="{{ __('ابحث هنا...') }}"
                                   class="border border-gray-300 rounded-md px-3 py-2 w-full focus:ring focus:ring-indigo-200">
                        </div>

                        <div class="w-40 min-w-[120px]">
                            <label for="region" class="block text-sm text-gray-600 mb-1">{{ __('المنطقة') }}</label>
                            <input type="text" name="region" id="region"
                                   value="{{ request('region') }}"
                                   placeholder="{{ __('الكل') }}"
                                   class="border border-gray-300 rounded-md px-3 py-2 w-full focus:ring focus:ring-indigo-200">
                        </div>

                        <div class="w-40 min-w-[120px]">
                            <label for="city" class="block text-sm text-gray-600 mb-1">{{ __('المدينة') }}</label>
                            <input type="text" name="city" id="city"
                                   value="{{ request('city') }}"
                                   placeholder="{{ __('الكل') }}"
                                   class="border border-gray-300 rounded-md px-3 py-2 w-full focus:ring focus:ring-indigo-200">
                        </div>

                        <button type="submit"
                                class="bg-blue-600 hover:bg-blue-700 text-white font-semibold px-6 py-2 rounded-md shadow">
                            {{ __('تصفية') }}
                        </button>
                    </form>
                </div>

                {{-- ✅ رسالة نجاح --}}
                @if(session('success'))
                    <div class="mb-4 p-3 bg-green-100 border border-green-300 text-green-800 rounded-md text-center">
                        {{ session('success') }}
                    </div>
                @endif

                {{-- ✅ جدول عرض محطات الوقود --}}
                <div class="overflow-x-auto rounded-lg border border-gray-200 shadow-sm">
                    <table class="min-w-full divide-y divide-gray-200 text-center text-sm">
                        <thead class="bg-gray-100 text-gray-700 font-semibold">
                            <tr>
                                <th class="px-3 py-3">#</th>
                                <th class="px-3 py-3">اسم المحطة</th>
                                <th class="px-3 py-3">اسم المالك</th>
                                <th class="px-3 py-3">الهاتف</th>
                                <th class="px-3 py-3">المدينة</th>
                                <th class="px-3 py-3">المنطقة</th>
                                <th class="px-3 py-3">شركة التوزيع</th>
                                <th class="px-3 py-3">العمليات</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse($fuelStations as $station)
                                <tr class="hover:bg-gray-50 transition duration-150">
                                    <td class="px-3 py-2 text-gray-500">{{ $loop->iteration }}</td>
                                    <td class="px-3 py-2 font-semibold text-indigo-700">{{ $station->station_name }}</td>
                                    <td class="px-3 py-2">{{ $station->owner_name ?? '-' }}</td>
                                    <td class="px-3 py-2">{{ $station->owner_phone ?? '-' }}</td>
                                    <td class="px-3 py-2">{{ $station->city ?? '-' }}</td>
                                    <td class="px-3 py-2">{{ $station->region ?? '-' }}</td>
                                    <td class="px-3 py-2">{{ $station->distributor->name ?? '-' }}</td>

                                    <td class="px-3 py-2">
                                        <div class="flex justify-center gap-3 text-sm">
                                            <a href="{{ route('fuel_stations.show', $station->id) }}"
                                               class="text-blue-600 hover:text-blue-800 font-semibold">عرض</a>
                                            <a href="{{ route('fuel_stations.edit', $station->id) }}"
                                               class="text-yellow-600 hover:text-yellow-800 font-semibold">تعديل</a>
                                            <button class="text-red-600 hover:text-red-800 font-semibold delete-btn"
                                                    data-id="{{ $station->id }}">
                                                حذف
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="py-4 text-gray-500">لا توجد محطات وقود مسجلة بعد.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>

    {{-- ✅ SweetAlert للحذف --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const deleteButtons = document.querySelectorAll('.delete-btn');
            deleteButtons.forEach(button => {
                button.addEventListener('click', function () {
                    const id = this.getAttribute('data-id');
                    Swal.fire({
                        title: 'هل أنت متأكد؟',
                        text: "لن يمكنك التراجع بعد الحذف!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#d33',
                        cancelButtonColor: '#3085d6',
                        confirmButtonText: 'نعم، احذفها!',
                        cancelButtonText: 'إلغاء'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            fetch(`/fuel_stations/${id}`, {
                                method: 'DELETE',
                                headers: {
                                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                    'Accept': 'application/json'
                                }
                            })
                            .then(response => response.json())
                            .then(data => {
                                if (data.success) {
                                    Swal.fire({
                                        title: 'تم الحذف!',
                                        text: data.message,
                                        icon: 'success',
                                        timer: 1500,
                                        showConfirmButton: false
                                    });
                                    this.closest('tr').remove();
                                } else {
                                    Swal.fire('خطأ', data.message || 'حدث خطأ أثناء الحذف', 'error');
                                }
                            })
                            .catch(() => Swal.fire('خطأ', 'حدث خطأ في الاتصال بالخادم', 'error'));
                        }
                    });
                });
            });
        });
    </script>
</x-app-layout>
