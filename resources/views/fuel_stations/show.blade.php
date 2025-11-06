<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('عرض تفاصيل محطة الوقود') }}
        </h2>
    </x-slot>

    <div class="py-10 bg-gray-50 min-h-screen">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-lg rounded-2xl p-10 border border-gray-200">

                {{-- 🏷️ عنوان الصفحة --}}
                <div class="text-center mb-10">
                    <h3 class="text-2xl font-bold text-indigo-700">{{ $fuelStation->station_name }}</h3>
                    <p class="text-gray-500">رقم المحطة:
                        <span class="font-semibold">{{ $fuelStation->station_number }}</span>
                    </p>
                </div>

                {{-- 🏠 معلومات المحطة --}}
                <x-section title="معلومات المحطة" color="blue">
                    <x-info label="المدينة" :value="$fuelStation->city" />
                    <x-info label="المنطقة" :value="$fuelStation->region" />
                    <x-info label="العنوان" :value="$fuelStation->address" />
                    <x-info label="خط العرض" :value="$fuelStation->latitude" />
                    <x-info label="خط الطول" :value="$fuelStation->longitude" />
                    <x-info label="شركة التوزيع" :value="$fuelStation->distributor->name ?? 'غير متوفر'" />
                </x-section>

                {{-- 👤 بيانات المالك --}}
                <x-section title="بيانات المالك" color="green">
                    <x-info label="الاسم" :value="$fuelStation->owner_name" />
                    <x-info label="رقم الهاتف" :value="$fuelStation->owner_phone" />
                    <x-info label="الرقم الوطني" :value="$fuelStation->owner_nid" />
                    <x-info label="رقم الجواز" :value="$fuelStation->owner_passport" />
                    @if($fuelStation->owner_photo)
                        <div class="mt-4">
                            <p class="text-gray-600 mb-2">📷 صورة المالك:</p>
                            <img src="{{ asset('storage/'.$fuelStation->owner_photo) }}" class="h-40 w-40 rounded-lg border">
                        </div>
                    @endif
                </x-section>

                {{-- 🧑‍🔧 بيانات المشرف --}}
                <x-section title="بيانات المشرف" color="purple">
                    <x-info label="الاسم" :value="$fuelStation->supervisor_name" />
                    <x-info label="رقم الهاتف" :value="$fuelStation->supervisor_phone" />
                    <x-info label="الرقم الوطني" :value="$fuelStation->supervisor_nid" />
                    <x-info label="رقم الجواز" :value="$fuelStation->supervisor_passport" />
                    @if($fuelStation->supervisor_photo)
                        <div class="mt-4">
                            <p class="text-gray-600 mb-2">📷 صورة المشرف:</p>
                            <img src="{{ asset('storage/'.$fuelStation->supervisor_photo) }}" class="h-40 w-40 rounded-lg border">
                        </div>
                    @endif
                </x-section>

                {{-- ⚙️ بيانات التشغيل والتفاصيل --}}
                @if($fuelStation->details)
                    <x-section title="بيانات التشغيل والتفاصيل" color="red">
                        <x-info label="نوع الوقود" :value="$fuelStation->details->fuel_type ?? '-'" />
                        <x-info label="كمية الوقود" :value="$fuelStation->details->fuel_quantity ?? '-'" />
                        <x-info label="عدد الخزانات" :value="$fuelStation->details->tank_count ?? '-'" />
                        <x-info label="عداد قبل" :value="$fuelStation->details->meter_before ?? '-'" />
                        <x-info label="عداد بعد" :value="$fuelStation->details->meter_after ?? '-'" />
                        <x-info label="أيام التزويد" :value="$fuelStation->details->supply_days ?? '-'" />

                        <x-info label="رقم عقد المحطة" :value="$fuelStation->details->station_contract ?? '-'" />
                        <x-info label="حالة العقد" :value="$fuelStation->details->station_contract_status ?? '-'" />
                        <x-info label="رقم الترخيص" :value="$fuelStation->details->license ?? '-'" />
                        <x-info label="حالة الترخيص" :value="$fuelStation->details->license_status ?? '-'" />

                        {{-- ✅ هنا تم التأكد من عرض عدد العمالة --}}
                        <x-info label="عدد العمالة" :value="$fuelStation->details->number_of_workers ?? 'غير محدد'" />
                        <x-info label="الشهادة الصحية" :value="$fuelStation->details->workers_health_status ?? '-'" />

                        <x-info label="تاريخ آخر معايرة" :value="$fuelStation->details->last_calibration ?? '-'" />
                        <x-info label="تاريخ آخر تفتيش" :value="$fuelStation->details->last_inspection ?? '-'" />

                        {{-- أعمدة من نوع Boolean --}}
                        <x-info label="معدات الإطفاء" :value="$fuelStation->details->fire_equipment ? '✔ متوفر' : '✘ غير متوفر'" />
                        <x-info label="اللوحات الإرشادية" :value="$fuelStation->details->signs ? '✔' : '✘'" />
                        <x-info label="الإضاءة" :value="$fuelStation->details->lighting ? '✔' : '✘'" />
                        <x-info label="الأرضية" :value="$fuelStation->details->flooring ? '✔' : '✘'" />
                        <x-info label="المواد الكهربائية" :value="$fuelStation->details->electrical_materials ? '✔' : '✘'" />
                        <x-info label="الكاميرات" :value="$fuelStation->details->cameras ? '✔' : '✘'" />
                        <x-info label="النظافة" :value="$fuelStation->details->cleanliness ? '✔' : '✘'" />
                    </x-section>
                @endif

                {{-- 📄 المستندات --}}
                @if($fuelStation->documents->count() > 0)
                    <x-section title="المستندات" color="gray">
                        <table class="min-w-full border border-gray-300 rounded-lg text-sm text-center">
                            <thead class="bg-gray-100 text-gray-700">
                                <tr>
                                    <th class="px-4 py-2">نوع المستند</th>
                                    <th class="px-4 py-2">تاريخ الانتهاء</th>
                                    <th class="px-4 py-2">الحالة</th>
                                    <th class="px-4 py-2">الملاحظات</th>
                                    <th class="px-4 py-2">عرض</th>
                                    <th class="px-4 py-2">تحميل</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($fuelStation->documents as $doc)
                                    <tr class="border-t hover:bg-gray-50">
                                        <td class="px-4 py-2">{{ $doc->document_type ?? '-' }}</td>
                                        <td class="px-4 py-2">{{ $doc->expiry_date?->format('Y-m-d') ?? '-' }}</td>
                                        <td class="px-4 py-2">{{ $doc->document_status ?? '-' }}</td>
                                        <td class="px-4 py-2">{{ $doc->notes ?? '-' }}</td>

                                        {{-- 🆕 عرض المستند: يستخدم المسار الجديد والعمود الصحيح --}}
                                        <td class="px-4 py-2">
                                            @if($doc->document_file) {{-- 🚨 تم التعديل هنا: استخدام $doc->document_file --}}
                                                <a href="{{ route('fuel_stations.documents.view', ['fuel_station' => $fuelStation->id, 'document' => $doc->id]) }}"
                                                   target="_blank" class="text-blue-600 hover:underline">
                                                    عرض
                                                </a>
                                            @else
                                                <span class="text-gray-400">لا يوجد</span>
                                            @endif
                                        </td>

                                       {{-- 🆕 تحميل المستند: يستخدم المسار الجديد والعمود الصحيح --}}
                                        <td class="px-4 py-2">
                                            @if($doc->document_file) {{-- 🚨 تم التعديل هنا: استخدام $doc->document_file --}}
                                                <a href="{{ route('fuel_stations.documents.download', ['fuel_station' => $fuelStation->id, 'document' => $doc->id]) }}"
                                                   class="text-green-600 hover:underline">
                                                    تحميل
                                                </a>
                                            @else
                                                <span class="text-gray-400">-</span>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </x-section>
                @endif

                {{-- 🔘 أزرار التحكم --}}
                <div class="mt-10 flex justify-center space-x-3 space-x-reverse">
                    <a href="{{ route('fuel_stations.index') }}"
                       class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-md shadow">رجوع للقائمة</a>

                    <a href="{{ route('fuel_stations.edit', $fuelStation->id) }}"
                       class="bg-yellow-500 hover:bg-yellow-600 text-white px-4 py-2 rounded-md shadow">تعديل</a>

                    <form action="{{ route('fuel_stations.destroy', $fuelStation->id) }}" method="POST" class="inline"
                          onsubmit="return confirm('هل أنت متأكد من حذف هذه المحطة؟');">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                                class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-md shadow">حذف</button>
                    </form>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>