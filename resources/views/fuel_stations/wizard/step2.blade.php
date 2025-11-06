<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('إضافة محطة وقود جديدة - الخطوة 2/3') }}
        </h2>
    </x-slot>

    <div class="py-10">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-md sm:rounded-lg p-6">

                <h3 class="text-lg font-semibold text-gray-900 mb-4">{{ __('تفاصيل التشغيل والموظفين') }}</h3>

                <form action="{{ route('fuel_stations.create.storeStep2', ['fuelStation' => $fuelStation->id]) }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <h4 class="text-md font-semibold text-gray-800 mb-4">{{ __('بيانات المشرف') }}</h4>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        {{-- اسم المشرف --}}
                        <div>
                            <label for="supervisor_name" class="block text-sm font-medium text-gray-700">{{ __('اسم المشرف') }}</label>
                            <input type="text" name="supervisor_name" id="supervisor_name"
                                   value="{{ old('supervisor_name', $fuelStation->supervisor_name ?? '') }}"
                                   class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm @error('supervisor_name') border-red-500 @enderror">
                            @error('supervisor_name')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- هاتف المشرف --}}
                        <div>
                            <label for="supervisor_phone" class="block text-sm font-medium text-gray-700">{{ __('رقم هاتف المشرف') }}</label>
                            <input type="text" name="supervisor_phone" id="supervisor_phone"
                                   value="{{ old('supervisor_phone', $fuelStation->supervisor_phone ?? '') }}"
                                   class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm @error('supervisor_phone') border-red-500 @enderror">
                            @error('supervisor_phone')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- رقم الهوية الوطنية للمشرف --}}
                        <div>
                            <label for="supervisor_nid" class="block text-sm font-medium text-gray-700">{{ __('رقم الهوية الوطنية للمشرف') }}</label>
                            <input type="text" name="supervisor_nid" id="supervisor_nid"
                                   value="{{ old('supervisor_nid', $fuelStation->supervisor_nid ?? '') }}"
                                   class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm @error('supervisor_nid') border-red-500 @enderror">
                            @error('supervisor_nid')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- رقم جواز سفر المشرف --}}
                        <div>
                            <label for="supervisor_passport" class="block text-sm font-medium text-gray-700">{{ __('رقم جواز سفر المشرف (اختياري)') }}</label>
                            <input type="text" name="supervisor_passport" id="supervisor_passport"
                                   value="{{ old('supervisor_passport', $fuelStation->supervisor_passport ?? '') }}"
                                   class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm @error('supervisor_passport') border-red-500 @enderror">
                            @error('supervisor_passport')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- صورة المشرف --}}
                        <div class="md:col-span-2">
                            <label for="supervisor_photo" class="block text-sm font-medium text-gray-700">{{ __('صورة المشرف') }}</label>
                            <input type="file" name="supervisor_photo" id="supervisor_photo"
                                   class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 @error('supervisor_photo') border-red-500 @enderror">
                            @error('supervisor_photo')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                            @if(isset($fuelStation) && $fuelStation->supervisor_photo)
                                <div class="mt-2">
                                    <img src="{{ asset('storage/' . $fuelStation->supervisor_photo) }}" alt="صورة المشرف" class="w-24 h-24 object-cover rounded-md">
                                    <p class="text-xs text-gray-500 mt-1">{{ __('الصورة الحالية') }}</p>
                                </div>
                            @endif
                        </div>
                    </div>

                    <h4 class="text-md font-semibold text-gray-800 mb-4 mt-6">{{ __('تفاصيل التشغيل والسلامة') }}</h4>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        {{-- نوع الوقود --}}
                        <div>
                            <label for="fuel_type" class="block text-sm font-medium text-gray-700">{{ __('نوع الوقود') }}</label>
                            <input type="text" name="fuel_type" id="fuel_type"
                                   value="{{ old('fuel_type', $fuelStationDetail->fuel_type ?? '') }}"
                                   class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm @error('fuel_type') border-red-500 @enderror">
                            @error('fuel_type')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- كمية الوقود --}}
                        <div>
                            <label for="fuel_quantity" class="block text-sm font-medium text-gray-700">{{ __('كمية الوقود') }}</label>
                            <input type="number" step="0.01" name="fuel_quantity" id="fuel_quantity"
                                   value="{{ old('fuel_quantity', $fuelStationDetail->fuel_quantity ?? '') }}"
                                   class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm @error('fuel_quantity') border-red-500 @enderror">
                            @error('fuel_quantity')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- عدد الخزانات --}}
                        <div>
                            <label for="tank_count" class="block text-sm font-medium text-gray-700">{{ __('عدد الخزانات') }}</label>
                            <input type="number" name="tank_count" id="tank_count"
                                   value="{{ old('tank_count', $fuelStationDetail->tank_count ?? '') }}"
                                   class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm @error('tank_count') border-red-500 @enderror">
                            @error('tank_count')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- قراءة العداد قبل --}}
                        <div>
                            <label for="meter_before" class="block text-sm font-medium text-gray-700">{{ __('قراءة العداد قبل التعبئة') }}</label>
                            <input type="number" step="0.01" name="meter_before" id="meter_before"
                                   value="{{ old('meter_before', $fuelStationDetail->meter_before ?? '') }}"
                                   class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm @error('meter_before') border-red-500 @enderror">
                            @error('meter_before')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- قراءة العداد بعد --}}
                        <div>
                            <label for="meter_after" class="block text-sm font-medium text-gray-700">{{ __('قراءة العداد بعد التعبئة') }}</label>
                            <input type="number" step="0.01" name="meter_after" id="meter_after"
                                   value="{{ old('meter_after', $fuelStationDetail->meter_after ?? '') }}"
                                   class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm @error('meter_after') border-red-500 @enderror">
                            @error('meter_after')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- ✅ أيام التزويد - قائمة منسدلة --}}
                        <div>
                            <label for="supply_days_option" class="block text-sm font-medium text-gray-700">{{ __('أيام التزويد') }}</label>
                            <select name="supply_days_option" id="supply_days_option"
                                    class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm @error('supply_days_option') border-red-500 @enderror">
                                @php
                                    $supplyOptions = ['يومياً', 'يوم بعد يوم', 'يوم واحد في الأسبوع', 'يومان في الأسبوع'];
                                    $currentSupply = old('supply_days_option', $fuelStationDetail->supply_days ?? '');
                                @endphp
                                <option value="">{{ __('اختر خيار التزويد') }}</option>
                                @foreach($supplyOptions as $option)
                                    <option value="{{ $option }}" {{ $currentSupply == $option ? 'selected' : '' }}>{{ __($option) }}</option>
                                @endforeach
                            </select>
                            @error('supply_days_option')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>


                        {{-- تجهيزات السلامة (خانة اختيار لكل منها) --}}
                        <div class="md:col-span-2 grid grid-cols-2 sm:grid-cols-3 gap-4 mt-4">
                            @php
                                $safety_features = [
                                    'fire_equipment' => 'معدات إطفاء',
                                    'signs' => 'لوحات إرشادية',
                                    'lighting' => 'إضاءة كافية',
                                    'flooring' => 'أرضيات مناسبة',
                                    'electrical_materials' => 'مواد كهربائية آمنة',
                                    'cameras' => 'كاميرات مراقبة',
                                    'cleanliness' => 'النظافة العامة',
                                ];
                            @endphp
                            @foreach($safety_features as $field => $label)
                                <div class="flex items-center">
                                    <input type="hidden" name="{{ $field }}" value="0"> {{-- Hidden field for unchecked checkbox --}}
                                    <input type="checkbox" name="{{ $field }}" id="{{ $field }}" value="1"
                                           class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded"
                                           {{ (old($field, $fuelStationDetail->$field ?? false)) ? 'checked' : '' }}>
                                    <label for="{{ $field }}" class="ml-2 block text-sm text-gray-900">{{ __($label) }}</label>
                                </div>
                            @endforeach
                        </div>

                        {{-- ✅ العقد - رقم العقد وحالته --}}
                        <div>
                            <label for="station_contract_number" class="block text-sm font-medium text-gray-700">{{ __('رقم العقد') }}</label>
                            <input type="text" name="station_contract_number" id="station_contract_number"
                                   value="{{ old('station_contract_number', $fuelStationDetail->station_contract ?? '') }}"
                                   class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm @error('station_contract_number') border-red-500 @enderror">
                            @error('station_contract_number')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label for="station_contract_status" class="block text-sm font-medium text-gray-700">{{ __('حالة العقد') }}</label>
                            <select name="station_contract_status" id="station_contract_status"
                                    class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm @error('station_contract_status') border-red-500 @enderror">
                                @php
                                    $contractStatuses = ['ساري', 'منتهي'];
                                    $currentContractStatus = old('station_contract_status', $fuelStationDetail->station_contract_status ?? '');
                                @endphp
                                <option value="">{{ __('اختر حالة العقد') }}</option>
                                @foreach($contractStatuses as $status)
                                    <option value="{{ $status }}" {{ $currentContractStatus == $status ? 'selected' : '' }}>{{ __($status) }}</option>
                                @endforeach
                            </select>
                            @error('station_contract_status')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- ✅ الترخيص - رقم الترخيص وحالته --}}
                        <div>
                            <label for="license_number" class="block text-sm font-medium text-gray-700">{{ __('رقم الترخيص') }}</label>
                            <input type="text" name="license_number" id="license_number"
                                   value="{{ old('license_number', $fuelStationDetail->license ?? '') }}"
                                   class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm @error('license_number') border-red-500 @enderror">
                            @error('license_number')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label for="license_status" class="block text-sm font-medium text-gray-700">{{ __('حالة الترخيص') }}</label>
                            <select name="license_status" id="license_status"
                                    class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm @error('license_status') border-red-500 @enderror">
                                @php
                                    $licenseStatuses = ['صالح', 'منتهي الصلاحية'];
                                    $currentLicenseStatus = old('license_status', $fuelStationDetail->license_status ?? '');
                                @endphp
                                <option value="">{{ __('اختر حالة الترخيص') }}</option>
                                @foreach($licenseStatuses as $status)
                                    <option value="{{ $status }}" {{ $currentLicenseStatus == $status ? 'selected' : '' }}>{{ __($status) }}</option>
                                @endforeach
                            </select>
                            @error('license_status')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>


                        {{-- تاريخ آخر معايرة --}}
                        <div>
                            <label for="last_calibration" class="block text-sm font-medium text-gray-700">{{ __('تاريخ آخر معايرة') }}</label>
                            <input type="date" name="last_calibration" id="last_calibration"
                                   value="{{ old('last_calibration', $fuelStationDetail->last_calibration ?? '') }}"
                                   class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm @error('last_calibration') border-red-500 @enderror">
                            @error('last_calibration')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- تاريخ آخر فحص --}}
                        <div>
                            <label for="last_inspection" class="block text-sm font-medium text-gray-700">{{ __('تاريخ آخر فحص') }}</label>
                            <input type="date" name="last_inspection" id="last_inspection"
                                   value="{{ old('last_inspection', $fuelStationDetail->last_inspection ?? '') }}"
                                   class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm @error('last_inspection') border-red-500 @enderror">
                            @error('last_inspection')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>


                    <div class="flex justify-between mt-8">
                        <a href="{{ route('fuel_stations.create.step1', ['fuelStation' => $fuelStation->id]) }}" {{-- ✅ تم تمرير id المحطة للرابط السابق --}}
                           class="bg-gray-400 hover:bg-gray-500 text-white font-bold py-2 px-4 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-300">
                            {{ __('السابق') }}
                        </a>
                        <button type="submit"
                                class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            {{ __('التالي') }}
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>