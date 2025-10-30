@php
    // تسهيل الوصول للبيانات
    $details = $company->details;
@endphp

<div class="grid grid-cols-1 md:grid-cols-2 gap-6">

    {{-- العمود الأيمن: بيانات المفوض --}}
    <div>
        <h4 class="text-lg font-medium text-gray-800 mb-4 border-b pb-2">{{ __('بيانات المفوض') }}</h4>
        
        {{-- 1. اسم المفوض --}}
        <div class="mt-4">
            <x-input-label for="authorized_person_name" :value="__('اسم المفوض')" />
            <x-text-input id="authorized_person_name" class="block mt-1 w-full" type="text" name="authorized_person_name" :value="old('authorized_person_name', $details->authorized_person_name ?? '')" />
        </div>

        {{-- 2. رقم هاتف المفوض --}}
        <div class="mt-4">
            <x-input-label for="authorized_person_phone" :value="__('رقم هاتف المفوض')" />
            <x-text-input id="authorized_person_phone" class="block mt-1 w-full" type="text" name="authorized_person_phone" :value="old('authorized_person_phone', $details->authorized_person_phone ?? '')" />
        </div>
        
        {{-- 3. بريد المفوض --}}
        <div class="mt-4">
            <x-input-label for="authorized_person_email" :value="__('البريد الإلكتروني للمفوض')" />
            <x-text-input id="authorized_person_email" class="block mt-1 w-full" type="email" name="authorized_person_email" :value="old('authorized_person_email', $details->authorized_person_email ?? '')" />
        </div>
        
        {{-- 4. صورة المفوض (مع عرض الصورة الحالية) --}}
        <div class="mt-4">
            <x-input-label for="authorized_person_photo_path" :value="__('صورة المفوض (ملف)')" />
            <input id="authorized_person_photo_path" name="authorized_person_photo_path" type="file" class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 focus:outline-none mt-1" />
            @if($details->authorized_person_photo_path ?? false)
                <img src="{{ asset('storage/' . $details->authorized_person_photo_path) }}" alt="صورة المفوض" class="mt-2 w-20 h-20 object-cover rounded-md" />
            @endif
            <p class="mt-1 text-sm text-gray-500">{{ __('اترك الحقل فارغاً لعدم التغيير.') }}</p>
        </div>

    </div>

    {{-- العمود الأيسر: بيانات المندوب --}}
    <div>
        <h4 class="text-lg font-medium text-gray-800 mb-4 border-b pb-2">{{ __('بيانات المندوب') }}</h4>
        
        {{-- 5. اسم المندوب --}}
        <div class="mt-4">
            <x-input-label for="representative_name" :value="__('اسم المندوب')" />
            <x-text-input id="representative_name" class="block mt-1 w-full" type="text" name="representative_name" :value="old('representative_name', $details->representative_name ?? '')" />
        </div>

        {{-- 6. رقم هاتف المندوب --}}
        <div class="mt-4">
            <x-input-label for="representative_phone" :value="__('رقم هاتف المندوب')" />
            <x-text-input id="representative_phone" class="block mt-1 w-full" type="text" name="representative_phone" :value="old('representative_phone', $details->representative_phone ?? '')" />
        </div>
        
        {{-- 7. بريد المندوب --}}
        <div class="mt-4">
            <x-input-label for="representative_email" :value="__('البريد الإلكتروني للمندوب')" />
            <x-text-input id="representative_email" class="block mt-1 w-full" type="email" name="representative_email" :value="old('representative_email', $details->representative_email ?? '')" />
        </div>
        
        {{-- 8. صورة المندوب (مع عرض الصورة الحالية) --}}
        <div class="mt-4">
            <x-input-label for="representative_photo_path" :value="__('صورة المندوب (ملف)')" />
            <input id="representative_photo_path" name="representative_photo_path" type="file" class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 focus:outline-none mt-1" />
            @if($details->representative_photo_path ?? false)
                <img src="{{ asset('storage/' . $details->representative_photo_path) }}" alt="صورة المندوب" class="mt-2 w-20 h-20 object-cover rounded-md" />
            @endif
            <p class="mt-1 text-sm text-gray-500">{{ __('اترك الحقل فارغاً لعدم التغيير.') }}</p>
        </div>

    </div>
</div>