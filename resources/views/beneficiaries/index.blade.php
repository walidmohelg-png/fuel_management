<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            🧾 {{ __('الشركات المستفيدة') }}
        </h2>
    </x-slot>

    <div class="py-10">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            {{-- رسالة نجاح --}}
            @if (session('success'))
                <div class="mb-4 p-3 bg-green-100 border border-green-300 text-green-800 rounded">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white shadow-md sm:rounded-lg p-6">

                {{-- شريط الأدوات مع زر إضافة شركة جديدة --}}
                <div class="flex flex-col md:flex-row justify-between items-center mb-6">
                    <a href="{{ route('beneficiaries.create_step_1') }}"
                        class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg transition shadow-sm">
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

                        {{-- فلتر المنطقة - أصبح مربع إدخال نصي --}}
                        <div class="w-40 min-w-[120px]">
                            <label for="region" class="block text-sm text-gray-600 mb-1">{{ __('المنطقة') }}</label>
                            <input type="text" name="region" id="region"
                                   value="{{ request('region') }}"
                                   placeholder="{{ __('الكل') }}"
                                   class="border border-gray-300 rounded-md px-3 py-2 w-full focus:ring focus:ring-indigo-200">
                        </div>

                        {{-- فلتر المدينة - أصبح مربع إدخال نصي --}}
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
                                class="bg-blue-600 hover:bg-blue-700 text-white font-bold px-4 py-2 rounded-md shadow-sm transition duration-150 ease-in-out">
                                {{ __('تصفية') }}
                            </button>
                        </div>
                    </form>
                </div>


                {{-- الجدول --}}
                <div class="overflow-x-auto">
                    <table class="min-w-full border border-gray-200 text-sm text-center table-auto">
                        <thead class="bg-gray-100 text-gray-700">
                            <tr>
                                <th class="border px-3 py-2">#</th>
                                <th class="border px-3 py-2">{{ __('اسم الشركة') }}</th>
                                <th class="border px-3 py-2">{{ __('المدير') }}</th>
                                <th class="border px-3 py-2">{{ __('الهاتف') }}</th>
                                <th class="border px-3 py-2">{{ __('المدينة') }}</th>
                                <th class="border px-3 py-2">{{ __('المنطقة') }}</th> {{-- ✅ أضفنا عمود المنطقة --}}
                                <th class="border px-3 py-2">{{ __('الموقع') }}</th>
                                <th class="border px-3 py-2">{{ __('العمليات') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($beneficiaries as $company)
                                <tr class="hover:bg-gray-50">
                                    <td class="border px-3 py-2">{{ $loop->iteration }}</td>
                                    <td class="border px-3 py-2 font-medium text-indigo-700">
                                        {{ $company->name }}
                                    </td>
                                    <td class="border px-3 py-2">{{ $company->companyDetail->authorized_person_name ?? '-' }}</td>
                                    <td class="border px-3 py-2">{{ $company->companyDetail->representative_phone ?? '-' }}</td>
                                    <td class="border px-3 py-2">{{ $company->companyDetail->city ?? '-' }}</td>
                                    <td class="border px-3 py-2">{{ $company->companyDetail->region ?? '-' }}</td> {{-- ✅ عرض المنطقة --}}
                                    <td class="border px-3 py-2">
                                        @if ($company->latitude && $company->longitude)
                                            <a href="https://www.google.com/maps?q={{ $company->latitude }},{{ $company->longitude }}"
                                               target="_blank" class="text-blue-600 hover:underline">🗺️ {{ __('عرض على الخريطة') }}</a>
                                        @else
                                            <span class="text-gray-400">{{ __('غير متوفر') }}</span>
                                        @endif
                                    </td>
                                    <td class="border px-3 py-2 text-center flex justify-center space-x-2 space-x-reverse">
                                        <a href="{{ route('beneficiaries.show', ['beneficiaryCompany' => $company->id]) }}"
                                           class="text-blue-600 hover:text-blue-800">{{ __('عرض') }}</a>
                                        <a href="{{ route('beneficiaries.edit', ['beneficiaryCompany' => $company->id]) }}"
                                           class="text-yellow-600 hover:text-yellow-800">{{ __('تعديل') }}</a>
                                        <form action="{{ route('beneficiaries.destroy', ['beneficiaryCompany' => $company->id]) }}" method="POST"
                                              class="inline"
                                              onsubmit="return confirm('{{ __('هل أنت متأكد من حذف هذه الشركة؟') }}');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                    class="text-red-600 hover:text-red-800">{{ __('حذف') }}</button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="py-4 text-gray-500">{{ __('لا توجد شركات مستفيدة حالياً.') }}</td> {{-- ✅ تم تعديل colspan --}}
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- روابط الصفحات --}}
                <div class="mt-4">
                    {{ $beneficiaries->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>