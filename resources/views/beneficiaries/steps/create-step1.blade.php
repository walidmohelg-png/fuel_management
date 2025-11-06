<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('إضافة شركة مستفيدة جديدة - الخطوة 1 من 3') }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">

                {{-- نموذج الخطوة الأولى --}}
                <form method="POST" action="{{ route('beneficiaries.store_step_1') }}">
                    @csrf

                    {{-- شركة التوزيع --}}
                    <div class="mt-4">
                        <x-input-label for="distributor_id" :value="__('شركة التوزيع')" />
                        <select id="distributor_id" name="distributor_id"
                            class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                            <option value="">{{ __('— اختر شركة التوزيع —') }}</option>
                            @foreach($distributors as $distributor)
                                <option value="{{ $distributor->id }}" {{ old('distributor_id') == $distributor->id ? 'selected' : '' }}>
                                    {{ $distributor->name }}
                                </option>
                            @endforeach
                        </select>
                        <x-input-error :messages="$errors->get('distributor_id')" class="mt-2" />
                    </div>

                    {{-- اسم الشركة --}}
                    <div class="mt-4">
                        <x-input-label for="name" :value="__('اسم الشركة المستفيدة')" />
                        <x-text-input id="name" class="block mt-1 w-full" type="text" name="name"
                            :value="old('name')" required />
                        <x-input-error :messages="$errors->get('name')" class="mt-2" />
                    </div>

                    {{-- نوع النشاط --}}
                    <div class="mt-4">
                        <x-input-label for="activity_type" :value="__('نوع النشاط')" />
                        <x-text-input id="activity_type" class="block mt-1 w-full" type="text" name="activity_type"
                            :value="old('activity_type')" required />
                        <x-input-error :messages="$errors->get('activity_type')" class="mt-2" />
                    </div>

                    {{-- رمز الوقود --}}
                    <div class="mt-4">
                        <x-input-label for="fuel_code" :value="__('رمز الوقود (اختياري)')" />
                        <x-text-input id="fuel_code" class="block mt-1 w-full" type="text" name="fuel_code"
                            :value="old('fuel_code')" />
                        <x-input-error :messages="$errors->get('fuel_code')" class="mt-2" />
                    </div>

                    {{-- المنطقة والمدينة --}}
                    <div class="flex space-x-4 space-x-reverse mt-4">
                        <div class="w-1/2">
                            <x-input-label for="region" :value="__('المنطقة')" />
                            <x-text-input id="region" class="block mt-1 w-full" type="text" name="region"
                                :value="old('region')" />
                            <x-input-error :messages="$errors->get('region')" class="mt-2" />
                        </div>
                        <div class="w-1/2">
                            <x-input-label for="city" :value="__('المدينة')" />
                            <x-text-input id="city" class="block mt-1 w-full" type="text" name="city"
                                :value="old('city')" />
                            <x-input-error :messages="$errors->get('city')" class="mt-2" />
                        </div>
                    </div>

                    {{-- العنوان --}}
                    <div class="mt-4">
                        <x-input-label for="address" :value="__('العنوان التفصيلي')" />
                        <textarea id="address" name="address"
                            class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">{{ old('address') }}</textarea>
                        <x-input-error :messages="$errors->get('address')" class="mt-2" />
                    </div>

                    {{-- الإحداثيات --}}
                    <div class="flex space-x-4 space-x-reverse mt-4">
                        <div class="w-1/2">
                            <x-input-label for="latitude" :value="__('خط العرض (Latitude)')" />
                            <x-text-input id="latitude" class="block mt-1 w-full" type="text" name="latitude"
                                :value="old('latitude')" />
                        </div>
                        <div class="w-1/2">
                            <x-input-label for="longitude" :value="__('خط الطول (Longitude)')" />
                            <x-text-input id="longitude" class="block mt-1 w-full" type="text" name="longitude"
                                :value="old('longitude')" />
                        </div>
                    </div>

                    {{-- حالة الشركة --}}
                    <div class="mt-4">
                        <x-input-label for="status" :value="__('الحالة الحالية')" />
                        <select id="status" name="status"
                            class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                            <option value="نشطة" {{ old('status') == 'نشطة' ? 'selected' : '' }}>نشطة</option>
                            <option value="غير_نشطة" {{ old('status') == 'غير_نشطة' ? 'selected' : '' }}>غير نشطة</option>
                            <option value="موثقة" {{ old('status') == 'موثقة' ? 'selected' : '' }}>موثقة</option>
                        </select>
                        <x-input-error :messages="$errors->get('status')" class="mt-2" />
                    </div>

                    {{-- الأزرار --}}
                    <div class="flex items-center justify-end mt-6">
                        <x-primary-button>
                            {{ __('التالي →') }}
                        </x-primary-button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>
