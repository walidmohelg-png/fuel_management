<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            تعديل محطة الوقود: {{ $fuelStation->station_name }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">

                <div class="p-6 bg-white border-b border-gray-200">
                    {{-- التبويبات --}}
                    <ul class="flex border-b mb-4" id="tabs">
                        <li class="-mb-px mr-1">
                            <a class="bg-white inline-block border-l border-t border-r rounded-t py-2 px-4 text-blue-700 font-semibold"
                               href="#tab-basic">البيانات الأساسية</a>
                        </li>
                        <li class="mr-1">
                            <a class="bg-white inline-block py-2 px-4 text-blue-500 hover:text-blue-800 font-semibold"
                               href="#tab-owner-supervisor">المالك والمشرف</a>
                        </li>
                        <li class="mr-1">
                            <a class="bg-white inline-block py-2 px-4 text-blue-500 hover:text-blue-800 font-semibold"
                               href="#tab-details">بيانات التشغيل</a>
                        </li>
                        <li class="mr-1">
                            <a class="bg-white inline-block py-2 px-4 text-blue-500 hover:text-blue-800 font-semibold"
                               href="#tab-documents">الوثائق والعمالة</a>
                        </li>
                    </ul>

                    <form action="{{ route('fuel_stations.update', $fuelStation->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        {{-- تبويب البيانات الأساسية --}}
                        <div id="tab-basic" class="tab-content">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <x-label for="station_name" value="اسم المحطة" />
                                    <x-input id="station_name" name="station_name" type="text" class="mt-1 block w-full"
                                        value="{{ old('station_name', $fuelStation->station_name) }}" required />
                                </div>

                                <div>
                                    <x-label for="station_number" value="رقم المحطة" />
                                    <x-input id="station_number" name="station_number" type="text" class="mt-1 block w-full"
                                        value="{{ old('station_number', $fuelStation->station_number) }}" required />
                                </div>

                                <div>
                                    <x-label for="city" value="المدينة" />
                                    <select id="city" name="city" class="form-select mt-1 block w-full">
                                        <option value="">{{ __('اختر المدينة') }}</option>
                                        @foreach($cities as $cityName)
                                            <option value="{{ $cityName }}" {{ (old('city', $fuelStation->city) == $cityName) ? 'selected' : '' }}>
                                                {{ $cityName }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div>
                                    <x-label for="region" value="المنطقة" />
                                    <select id="region" name="region" class="form-select mt-1 block w-full">
                                        <option value="">{{ __('اختر المنطقة') }}</option>
                                        @foreach($regions as $regionName)
                                            <option value="{{ $regionName }}" {{ (old('region', $fuelStation->region) == $regionName) ? 'selected' : '' }}>
                                                {{ $regionName }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-span-2">
                                    <x-label for="address" value="العنوان" />
                                    <x-input id="address" name="address" type="text" class="mt-1 block w-full"
                                        value="{{ old('address', $fuelStation->address) }}" />
                                </div>

                                <div>
                                    <x-label for="latitude" value="خط العرض (Latitude)" />
                                    <x-input id="latitude" name="latitude" type="text" class="mt-1 block w-full"
                                        value="{{ old('latitude', $fuelStation->latitude) }}" />
                                </div>

                                <div>
                                    <x-label for="longitude" value="خط الطول (Longitude)" />
                                    <x-input id="longitude" name="longitude" type="text" class="mt-1 block w-full"
                                        value="{{ old('longitude', $fuelStation->longitude) }}" />
                                </div>

                                <div class="col-span-2">
                                    <x-label for="distributor_id" value="شركة التوزيع" />
                                    <select id="distributor_id" name="distributor_id" class="form-select mt-1 block w-full" required>
                                        <option value="">{{ __('اختر شركة التوزيع') }}</option>
                                        @foreach($distributors as $distributor)
                                            <option value="{{ $distributor->id }}" {{ (old('distributor_id', $fuelStation->distributor_id) == $distributor->id) ? 'selected' : '' }}>
                                                {{ $distributor->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>

                        {{-- تبويب بيانات المالك والمشرف --}}
                        <div id="tab-owner-supervisor" class="tab-content hidden">
                            <h3 class="text-xl font-semibold text-gray-900 mb-6">{{ __('بيانات المالك') }}</h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-8">
                                <div>
                                    <x-label for="owner_name" value="اسم المالك" />
                                    <x-input id="owner_name" name="owner_name" type="text" class="mt-1 block w-full"
                                        value="{{ old('owner_name', $fuelStation->owner_name) }}" required />
                                </div>
                                <div>
                                    <x-label for="owner_phone" value="رقم هاتف المالك" />
                                    <x-input id="owner_phone" name="owner_phone" type="text" class="mt-1 block w-full"
                                        value="{{ old('owner_phone', $fuelStation->owner_phone) }}" required />
                                </div>
                                <div>
                                    <x-label for="owner_nid" value="الرقم الوطني للمالك" />
                                    <x-input id="owner_nid" name="owner_nid" type="text" class="mt-1 block w-full"
                                        value="{{ old('owner_nid', $fuelStation->owner_nid) }}" />
                                </div>
                                <div>
                                    <x-label for="owner_passport" value="رقم جواز سفر المالك (اختياري)" />
                                    <x-input id="owner_passport" name="owner_passport" type="text" class="mt-1 block w-full"
                                        value="{{ old('owner_passport', $fuelStation->owner_passport) }}" />
                                </div>
                                <div class="col-span-2">
                                    <x-label for="owner_photo" value="صورة المالك" />
                                    <input type="file" name="owner_photo" id="owner_photo" class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                                    @if($fuelStation->owner_photo)
                                        <div class="mt-2">
                                            <p class="text-xs text-gray-500 mb-1">{{ __('الصورة الحالية:') }}</p>
                                            <img src="{{ asset('storage/'.$fuelStation->owner_photo) }}" alt="صورة المالك" class="w-24 h-24 object-cover rounded-md">
                                        </div>
                                    @endif
                                </div>
                            </div>

                            <h3 class="text-xl font-semibold text-gray-900 mb-6 mt-8">{{ __('بيانات المشرف') }}</h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <x-label for="supervisor_name" value="اسم المشرف" />
                                    <x-input id="supervisor_name" name="supervisor_name" type="text" class="mt-1 block w-full"
                                        value="{{ old('supervisor_name', $fuelStation->supervisor_name) }}" />
                                </div>
                                <div>
                                    <x-label for="supervisor_phone" value="رقم هاتف المشرف" />
                                    <x-input id="supervisor_phone" name="supervisor_phone" type="text" class="mt-1 block w-full"
                                        value="{{ old('supervisor_phone', $fuelStation->supervisor_phone) }}" />
                                </div>
                                <div>
                                    <x-label for="supervisor_nid" value="الرقم الوطني للمشرف" />
                                    <x-input id="supervisor_nid" name="supervisor_nid" type="text" class="mt-1 block w-full"
                                        value="{{ old('supervisor_nid', $fuelStation->supervisor_nid) }}" />
                                </div>
                                <div>
                                    <x-label for="supervisor_passport" value="رقم جواز سفر المشرف (اختياري)" />
                                    <x-input id="supervisor_passport" name="supervisor_passport" type="text" class="mt-1 block w-full"
                                        value="{{ old('supervisor_passport', $fuelStation->supervisor_passport) }}" />
                                </div>
                                <div class="col-span-2">
                                    <x-label for="supervisor_photo" value="صورة المشرف" />
                                    <input type="file" name="supervisor_photo" id="supervisor_photo" class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                                    @if($fuelStation->supervisor_photo)
                                        <div class="mt-2">
                                            <p class="text-xs text-gray-500 mb-1">{{ __('الصورة الحالية:') }}</p>
                                            <img src="{{ asset('storage/'.$fuelStation->supervisor_photo) }}" alt="صورة المشرف" class="w-24 h-24 object-cover rounded-md">
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>

                        {{-- تبويب بيانات التشغيل --}}
                        <div id="tab-details" class="tab-content hidden">
                            <h3 class="text-xl font-semibold text-gray-900 mb-6">{{ __('بيانات التشغيل') }}</h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <x-label for="fuel_type" value="نوع الوقود" />
                                    <x-input id="fuel_type" name="fuel_type" type="text" class="mt-1 block w-full"
                                        value="{{ old('fuel_type', $fuelStation->details->fuel_type ?? '') }}" />
                                </div>
                                <div>
                                    <x-label for="fuel_quantity" value="كمية الوقود" />
                                    <x-input id="fuel_quantity" name="fuel_quantity" type="text" class="mt-1 block w-full"
                                        value="{{ old('fuel_quantity', $fuelStation->details->fuel_quantity ?? '') }}" />
                                </div>
                                <div>
                                    <x-label for="tank_count" value="عدد الخزانات" />
                                    <x-input id="tank_count" name="tank_count" type="number" class="mt-1 block w-full"
                                        value="{{ old('tank_count', $fuelStation->details->tank_count ?? '') }}" />
                                </div>
                                <div>
                                    <x-label for="meter_before" value="عداد قبل التعبئة" />
                                    <x-input id="meter_before" name="meter_before" type="text" class="mt-1 block w-full"
                                        value="{{ old('meter_before', $fuelStation->details->meter_before ?? '') }}" />
                                </div>
                                <div>
                                    <x-label for="meter_after" value="عداد بعد التعبئة" />
                                    <x-input id="meter_after" name="meter_after" type="text" class="mt-1 block w-full"
                                        value="{{ old('meter_after', $fuelStation->details->meter_after ?? '') }}" />
                                </div>
                                <div>
                                    <x-label for="supply_days" value="أيام التزويد" />
                                    <x-input id="supply_days" name="supply_days" type="text" class="mt-1 block w-full"
                                        value="{{ old('supply_days', $fuelStation->details->supply_days ?? '') }}" />
                                </div>

                                {{-- حقول البوليان --}}
                                <div class="col-span-2 grid grid-cols-1 md:grid-cols-3 gap-4 mt-4">
                                    <div>
                                        <label for="fire_equipment" class="inline-flex items-center">
                                            <input id="fire_equipment" name="fire_equipment" type="checkbox" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" value="1"
                                                {{ (old('fire_equipment', $fuelStation->details->fire_equipment ?? false)) ? 'checked' : '' }}>
                                            <span class="ml-2 text-sm text-gray-600">{{ __('معدات إطفاء') }}</span>
                                        </label>
                                    </div>
                                    <div>
                                        <label for="signs" class="inline-flex items-center">
                                            <input id="signs" name="signs" type="checkbox" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" value="1"
                                                {{ (old('signs', $fuelStation->details->signs ?? false)) ? 'checked' : '' }}>
                                            <span class="ml-2 text-sm text-gray-600">{{ __('لوحات إرشادية') }}</span>
                                        </label>
                                    </div>
                                    <div>
                                        <label for="lighting" class="inline-flex items-center">
                                            <input id="lighting" name="lighting" type="checkbox" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" value="1"
                                                {{ (old('lighting', $fuelStation->details->lighting ?? false)) ? 'checked' : '' }}>
                                            <span class="ml-2 text-sm text-gray-600">{{ __('إضاءة') }}</span>
                                        </label>
                                    </div>
                                    <div>
                                        <label for="flooring" class="inline-flex items-center">
                                            <input id="flooring" name="flooring" type="checkbox" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" value="1"
                                                {{ (old('flooring', $fuelStation->details->flooring ?? false)) ? 'checked' : '' }}>
                                            <span class="ml-2 text-sm text-gray-600">{{ __('أرضيات مناسبة') }}</span>
                                        </label>
                                    </div>
                                    <div>
                                        <label for="electrical_materials" class="inline-flex items-center">
                                            <input id="electrical_materials" name="electrical_materials" type="checkbox" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" value="1"
                                                {{ (old('electrical_materials', $fuelStation->details->electrical_materials ?? false)) ? 'checked' : '' }}>
                                            <span class="ml-2 text-sm text-gray-600">{{ __('مواد كهربائية آمنة') }}</span>
                                        </label>
                                    </div>
                                    <div>
                                        <label for="cameras" class="inline-flex items-center">
                                            <input id="cameras" name="cameras" type="checkbox" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" value="1"
                                                {{ (old('cameras', $fuelStation->details->cameras ?? false)) ? 'checked' : '' }}>
                                            <span class="ml-2 text-sm text-gray-600">{{ __('كاميرات مراقبة') }}</span>
                                        </label>
                                    </div>
                                    <div>
                                        <label for="cleanliness" class="inline-flex items-center">
                                            <input id="cleanliness" name="cleanliness" type="checkbox" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" value="1"
                                                {{ (old('cleanliness', $fuelStation->details->cleanliness ?? false)) ? 'checked' : '' }}>
                                            <span class="ml-2 text-sm text-gray-600">{{ __('النظافة العامة') }}</span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- تبويب الوثائق والعمالة --}}
                        <div id="tab-documents" class="tab-content hidden">
                            <h3 class="text-xl font-semibold text-gray-900 mb-6">{{ __('بيانات العقد والترخيص') }}</h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <x-label for="station_contract" value="رقم عقد المحطة" />
                                    <x-input id="station_contract" name="station_contract" type="text" class="mt-1 block w-full"
                                        value="{{ old('station_contract', $fuelStation->details->station_contract ?? '') }}" />
                                </div>
                                <div>
                                    <x-label for="station_contract_status" value="حالة العقد" />
                                    <select id="station_contract_status" name="station_contract_status" class="form-select mt-1 block w-full">
                                        @php $contractStatuses = ['ساري', 'منتهي', 'ملغي', 'لا يوجد']; @endphp
                                        <option value="">{{ __('اختر حالة العقد') }}</option>
                                        @foreach($contractStatuses as $status)
                                            <option value="{{ $status }}" {{ (old('station_contract_status', $fuelStation->details->station_contract_status ?? '') == $status) ? 'selected' : '' }}>
                                                {{ __($status) }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div>
                                    <x-label for="license" value="رقم الترخيص" />
                                    <x-input id="license" name="license" type="text" class="mt-1 block w-full"
                                        value="{{ old('license', $fuelStation->details->license ?? '') }}" />
                                </div>
                                <div>
                                    <x-label for="license_status" value="حالة الترخيص" />
                                    <select id="license_status" name="license_status" class="form-select mt-1 block w-full">
                                        @php $licenseStatuses = ['صالح', 'غير صالح', 'معلق', 'لا يوجد']; @endphp
                                        <option value="">{{ __('اختر حالة الترخيص') }}</option>
                                        @foreach($licenseStatuses as $status)
                                            <option value="{{ $status }}" {{ (old('license_status', $fuelStation->details->license_status ?? '') == $status) ? 'selected' : '' }}>
                                                {{ __($status) }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-span-2">
                                    <x-label for="last_calibration" value="تاريخ آخر معايرة" />
                                    <x-input id="last_calibration" name="last_calibration" type="date" class="mt-1 block w-full"
                                        value="{{ old('last_calibration', $fuelStation->details->last_calibration ? \Carbon\Carbon::parse($fuelStation->details->last_calibration)->format('Y-m-d') : '') }}" />
                                </div>
                                <div class="col-span-2">
                                    <x-label for="last_inspection" value="تاريخ آخر تفتيش" />
                                    <x-input id="last_inspection" name="last_inspection" type="date" class="mt-1 block w-full"
                                        value="{{ old('last_inspection', $fuelStation->details->last_inspection ? \Carbon\Carbon::parse($fuelStation->details->last_inspection)->format('Y-m-d') : '') }}" />
                                </div>
                            </div>

                            <h3 class="text-xl font-semibold text-gray-900 mb-6 mt-8">{{ __('بيانات العمالة') }}</h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <x-label for="number_of_workers" value="عدد العمالة" />
                                    <x-input id="number_of_workers" name="number_of_workers" type="number" class="mt-1 block w-full"
                                        value="{{ old('number_of_workers', $fuelStation->details->number_of_workers ?? '') }}" />
                                </div>
                                <div>
                                    <x-label for="workers_health_status" value="حالة الشهادة الصحية" />
                                    <select id="workers_health_status" name="workers_health_status" class="form-select mt-1 block w-full">
                                        @php $healthStatuses = ['موجودة', 'غير موجودة', 'منتهية', 'غير محدد']; @endphp
                                        <option value="">{{ __('اختر الحالة') }}</option>
                                        @foreach($healthStatuses as $status)
                                            <option value="{{ $status }}" {{ (old('workers_health_status', $fuelStation->details->workers_health_status ?? '') == $status) ? 'selected' : '' }}>
                                                {{ __($status) }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            {{-- قسم المستندات (من جدول fuel_station_documents) --}}
                            <h3 class="text-xl font-semibold text-gray-900 mb-6 mt-8">{{ __('مستندات المحطة') }}</h3>
                            <div class="space-y-6">
                                @forelse($fuelStation->documents as $index => $doc)
                                    <div class="border p-4 rounded-lg bg-gray-50 grid grid-cols-1 md:grid-cols-2 gap-4">
                                        <h4 class="col-span-2 text-lg font-semibold text-gray-800 mb-2">{{ __('المستند رقم ') . ($index + 1) }}</h4>
                                        <div>
                                            <x-label for="documents_{{ $index }}_document_type" value="نوع المستند" />
                                            <x-input id="documents_{{ $index }}_document_type" name="documents[{{ $index }}][document_type]" type="text" class="mt-1 block w-full"
                                                value="{{ old('documents.'.$index.'.document_type', $doc->document_type ?? '') }}" />
                                        </div>
                                        <div>
                                            <x-label for="documents_{{ $index }}_document_number" value="رقم المستند" />
                                            <x-input id="documents_{{ $index }}_document_number" name="documents[{{ $index }}][document_number]" type="text" class="mt-1 block w-full"
                                                value="{{ old('documents.'.$index.'.document_number', $doc->document_number ?? '') }}" />
                                        </div>
                                        <div>
                                            <x-label for="documents_{{ $index }}_expiry_date" value="تاريخ الانتهاء" />
                                            <x-input id="documents_{{ $index }}_expiry_date" name="documents[{{ $index }}][expiry_date]" type="date" class="mt-1 block w-full"
                                                value="{{ old('documents.'.$index.'.expiry_date', $doc->expiry_date ? \Carbon\Carbon::parse($doc->expiry_date)->format('Y-m-d') : '') }}" />
                                        </div>
                                        <div>
                                            <x-label for="documents_{{ $index }}_document_status" value="حالة المستند" />
                                            <select id="documents_{{ $index }}_document_status" name="documents[{{ $index }}][document_status]" class="form-select mt-1 block w-full">
                                                @php $docStatuses = ['ساري', 'منتهي', 'غير مستوفي', 'لا يوجد']; @endphp
                                                @foreach($docStatuses as $status)
                                                    <option value="{{ $status }}" {{ (old('documents.'.$index.'.document_status', $doc->document_status ?? '') == $status) ? 'selected' : '' }}>
                                                        {{ __($status) }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-span-2">
                                            <x-label for="documents_{{ $index }}_notes" value="ملاحظات" />
                                            <textarea id="documents_{{ $index }}_notes" name="documents[{{ $index }}][notes]" rows="2" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3">{{ old('documents.'.$index.'.notes', $doc->notes ?? '') }}</textarea>
                                        </div>
                                        <div class="col-span-2">
                                            <x-label for="documents_{{ $index }}_file" value="ملف الوثيقة" />
                                            <input type="file" name="documents[{{ $index }}][file]" id="documents_{{ $index }}_file" class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                                            @if($doc->file_path)
                                                <div class="mt-2">
                                                    <p class="text-xs text-gray-500 mb-1">{{ __('الملف الحالي:') }}</p>
                                                    <a href="{{ asset('storage/'.$doc->file_path) }}" target="_blank" class="text-blue-600 hover:underline">
                                                        {{ __('عرض الملف') }}
                                                    </a>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                @empty
                                    <p class="text-gray-500">{{ __('لا توجد مستندات لهذه المحطة.') }}</p>
                                @endforelse
                                {{-- يمكنك إضافة زر لإضافة مستند جديد هنا إذا كنت تدعم ذلك ديناميكياً --}}
                                {{-- <button type="button" class="bg-indigo-500 text-white px-4 py-2 rounded-md mt-4">إضافة مستند جديد</button> --}}
                            </div>
                        </div>


                        {{-- أزرار الحفظ --}}
                        <div class="mt-6 flex justify-end space-x-2 space-x-reverse">
                            <x-button class="bg-blue-600 text-white">💾 حفظ التعديلات</x-button>
                            <a href="{{ route('fuel_stations.index') }}" class="bg-gray-300 text-gray-800 px-4 py-2 rounded-lg">إلغاء</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{-- JavaScript بسيط للتبديل بين التبويبات --}}
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const tabs = document.querySelectorAll('#tabs a');
            const tabContents = document.querySelectorAll('.tab-content');

            function showTab(tabId) {
                tabContents.forEach(content => {
                    content.classList.add('hidden');
                });
                document.querySelector(tabId).classList.remove('hidden');

                tabs.forEach(tab => {
                    tab.classList.remove('border-l', 'border-t', 'border-r', 'rounded-t', 'text-blue-700');
                    tab.classList.add('text-blue-500', 'hover:text-blue-800', 'border-transparent', 'hover:border-gray-300');
                });

                const activeTab = document.querySelector(`a[href="${tabId}"]`);
                if (activeTab) {
                    activeTab.classList.add('border-l', 'border-t', 'border-r', 'rounded-t', 'text-blue-700');
                    activeTab.classList.remove('text-blue-500', 'hover:text-blue-800', 'border-transparent', 'hover:border-gray-300');
                }
            }

            tabs.forEach(tab => {
                tab.addEventListener('click', function (e) {
                    e.preventDefault();
                    showTab(this.getAttribute('href'));
                });
            });

            // إظهار التبويب الأول عند التحميل الافتراضي
            showTab(tabs[0].getAttribute('href'));
        });
    </script>
</x-app-layout>