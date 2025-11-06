<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('إدارة تفاصيل الشركات') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            {{-- رسالة النجاح --}}
            @if(session('success'))
                <div class="bg-green-100 border border-green-500 text-green-700 p-4 mb-4 rounded">
                    {{ session('success') }}
                </div>
            @endif

            {{-- زر إضافة تفاصيل جديدة --}}
            <div class="flex justify-start mb-4">
                <a href="{{ route('company_details.create') }}"
                   class="px-4 py-2 bg-indigo-600 text-white rounded-md font-semibold hover:bg-indigo-700">
                    {{ __('إضافة تفاصيل شركة جديدة') }}
                </a>
            </div>

            {{-- جدول عرض البيانات --}}
            <div class="bg-white shadow overflow-hidden sm:rounded-lg p-6">
                @if($details->count() > 0)
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">اسم الشركة</th>
                                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">الموقع</th>
                                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">السعة التخزينية</th>
                                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">عدد الموظفين</th>
                                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">الإجراءات</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($details as $detail)
                                <tr>
                                    <td class="px-6 py-4 text-sm text-gray-900">{{ $detail->company->name ?? 'غير محدد' }}</td>
                                    <td class="px-6 py-4 text-sm text-gray-900">{{ $detail->warehouse_location ?? '—' }}</td>
                                    <td class="px-6 py-4 text-sm text-gray-900">{{ $detail->storage_capacity ?? '—' }}</td>
                                    <td class="px-6 py-4 text-sm text-gray-900">{{ $detail->number_of_employees ?? '—' }}</td>
                                    <td class="px-6 py-4 text-sm text-gray-900">
                                        <form action="{{ route('company_details.destroy', $detail->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" onclick="return confirm('هل أنت متأكد من الحذف؟')" class="text-red-600 hover:text-red-800">
                                                حذف
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @else
                    <p class="text-gray-600 text-center">لا توجد تفاصيل شركات بعد.</p>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
