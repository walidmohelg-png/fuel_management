<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('الخطوة 2 من 3: بيانات المفوض والمندوب والمخصصات') }}
        </h2>
    </x-slot>

    <div class="py-10">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow rounded-lg p-8">

                <!-- **ملاحظة:** تم التأكد أن الـ Action يشير إلى المسار الصحيح: beneficiaries.store_step_2 -->
                <form action="{{ route('beneficiaries.store_step_2') }}" method="POST" enctype="multipart/form-data">
                @csrf

                    {{-- نوع الوقود والمخصص الشهري --}}
                    <div class="grid grid-cols-2 gap-6">
                        <div>
                            <x-input-label for="fuel_type" value="نوع الوقود" />
                            <select id="fuel_type" name="fuel_type"
                                class="block w-full border-gray-300 rounded-md shadow-sm mt-1">
                                <option value="">-- اختر نوع الوقود --</option>
                                <option value="بنزين" {{ old('fuel_type') == 'بنزين' ? 'selected' : '' }}>بنزين</option>
                                <option value="ديزل" {{ old('fuel_type') == 'ديزل' ? 'selected' : '' }}>ديزل</option>
                            </select>
                            <x-input-error :messages="$errors->get('fuel_type')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="monthly_allowance" value="المخصص الشهري (لتر)" />
                            <x-text-input id="monthly_allowance" name="monthly_allowance" type="number" min="0"
                                class="block w-full mt-1" value="{{ old('monthly_allowance') }}" />
                            <x-input-error :messages="$errors->get('monthly_allowance')" class="mt-2" />
                        </div>
                    </div>

                    {{-- مستودع التزويد --}}
                    <div class="mt-6">
                        <x-input-label for="supply_warehouse" value="مستودع التزويد" />
                        <x-text-input id="supply_warehouse" name="supply_warehouse" type="text"
                            class="block w-full mt-1" value="{{ old('supply_warehouse') }}" />
                        <x-input-error :messages="$errors->get('supply_warehouse')" class="mt-2" />
                    </div>

                    {{-- بيانات المفوض --}}
                    <h3 class="text-lg font-bold text-gray-800 mt-8 mb-4 border-b pb-2">بيانات المفوض</h3>
                    <div class="grid grid-cols-3 gap-6">
                        <div>
                            <x-input-label for="authorized_person_name" value="اسم المفوض" />
                            <x-text-input id="authorized_person_name" name="authorized_person_name" type="text"
                                class="block w-full mt-1" value="{{ old('authorized_person_name') }}" />
                            <x-input-error :messages="$errors->get('authorized_person_name')" class="mt-2" />
                        </div>
                        <div>
                            <x-input-label for="authorized_person_phone" value="هاتف المفوض" />
                            <x-text-input id="authorized_person_phone" name="authorized_person_phone" type="text"
                                class="block w-full mt-1" value="{{ old('authorized_person_phone') }}" />
                            <x-input-error :messages="$errors->get('authorized_person_phone')" class="mt-2" />
                        </div>
                        <div>
                            <x-input-label for="authorized_person_email" value="بريد المفوض" />
                            <x-text-input id="authorized_person_email" name="authorized_person_email" type="email"
                                class="block w-full mt-1" value="{{ old('authorized_person_email') }}" />
                            <x-input-error :messages="$errors->get('authorized_person_email')" class="mt-2" />
                        </div>
                    </div>

                    {{-- بيانات المندوب --}}
                    <h3 class="text-lg font-bold text-gray-800 mt-8 mb-4 border-b pb-2">بيانات المندوب</h3>
                    <div class="grid grid-cols-3 gap-6">
                        <div>
                            <x-input-label for="representative_name" value="اسم المندوب" />
                            <x-text-input id="representative_name" name="representative_name" type="text"
                                class="block w-full mt-1" value="{{ old('representative_name') }}" />
                            <x-input-error :messages="$errors->get('representative_name')" class="mt-2" />
                        </div>
                        <div>
                            <x-input-label for="representative_phone" value="هاتف المندوب" />
                            <x-text-input id="representative_phone" name="representative_phone" type="text"
                                class="block w-full mt-1" value="{{ old('representative_phone') }}" />
                            <x-input-error :messages="$errors->get('representative_phone')" class="mt-2" />
                        </div>
                        <div>
                            <x-input-label for="representative_email" value="بريد المندوب" />
                            <x-text-input id="representative_email" name="representative_email" type="email"
                                class="block w-full mt-1" value="{{ old('representative_email') }}" />
                            <x-input-error :messages="$errors->get('representative_email')" class="mt-2" />
                        </div>
                    </div>

                    {{-- ملاحظات وتاريخ السريان --}}
                    <div class="grid grid-cols-2 gap-6 mt-6">
                        <div>
                            <x-input-label for="effective_date" value="تاريخ السريان" />
                            <x-text-input id="effective_date" name="effective_date" type="date"
                                class="block w-full mt-1" value="{{ old('effective_date') }}" />
                            <x-input-error :messages="$errors->get('effective_date')" class="mt-2" />
                        </div>
                        <div>
                            <x-input-label for="notes" value="ملاحظات" />
                            <textarea id="notes" name="notes" rows="3"
                                class="block w-full border-gray-300 rounded-md shadow-sm mt-1">{{ old('notes') }}</textarea>
                            <x-input-error :messages="$errors->get('notes')" class="mt-2" />
                        </div>
                    </div>

                    <hr class="my-6 border-gray-300">

<h2 class="text-lg font-semibold text-gray-700 mb-4">🔹 بيانات المفوض الإضافية</h2>
<div class="grid grid-cols-1 md:grid-cols-3 gap-4">
    <div>
        <x-input-label for="authorized_person_national_id" :value="__('الرقم الوطني للمفوض')" />
        <!-- **تعديل:** تم تغيير الاسم إلى authorized_person_national_id -->
        <x-text-input id="authorized_person_national_id" name="authorized_person_national_id" type="text" class="mt-1 block w-full"
            value="{{ old('authorized_person_national_id') }}" />
        <x-input-error :messages="$errors->get('authorized_person_national_id')" class="mt-2" />
    </div>
    <div>
        <x-input-label for="authorized_person_passport_no" :value="__('رقم جواز السفر للمفوض')" />
        <!-- **تعديل:** تم تغيير الاسم إلى authorized_person_passport_no -->
        <x-text-input id="authorized_person_passport_no" name="authorized_person_passport_no" type="text" class="mt-1 block w-full"
            value="{{ old('authorized_person_passport_no') }}" />
        <x-input-error :messages="$errors->get('authorized_person_passport_no')" class="mt-2" />
    </div>
    <div>
        <x-input-label for="authorized_person_photo" :value="__('صورة المفوض')" />
        <!-- **تعديل:** تم التأكد من اسم الحقل ومعه enctype="multipart/form-data" في وسم <form> -->
        <x-text-input id="authorized_person_photo" name="authorized_person_photo" type="file" accept="image/*" class="mt-1 block w-full" />
        <x-input-error :messages="$errors->get('authorized_person_photo')" class="mt-2" />
    </div>
</div>

<hr class="my-6 border-gray-300">

<h2 class="text-lg font-semibold text-gray-700 mb-4">🔹 بيانات المندوب الإضافية</h2>
<div class="grid grid-cols-1 md:grid-cols-3 gap-4">
    <div>
        <x-input-label for="representative_national_id" :value="__('الرقم الوطني للمندوب')" />
        <!-- **تعديل:** تم تغيير الاسم إلى representative_national_id -->
        <x-text-input id="representative_national_id" name="representative_national_id" type="text" class="mt-1 block w-full"
            value="{{ old('representative_national_id') }}" />
        <x-input-error :messages="$errors->get('representative_national_id')" class="mt-2" />
    </div>
    <div>
        <x-input-label for="representative_passport_no" :value="__('رقم جواز السفر للمندوب')" />
        <!-- **تعديل:** تم تغيير الاسم إلى representative_passport_no -->
        <x-text-input id="representative_passport_no" name="representative_passport_no" type="text" class="mt-1 block w-full"
            value="{{ old('representative_passport_no') }}" />
        <x-input-error :messages="$errors->get('representative_passport_no')" class="mt-2" />
    </div>
    <div>
        <x-input-label for="representative_photo" :value="__('صورة المندوب')" />
        <!-- **تعديل:** تم التأكد من اسم الحقل -->
        <x-text-input id="representative_photo" name="representative_photo" type="file" accept="image/*" class="mt-1 block w-full" />
        <x-input-error :messages="$errors->get('representative_photo')" class="mt-2" />
    </div>
</div>


                    {{-- أزرار التنقل --}}
                    <div class="flex justify-between items-center mt-8">
                        <a href="{{ route('beneficiaries.create_step_1') }}"
                            class="px-4 py-2 bg-gray-200 text-gray-700 rounded-md hover:bg-gray-300">
                            ← الرجوع للخطوة السابقة
                        </a>

                        <x-primary-button>
                            {{ __('💾 حفظ ومتابعة إلى الخطوة التالية →') }}
                        </x-primary-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>