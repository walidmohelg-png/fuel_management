<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('تفاصيل الشركة المستفيدة') }}
        </h2>
    </x-slot>

    <div class="py-10">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-md sm:rounded-lg p-6">

                {{-- شريط الإجراءات (التعديل، الحذف، العودة) --}}
                <div class="flex flex-col md:flex-row justify-between items-center mb-6">
                    <h3 class="text-3xl font-extrabold text-gray-900 mb-4 md:mb-0">{{ $beneficiaryCompany->name ?? __('غير محدد') }}</h3>
                    <div class="flex flex-wrap gap-2"> {{-- استخدام flex-wrap و gap لتنظيم الأزرار --}}
                        <a href="{{ route('beneficiaries.edit', ['beneficiaryCompany' => $beneficiaryCompany->id]) }}" class="bg-yellow-500 hover:bg-yellow-600 text-white font-bold py-2 px-4 rounded-md shadow-sm transition duration-150 ease-in-out">
                            {{ __('تعديل') }}
                        </a>
                       <form action="{{ route('beneficiaries.destroy', ['beneficiaryCompany' => $beneficiaryCompany->id]) }}" method="POST" class="inline" onsubmit="return confirm('{{ __('هل أنت متأكد من حذف هذه الشركة؟') }}');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="bg-red-600 hover:bg-red-700 text-white font-bold py-2 px-4 rounded-md shadow-sm transition duration-150 ease-in-out">
                                {{ __('حذف') }}
                            </button>
                        </form>
                        <a href="{{ route('beneficiaries.index') }}" class="bg-gray-400 hover:bg-gray-500 text-white font-bold py-2 px-4 rounded-md shadow-sm transition duration-150 ease-in-out">
                            {{ __('العودة للقائمة') }}
                        </a>
                    </div>
                </div>

                {{-- قسم معلومات الشركة الأساسية --}}
                <div class="mb-8 p-6 bg-gray-50 rounded-lg border border-gray-200"> {{-- ✅ تلوين خلفية القسم والحدود --}}
                    <h4 class="text-2xl font-semibold text-gray-800 mb-6 border-b pb-3">{{ __('المعلومات الأساسية') }}</h4> {{-- ✅ تحسين العنوان --}}
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6"> {{-- ✅ تحسين تصميم الشبكة --}}
                        <div class="space-y-1"> {{-- ✅ تجميع Label و Value --}}
                            <p class="text-gray-600 font-medium">{{ __('اسم الشركة:') }}</p>
                            <p class="text-gray-900 font-bold">{{ $beneficiaryCompany->name ?? '-' }}</p>
                        </div>
                        <div class="space-y-1">
                            <p class="text-gray-600 font-medium">{{ __('البريد الإلكتروني:') }}</p>
                            <p class="text-gray-900">{{ $beneficiaryCompany->email ?? '-' }}</p>
                        </div>
                        <div class="space-y-1">
                            <p class="text-gray-600 font-medium">{{ __('رقم السجل التجاري:') }}</p>
                            <p class="text-gray-900">{{ $beneficiaryCompany->registration_number ?? '-' }}</p>
                        </div>
                        <div class="space-y-1">
                            <p class="text-gray-600 font-medium">{{ __('شركة التوزيع المرتبطة:') }}</p>
                            <p class="text-gray-900">{{ $beneficiaryCompany->distributor->name ?? '-' }}</p>
                        </div>
                        <div class="space-y-1">
                            <p class="text-gray-600 font-medium">{{ __('المنطقة (من الشركة نفسها):') }}</p>
                            <p class="text-gray-900">{{ $beneficiaryCompany->region ?? '-' }}</p>
                        </div>
                        <div class="space-y-1">
                            <p class="text-gray-600 font-medium">{{ __('المدينة (من الشركة نفسها):') }}</p>
                            <p class="text-gray-900">{{ $beneficiaryCompany->city ?? '-' }}</p>
                        </div>
                        <div class="space-y-1">
                            <p class="text-gray-600 font-medium">{{ __('خط العرض:') }}</p>
                            <p class="text-gray-900">{{ $beneficiaryCompany->latitude ?? '-' }}</p>
                        </div>
                        <div class="space-y-1">
                            <p class="text-gray-600 font-medium">{{ __('خط الطول:') }}</p>
                            <p class="text-gray-900">{{ $beneficiaryCompany->longitude ?? '-' }}</p>
                        </div>
                        <div class="space-y-1 md:col-span-2 lg:col-span-1"> {{-- ✅ ليتناسب مع الشبكة --}}
                            <p class="text-gray-600 font-medium">{{ __('الحالة الحالية (من الشركة نفسها):') }}</p>
                            <p class="text-gray-900">{{ $beneficiaryCompany->current_status ?? '-' }}</p>
                        </div>
                        <div class="space-y-1 md:col-span-2 lg:col-span-2"> {{-- ✅ ليأخذ عرضاً أكبر --}}
                            <p class="text-gray-600 font-medium">{{ __('العنوان (من الشركة نفسها):') }}</p>
                            <p class="text-gray-900">{{ $beneficiaryCompany->address ?? '-' }}</p>
                        </div>
                        @if ($beneficiaryCompany->latitude && $beneficiaryCompany->longitude)
                            <div class="md:col-span-3 mt-6"> {{-- ✅ ليأخذ عرضاً كاملاً في الخريطة --}}
                                <h5 class="text-gray-700 font-medium mb-3">{{ __('الموقع على الخريطة:') }}</h5>
                                <iframe
                                    width="100%"
                                    height="300"
                                    frameborder="0" style="border:0; border-radius: 8px;" {{-- ✅ حواف دائرية --}}
                                    src="https://www.google.com/maps?q={{ $beneficiaryCompany->latitude }},{{ $beneficiaryCompany->longitude }}&z=15&output=embed"
                                    allowfullscreen>
                                </iframe>
                            </div>
                        @endif
                    </div>
                </div>

                {{-- قسم تفاصيل الشركة (CompanyDetail) --}}
                @if ($beneficiaryCompany->companyDetail)
                    <div class="mb-8 p-6 bg-gray-50 rounded-lg border border-gray-200">
                        <h4 class="text-2xl font-semibold text-gray-700 mb-6 border-b pb-3">{{ __('تفاصيل الشركة والمخصصات') }}</h4>
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                            <div class="space-y-1">
                                <p class="text-gray-600 font-medium">{{ __('نوع الوقود:') }}</p>
                                <p class="text-gray-900">{{ $beneficiaryCompany->companyDetail->fuel_type ?? '-' }}</p>
                            </div>
                            <div class="space-y-1">
                                <p class="text-gray-600 font-medium">{{ __('المخصص الشهري:') }}</p>
                                <p class="text-gray-900">{{ $beneficiaryCompany->companyDetail->monthly_allowance ?? '-' }}</p>
                            </div>
                            <div class="space-y-1">
                                <p class="text-gray-600 font-medium">{{ __('مستودع التوريد:') }}</p>
                                <p class="text-gray-900">{{ $beneficiaryCompany->companyDetail->supply_warehouse ?? '-' }}</p>
                            </div>
                            <div class="space-y-1">
                                <p class="text-gray-600 font-medium">{{ __('اسم المفوض:') }}</p>
                                <p class="text-gray-900">{{ $beneficiaryCompany->companyDetail->authorized_person_name ?? '-' }}</p>
                            </div>
                            <div class="space-y-1">
                                <p class="text-gray-600 font-medium">{{ __('رقم هاتف المفوض:') }}</p>
                                <p class="text-gray-900">{{ $beneficiaryCompany->companyDetail->authorized_person_phone ?? '-' }}</p>
                            </div>
                            <div class="space-y-1">
                                <p class="text-gray-600 font-medium">{{ __('بريد المفوض الإلكتروني:') }}</p>
                                <p class="text-gray-900">{{ $beneficiaryCompany->companyDetail->authorized_person_email ?? '-' }}</p>
                            </div>
                             <div class="space-y-1">
                                <p class="text-gray-600 font-medium">{{ __('رقم الهوية الوطنية للمفوض:') }}</p>
                                <p class="text-gray-900">{{ $beneficiaryCompany->companyDetail->authorized_person_national_id ?? '-' }}</p>
                            </div>
                            <div class="space-y-1">
                                <p class="text-gray-600 font-medium">{{ __('رقم جواز سفر المفوض:') }}</p>
                                <p class="text-gray-900">{{ $beneficiaryCompany->companyDetail->authorized_person_passport_no ?? '-' }}</p>
                            </div>
                            @if($beneficiaryCompany->companyDetail->authorized_person_photo_path)
                            <div class="md:col-span-2 lg:col-span-1 text-center"> {{-- ✅ تجميع وعرض الصورة بشكل جيد --}}
                                <p class="text-gray-600 font-medium mb-2">{{ __('صورة المفوض:') }}</p>
                                <img src="{{ asset('storage/' . $beneficiaryCompany->companyDetail->authorized_person_photo_path) }}" alt="صورة المفوض" class="w-32 h-32 object-cover rounded-md mx-auto border border-gray-300 shadow-sm">
                            </div>
                            @endif

                            <div class="space-y-1">
                                <p class="text-gray-600 font-medium">{{ __('اسم الممثل:') }}</p>
                                <p class="text-gray-900">{{ $beneficiaryCompany->companyDetail->representative_name ?? '-' }}</p>
                            </div>
                            <div class="space-y-1">
                                <p class="text-gray-600 font-medium">{{ __('رقم هاتف الممثل:') }}</p>
                                <p class="text-gray-900">{{ $beneficiaryCompany->companyDetail->representative_phone ?? '-' }}</p>
                            </div>
                            <div class="space-y-1">
                                <p class="text-gray-600 font-medium">{{ __('بريد الممثل الإلكتروني:') }}</p>
                                <p class="text-gray-900">{{ $beneficiaryCompany->companyDetail->representative_email ?? '-' }}</p>
                            </div>
                             <div class="space-y-1">
                                <p class="text-gray-600 font-medium">{{ __('رقم الهوية الوطنية للممثل:') }}</p>
                                <p class="text-gray-900">{{ $beneficiaryCompany->companyDetail->representative_national_id ?? '-' }}</p>
                            </div>
                            <div class="space-y-1">
                                <p class="text-gray-600 font-medium">{{ __('رقم جواز سفر الممثل:') }}</p>
                                <p class="text-gray-900">{{ $beneficiaryCompany->companyDetail->representative_passport_no ?? '-' }}</p>
                            </div>
                             @if($beneficiaryCompany->companyDetail->representative_photo_path)
                            <div class="md:col-span-2 lg:col-span-1 text-center">
                                <p class="text-gray-600 font-medium mb-2">{{ __('صورة الممثل:') }}</p>
                                <img src="{{ asset('storage/' . $beneficiaryCompany->companyDetail->representative_photo_path) }}" alt="صورة الممثل" class="w-32 h-32 object-cover rounded-md mx-auto border border-gray-300 shadow-sm">
                            </div>
                            @endif

                            <div class="space-y-1 md:col-span-3"> {{-- ✅ ملاحظات تأخذ عرضاً كاملاً --}}
                                <p class="text-gray-600 font-medium">{{ __('ملاحظات:') }}</p>
                                <p class="text-gray-900">{{ $beneficiaryCompany->companyDetail->notes ?? '-' }}</p>
                            </div>
                            <div class="space-y-1">
                                <p class="text-gray-600 font-medium">{{ __('تاريخ سريان المخصصات:') }}</p>
                                <p class="text-gray-900">{{ $beneficiaryCompany->companyDetail->effective_date ? \Carbon\Carbon::parse($beneficiaryCompany->companyDetail->effective_date)->format('Y-m-d') : '-' }}</p>
                            </div>
                        </div>
                    </div>
                @else
                    <div class="mb-8 p-6 bg-gray-50 rounded-lg border border-gray-200">
                        <h4 class="text-2xl font-semibold text-gray-700 mb-4">{{ __('تفاصيل الشركة') }}</h4>
                        <p class="text-gray-600">{{ __('لا توجد تفاصيل إضافية مسجلة لهذه الشركة.') }}</p>
                    </div>
                @endif

                {{-- قسم وثائق الشركة (CompanyDocument) --}}
                @if ($beneficiaryCompany->documents->isNotEmpty())
                    <div class="mb-8 p-6 bg-gray-50 rounded-lg border border-gray-200">
                        <h4 class="text-2xl font-semibold text-gray-700 mb-6 border-b pb-3">{{ __('وثائق الشركة') }}</h4>
                        <div class="overflow-x-auto">
                            <table class="min-w-full bg-white border border-gray-200 text-sm rounded-lg overflow-hidden"> {{-- ✅ تحسين مظهر الجدول --}}
                                <thead class="bg-gray-200 text-gray-700"> {{-- ✅ لون خلفية الرأس --}}
                                    <tr>
                                        <th class="py-3 px-4 border-b border-gray-300 text-right">{{ __('نوع الوثيقة') }}</th> {{-- ✅ محاذاة لليمين --}}
                                        <th class="py-3 px-4 border-b border-gray-300 text-right">{{ __('رقم الوثيقة') }}</th>
                                        <th class="py-3 px-4 border-b border-gray-300 text-right">{{ __('تاريخ الانتهاء') }}</th>
                                        <th class="py-3 px-4 border-b border-gray-300 text-right">{{ __('الحالة') }}</th>
                                        <th class="py-3 px-4 border-b border-gray-300 text-right">{{ __('الملف') }}</th>
                                        <th class="py-3 px-4 border-b border-gray-300 text-right">{{ __('ملاحظات') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($beneficiaryCompany->documents as $document)
                                        <tr class="hover:bg-gray-100"> {{-- ✅ تأثير عند التحويم --}}
                                            <td class="py-2 px-4 border-b border-gray-200 text-right">{{ $document->document_type ?? '-' }}</td>
                                            <td class="py-2 px-4 border-b border-gray-200 text-right">{{ $document->document_number ?? '-' }}</td>
                                            <td class="py-2 px-4 border-b border-gray-200 text-right">{{ $document->expiry_date ? \Carbon\Carbon::parse($document->expiry_date)->format('Y-m-d') : '-' }}</td>
                                            <td class="py-2 px-4 border-b border-gray-200 text-right">{{ $document->document_status ?? '-' }}</td>
                                            <td class="py-2 px-4 border-b border-gray-200 text-right">
                                                @if ($document->document_file) {{-- ✅ تغيير file_path إلى document_file هنا --}}
                                                    <a href="{{ asset('storage/' . $document->document_file) }}" target="_blank" class="text-blue-600 hover:underline">
                                                        {{ __('عرض الملف') }}
                                                    </a>
                                                @else
                                                    -
                                                @endif
                                            </td>
                                            <td class="py-2 px-4 border-b border-gray-200 text-right">{{ $document->notes ?? '-' }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                @else
                    <div class="mb-8 p-6 bg-gray-50 rounded-lg border border-gray-200">
                        <h4 class="text-2xl font-semibold text-gray-700 mb-4">{{ __('وثائق الشركة') }}</h4>
                        <p class="text-gray-600">{{ __('لا توجد وثائق مسجلة لهذه الشركة.') }}</p>
                    </div>
                @endif

            </div>
        </div>
    </div>
</x-app-layout>