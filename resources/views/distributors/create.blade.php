<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('إضافة شركة توزيع جديدة') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                
                <form method="POST" action="{{ route('distributors.store') }}">
                    @csrf {{-- حماية CSRF إلزامية في Laravel --}}

                    {{-- ---------------------------------------------------- --}}
                    {{-- 1. قسم البيانات الأساسية لشركة التوزيع --}}
                    {{-- ---------------------------------------------------- --}}
                    <h3 class="text-lg font-bold text-gray-900 mb-4 border-b pb-2">{{ __('البيانات الأساسية لشركة التوزيع') }}</h3>
                    
                    {{-- اسم الشركة (مطلوب) --}}
                    <div class="mt-4">
                        <x-input-label for="name" :value="__('اسم شركة التوزيع')" />
                        <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus />
                        <x-input-error :messages="$errors->get('name')" class="mt-2" />
                    </div>

                    {{-- اسم مدير الشركة --}}
                    <div class="mt-4">
                        <x-input-label for="manager_name" :value="__('اسم مدير الشركة')" />
                        <x-text-input id="manager_name" class="block mt-1 w-full" type="text" name="manager_name" :value="old('manager_name')" />
                    </div>
                    
                    {{-- رقم هاتف الشركة والبريد الإلكتروني في صف واحد --}}
                    <div class="flex space-x-4 space-x-reverse">
                        <div class="mt-4 w-1/2">
                            <x-input-label for="phone_number" :value="__('رقم هاتف الشركة')" />
                            <x-text-input id="phone_number" class="block mt-1 w-full" type="text" name="phone_number" :value="old('phone_number')" />
                        </div>
                        <div class="mt-4 w-1/2">
                            <x-input-label for="email" :value="__('البريد الإلكتروني للشركة')" />
                            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" />
                        </div>
                    </div>


                    {{-- ---------------------------------------------------- --}}
                    {{-- 2. قسم بيانات المفوض (ملاحظة: نحتاج لجدول جديد لاحقاً) --}}
                    {{-- ---------------------------------------------------- --}}
                    <h3 class="text-lg font-bold text-gray-900 mt-8 mb-4 border-b pb-2">{{ __('بيانات المفوض') }}</h3>

                    <div class="flex space-x-4 space-x-reverse">
                        {{-- اسم المفوض --}}
                        <div class="mt-4 w-1/2">
                            <x-input-label for="authorized_person_name" :value="__('اسم المفوض')" />
                            <x-text-input id="authorized_person_name" class="block mt-1 w-full" type="text" name="authorized_person_name" :value="old('authorized_person_name')" />
                        </div>
                        {{-- رقم هاتف المفوض --}}
                        <div class="mt-4 w-1/2">
                            <x-input-label for="authorized_person_phone" :value="__('رقم هاتف المفوض')" />
                            <x-text-input id="authorized_person_phone" class="block mt-1 w-full" type="text" name="authorized_person_phone" :value="old('authorized_person_phone')" />
                        </div>
                    </div>
                    
                    {{-- ---------------------------------------------------- --}}
                    {{-- 3. قسم بيانات الموقع --}}
                    {{-- ---------------------------------------------------- --}}
                    <h3 class="text-lg font-bold text-gray-900 mt-8 mb-4 border-b pb-2">{{ __('بيانات الموقع الجغرافي (اختياري)') }}</h3>

                    {{-- العنوان التفصيلي (نص) --}}
                    <div class="mt-4">
                        <x-input-label for="address" :value="__('العنوان التفصيلي (نص)')" />
                        <textarea id="address" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" name="address">{{ old('address') }}</textarea>
                    </div>
                    
                    <div class="flex space-x-4 space-x-reverse">
                        {{-- خط العرض (Latitude) --}}
                        <div class="mt-4 w-1/2">
                            <x-input-label for="latitude" :value="__('خط العرض (Latitude)')" />
                            <x-text-input id="latitude" class="block mt-1 w-full" type="text" name="latitude" :value="old('latitude')" />
                        </div>

                        {{-- خط الطول (Longitude) --}}
                        <div class="mt-4 w-1/2">
                            <x-input-label for="longitude" :value="__('خط الطول (Longitude)')" />
                            <x-text-input id="longitude" class="block mt-1 w-full" type="text" name="longitude" :value="old('longitude')" />
                        </div>
                    </div>


                    <div class="flex items-center justify-end mt-6">
                        <x-primary-button>
                            {{ __('حفظ شركة التوزيع') }}
                        </x-primary-button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>