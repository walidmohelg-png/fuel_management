<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('إضافة محطة وقود جديدة - الخطوة 1/3') }}
        </h2>
    </x-slot>

    <div class="py-10">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-md sm:rounded-lg p-6">

                <h3 class="text-lg font-semibold text-gray-900 mb-4">{{ __('معلومات المحطة الأساسية والمالك') }}</h3>

                <form action="{{ route('fuel_stations.create.storeStep1') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    {{-- إذا كان هناك سجل حالي (لاستئناف العملية) --}}
                    @if(isset($fuelStation) && $fuelStation->id)
                        <input type="hidden" name="fuel_station_id" value="{{ $fuelStation->id }}">
                    @endif

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        {{-- شركة التوزيع --}}
                        <div>
                            <label for="distributor_id" class="block text-sm font-medium text-gray-700">{{ __('شركة التوزيع') }} <span class="text-red-500">*</span></label>
                            <select name="distributor_id" id="distributor_id"
                                    class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm @error('distributor_id') border-red-500 @enderror">
                                <option value="">{{ __('اختر شركة التوزيع') }}</option>
                                @foreach($distributors as $distributor)
                                    <option value="{{ $distributor->id }}"
                                            {{ (old('distributor_id', $fuelStation->distributor_id ?? '') == $distributor->id) ? 'selected' : '' }}>
                                        {{ $distributor->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('distributor_id')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- اسم المحطة --}}
                        <div>
                            <label for="station_name" class="block text-sm font-medium text-gray-700">{{ __('اسم المحطة') }} <span class="text-red-500">*</span></label>
                            <input type="text" name="station_name" id="station_name"
                                   value="{{ old('station_name', $fuelStation->station_name ?? '') }}"
                                   class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm @error('station_name') border-red-500 @enderror">
                            @error('station_name')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- رقم المحطة --}}
                        <div>
                            <label for="station_number" class="block text-sm font-medium text-gray-700">{{ __('رقم المحطة') }} <span class="text-red-500">*</span></label>
                            <input type="text" name="station_number" id="station_number"
                                   value="{{ old('station_number', $fuelStation->station_number ?? '') }}"
                                   class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm @error('station_number') border-red-500 @enderror">
                            @error('station_number')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- المدينة --}}
                        <div>
                            <label for="city" class="block text-sm font-medium text-gray-700">{{ __('المدينة') }} <span class="text-red-500">*</span></label>
                            <input type="text" name="city" id="city"
                                   value="{{ old('city', $fuelStation->city ?? '') }}"
                                   placeholder="{{ __('أدخل اسم المدينة') }}"
                                   class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm @error('city') border-red-500 @enderror">
                            @error('city')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- المنطقة --}}
                        <div>
                            <label for="region" class="block text-sm font-medium text-gray-700">{{ __('المنطقة') }}</label>
                            <input type="text" name="region" id="region"
                                   value="{{ old('region', $fuelStation->region ?? '') }}"
                                   placeholder="{{ __('أدخل اسم المنطقة') }}"
                                   class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm @error('region') border-red-500 @enderror">
                            @error('region')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- العنوان --}}
                        <div class="md:col-span-2">
                            <label for="address" class="block text-sm font-medium text-gray-700">{{ __('العنوان') }}</label>
                            <textarea name="address" id="address" rows="3"
                                      class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm @error('address') border-red-500 @enderror">{{ old('address', $fuelStation->address ?? '') }}</textarea>
                            @error('address')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- خط العرض --}}
                        <div>
                            <label for="latitude" class="block text-sm font-medium text-gray-700">{{ __('خط العرض (Latitude)') }}</label>
                            <input type="text" name="latitude" id="latitude"
                                   value="{{ old('latitude', $fuelStation->latitude ?? '') }}"
                                   class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm @error('latitude') border-red-500 @enderror">
                            @error('latitude')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- خط الطول --}}
                        <div>
                            <label for="longitude" class="block text-sm font-medium text-gray-700">{{ __('خط الطول (Longitude)') }}</label>
                            <input type="text" name="longitude" id="longitude"
                                   value="{{ old('longitude', $fuelStation->longitude ?? '') }}"
                                   class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm @error('longitude') border-red-500 @enderror">
                            @error('longitude')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <h4 class="text-md font-semibold text-gray-800 mb-4">{{ __('بيانات المالك') }}</h4>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        {{-- اسم المالك --}}
                        <div>
                            <label for="owner_name" class="block text-sm font-medium text-gray-700">{{ __('اسم المالك') }} <span class="text-red-500">*</span></label>
                            <input type="text" name="owner_name" id="owner_name"
                                   value="{{ old('owner_name', $fuelStation->owner_name ?? '') }}"
                                   class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm @error('owner_name') border-red-500 @enderror">
                            @error('owner_name')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- هاتف المالك --}}
                        <div>
                            <label for="owner_phone" class="block text-sm font-medium text-gray-700">{{ __('رقم هاتف المالك') }} <span class="text-red-500">*</span></label>
                            <input type="text" name="owner_phone" id="owner_phone"
                                   value="{{ old('owner_phone', $fuelStation->owner_phone ?? '') }}"
                                   class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm @error('owner_phone') border-red-500 @enderror">
                            @error('owner_phone')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- رقم الهوية الوطنية للمالك --}}
                        <div>
                            <label for="owner_nid" class="block text-sm font-medium text-gray-700">{{ __('رقم الهوية الوطنية للمالك') }}</label>
                            <input type="text" name="owner_nid" id="owner_nid"
                                   value="{{ old('owner_nid', $fuelStation->owner_nid ?? '') }}"
                                   class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm @error('owner_nid') border-red-500 @enderror">
                            @error('owner_nid')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- رقم جواز سفر المالك --}}
                        <div>
                            <label for="owner_passport" class="block text-sm font-medium text-gray-700">{{ __('رقم جواز سفر المالك (اختياري)') }}</label>
                            <input type="text" name="owner_passport" id="owner_passport"
                                   value="{{ old('owner_passport', $fuelStation->owner_passport ?? '') }}"
                                   class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm @error('owner_passport') border-red-500 @enderror">
                            @error('owner_passport')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- صورة المالك --}}
                        <div class="md:col-span-2">
                            <label for="owner_photo" class="block text-sm font-medium text-gray-700">{{ __('صورة المالك') }}</label>
                            <input type="file" name="owner_photo" id="owner_photo"
                                   class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 @error('owner_photo') border-red-500 @enderror">
                            @error('owner_photo')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                            @if(isset($fuelStation) && $fuelStation->owner_photo)
                                <div class="mt-2">
                                    <img src="{{ asset('storage/' . $fuelStation->owner_photo) }}" alt="صورة المالك" class="w-24 h-24 object-cover rounded-md">
                                    <p class="text-xs text-gray-500 mt-1">{{ __('الصورة الحالية') }}</p>
                                </div>
                            @endif
                        </div>
                    </div>

                    <div class="flex justify-end mt-8">
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