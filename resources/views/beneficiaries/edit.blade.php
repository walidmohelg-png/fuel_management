<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('تعديل بيانات الشركة المستفيدة') . ' : ' . ($beneficiaryCompany->name ?? '-') }}
        </h2>
    </x-slot>

    <div class="py-10">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">

                {{-- النموذج الرئيسي للإرسال --}}
                <form method="POST" action="{{ route('beneficiaries.update', ['beneficiaryCompany' => $beneficiaryCompany->id]) }}" enctype="multipart/form-data">
                    @csrf
                    @method('PUT') {{-- هذا ضروري لإرسال طلب التعديل --}}

                    {{-- نظام التبويبات (Tabs) --}}
                    <div x-data="{ currentTab: 'basic' }" class="mb-6">
                        {{-- قائمة التبويبات --}}
                        <nav class="border-b border-gray-200 -mb-px flex space-x-8 rtl:space-x-reverse" aria-label="Tabs">
                            <a href="#" @click.prevent="currentTab = 'basic'" :class="{'border-indigo-500 text-indigo-600': currentTab === 'basic', 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300': currentTab !== 'basic'}"
                               class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm transition duration-150 ease-in-out">
                                {{ __('البيانات الأساسية') }}
                            </a>
                            <a href="#" @click.prevent="currentTab = 'personnel'" :class="{'border-indigo-500 text-indigo-600': currentTab === 'personnel', 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300': currentTab !== 'personnel'}"
                               class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm transition duration-150 ease-in-out">
                                {{ __('بيانات المفوض والممثل') }}
                            </a>
                            <a href="#" @click.prevent="currentTab = 'documents'" :class="{'border-indigo-500 text-indigo-600': currentTab === 'documents', 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300': currentTab !== 'documents'}"
                               class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm transition duration-150 ease-in-out">
                                {{ __('الوثائق والمخصصات') }}
                            </a>
                        </nav>

                        {{-- محتوى التبويبات --}}
                        <div class="mt-8">
                            {{-- تبويب البيانات الأساسية --}}
                            <div x-show="currentTab === 'basic'">
                                <h3 class="text-xl font-semibold text-gray-900 mb-6">{{ __('البيانات الأساسية للشركة') }}</h3>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    {{-- شركة التوزيع --}}
                                    <div>
                                        <label for="distributor_id" class="block text-sm font-medium text-gray-700">{{ __('شركة التوزيع') }} <span class="text-red-500">*</span></label>
                                        <select name="distributor_id" id="distributor_id"
                                                class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm @error('distributor_id') border-red-500 @enderror">
                                            <option value="">{{ __('اختر شركة التوزيع') }}</option>
                                            @foreach($distributors as $distributor)
                                                <option value="{{ $distributor->id }}"
                                                        {{ (old('distributor_id', $beneficiaryCompany->distributor_id ?? '') == $distributor->id) ? 'selected' : '' }}>
                                                    {{ $distributor->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('distributor_id')
                                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    {{-- اسم الشركة --}}
                                    <div>
                                        <label for="name" class="block text-sm font-medium text-gray-700">{{ __('اسم الشركة') }} <span class="text-red-500">*</span></label>
                                        <input type="text" name="name" id="name"
                                               value="{{ old('name', $beneficiaryCompany->name ?? '') }}"
                                               class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm @error('name') border-red-500 @enderror">
                                        @error('name')
                                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    {{-- نوع النشاط --}}
                                    <div>
                                        <label for="activity_type" class="block text-sm font-medium text-gray-700">{{ __('نوع النشاط') }} <span class="text-red-500">*</span></label>
                                        <input type="text" name="activity_type" id="activity_type"
                                               value="{{ old('activity_type', $beneficiaryCompany->activity_type ?? '') }}"
                                               class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm @error('activity_type') border-red-500 @enderror">
                                        @error('activity_type')
                                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    {{-- كود الوقود --}}
                                    <div>
                                        <label for="fuel_code" class="block text-sm font-medium text-gray-700">{{ __('كود الوقود') }}</label>
                                        <input type="text" name="fuel_code" id="fuel_code"
                                               value="{{ old('fuel_code', $beneficiaryCompany->fuel_code ?? '') }}"
                                               class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm @error('fuel_code') border-red-500 @enderror">
                                        @error('fuel_code')
                                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    {{-- المنطقة --}}
                                    <div>
                                        <label for="region" class="block text-sm font-medium text-gray-700">{{ __('المنطقة') }}</label>
                                        <input type="text" name="region" id="region"
                                               value="{{ old('region', $beneficiaryCompany->region ?? '') }}"
                                               class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm @error('region') border-red-500 @enderror">
                                        @error('region')
                                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    {{-- المدينة --}}
                                    <div>
                                        <label for="city" class="block text-sm font-medium text-gray-700">{{ __('المدينة') }}</label>
                                        <input type="text" name="city" id="city"
                                               value="{{ old('city', $beneficiaryCompany->city ?? '') }}"
                                               class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm @error('city') border-red-500 @enderror">
                                        @error('city')
                                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    {{-- العنوان --}}
                                    <div class="md:col-span-2">
                                        <label for="address" class="block text-sm font-medium text-gray-700">{{ __('العنوان') }}</label>
                                        <textarea name="address" id="address" rows="3"
                                                  class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm @error('address') border-red-500 @enderror">{{ old('address', $beneficiaryCompany->address ?? '') }}</textarea>
                                        @error('address')
                                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    {{-- خط العرض --}}
                                    <div>
                                        <label for="latitude" class="block text-sm font-medium text-gray-700">{{ __('خط العرض (Latitude)') }}</label>
                                        <input type="text" name="latitude" id="latitude"
                                               value="{{ old('latitude', $beneficiaryCompany->latitude ?? '') }}"
                                               class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm @error('latitude') border-red-500 @enderror">
                                        @error('latitude')
                                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    {{-- خط الطول --}}
                                    <div>
                                        <label for="longitude" class="block text-sm font-medium text-gray-700">{{ __('خط الطول (Longitude)') }}</label>
                                        <input type="text" name="longitude" id="longitude"
                                               value="{{ old('longitude', $beneficiaryCompany->longitude ?? '') }}"
                                               class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm @error('longitude') border-red-500 @enderror">
                                        @error('longitude')
                                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    {{-- الحالة الحالية --}}
                                    <div>
                                        <label for="current_status" class="block text-sm font-medium text-gray-700">{{ __('الحالة الحالية') }} <span class="text-red-500">*</span></label>
                                        <select name="current_status" id="current_status"
                                                class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm @error('current_status') border-red-500 @enderror">
                                            @php
                                                $statuses = ['نشطة', 'غير_نشطة', 'موثقة'];
                                                $currentStatus = old('current_status', $beneficiaryCompany->current_status ?? '');
                                            @endphp
                                            <option value="">{{ __('اختر الحالة') }}</option>
                                            @foreach($statuses as $status)
                                                <option value="{{ $status }}" {{ $currentStatus == $status ? 'selected' : '' }}>{{ __($status) }}</option>
                                            @endforeach
                                        </select>
                                        @error('current_status')
                                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            {{-- تبويب بيانات المفوض والممثل --}}
                            <div x-show="currentTab === 'personnel'" style="display: none;">
                                <h3 class="text-xl font-semibold text-gray-900 mb-6">{{ __('بيانات المفوض والممثل') }}</h3>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    {{-- بيانات المفوض --}}
                                    <div class="md:col-span-2">
                                        <h4 class="text-lg font-semibold text-gray-800 mb-4">{{ __('بيانات المفوض') }}</h4>
                                    </div>
                                    <div>
                                        <label for="authorized_person_name" class="block text-sm font-medium text-gray-700">{{ __('اسم المفوض') }} <span class="text-red-500">*</span></label>
                                        <input type="text" name="authorized_person_name" id="authorized_person_name"
                                               value="{{ old('authorized_person_name', $beneficiaryCompany->companyDetail->authorized_person_name ?? '') }}"
                                               class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm @error('authorized_person_name') border-red-500 @enderror">
                                        @error('authorized_person_name')
                                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div>
                                        <label for="authorized_person_phone" class="block text-sm font-medium text-gray-700">{{ __('رقم هاتف المفوض') }} <span class="text-red-500">*</span></label>
                                        <input type="text" name="authorized_person_phone" id="authorized_person_phone"
                                               value="{{ old('authorized_person_phone', $beneficiaryCompany->companyDetail->authorized_person_phone ?? '') }}"
                                               class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm @error('authorized_person_phone') border-red-500 @enderror">
                                        @error('authorized_person_phone')
                                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div>
                                        <label for="authorized_person_email" class="block text-sm font-medium text-gray-700">{{ __('بريد المفوض الإلكتروني') }} <span class="text-red-500">*</span></label>
                                        <input type="email" name="authorized_person_email" id="authorized_person_email"
                                               value="{{ old('authorized_person_email', $beneficiaryCompany->companyDetail->authorized_person_email ?? '') }}"
                                               class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm @error('authorized_person_email') border-red-500 @enderror">
                                        @error('authorized_person_email')
                                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div>
                                        <label for="authorized_person_national_id" class="block text-sm font-medium text-gray-700">{{ __('رقم الهوية الوطنية للمفوض') }}</label>
                                        <input type="text" name="authorized_person_national_id" id="authorized_person_national_id"
                                               value="{{ old('authorized_person_national_id', $beneficiaryCompany->companyDetail->authorized_person_national_id ?? '') }}"
                                               class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm @error('authorized_person_national_id') border-red-500 @enderror">
                                        @error('authorized_person_national_id')
                                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div>
                                        <label for="authorized_person_passport_no" class="block text-sm font-medium text-gray-700">{{ __('رقم جواز سفر المفوض (اختياري)') }}</label>
                                        <input type="text" name="authorized_person_passport_no" id="authorized_person_passport_no"
                                               value="{{ old('authorized_person_passport_no', $beneficiaryCompany->companyDetail->authorized_person_passport_no ?? '') }}"
                                               class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm @error('authorized_person_passport_no') border-red-500 @enderror">
                                        @error('authorized_person_passport_no')
                                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div class="md:col-span-2">
                                        <label for="authorized_person_photo" class="block text-sm font-medium text-gray-700">{{ __('صورة المفوض') }}</label>
                                        <input type="file" name="authorized_person_photo" id="authorized_person_photo"
                                               class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 @error('authorized_person_photo') border-red-500 @enderror">
                                        @error('authorized_person_photo')
                                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                        @enderror
                                        @if(isset($beneficiaryCompany->companyDetail->authorized_person_photo_path) && $beneficiaryCompany->companyDetail->authorized_person_photo_path)
                                            <div class="mt-2">
                                                <p class="text-xs text-gray-500 mb-1">{{ __('الصورة الحالية:') }}</p>
                                                <img src="{{ asset('storage/' . $beneficiaryCompany->companyDetail->authorized_person_photo_path) }}" alt="صورة المفوض" class="w-24 h-24 object-cover rounded-md">
                                            </div>
                                        @endif
                                    </div>

                                    {{-- بيانات الممثل --}}
                                    <div class="md:col-span-2 mt-8">
                                        <h4 class="text-lg font-semibold text-gray-800 mb-4">{{ __('بيانات الممثل') }}</h4>
                                    </div>
                                    <div>
                                        <label for="representative_name" class="block text-sm font-medium text-gray-700">{{ __('اسم الممثل') }} <span class="text-red-500">*</span></label>
                                        <input type="text" name="representative_name" id="representative_name"
                                               value="{{ old('representative_name', $beneficiaryCompany->companyDetail->representative_name ?? '') }}"
                                               class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm @error('representative_name') border-red-500 @enderror">
                                        @error('representative_name')
                                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div>
                                        <label for="representative_phone" class="block text-sm font-medium text-gray-700">{{ __('رقم هاتف الممثل') }} <span class="text-red-500">*</span></label>
                                        <input type="text" name="representative_phone" id="representative_phone"
                                               value="{{ old('representative_phone', $beneficiaryCompany->companyDetail->representative_phone ?? '') }}"
                                               class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm @error('representative_phone') border-red-500 @enderror">
                                        @error('representative_phone')
                                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div>
                                        <label for="representative_email" class="block text-sm font-medium text-gray-700">{{ __('بريد الممثل الإلكتروني') }} <span class="text-red-500">*</span></label>
                                        <input type="email" name="representative_email" id="representative_email"
                                               value="{{ old('representative_email', $beneficiaryCompany->companyDetail->representative_email ?? '') }}"
                                               class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm @error('representative_email') border-red-500 @enderror">
                                        @error('representative_email')
                                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div>
                                        <label for="representative_national_id" class="block text-sm font-medium text-gray-700">{{ __('رقم الهوية الوطنية للممثل') }}</label>
                                        <input type="text" name="representative_national_id" id="representative_national_id"
                                               value="{{ old('representative_national_id', $beneficiaryCompany->companyDetail->representative_national_id ?? '') }}"
                                               class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm @error('representative_national_id') border-red-500 @enderror">
                                        @error('representative_national_id')
                                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div>
                                        <label for="representative_passport_no" class="block text-sm font-medium text-gray-700">{{ __('رقم جواز سفر الممثل (اختياري)') }}</label>
                                        <input type="text" name="representative_passport_no" id="representative_passport_no"
                                               value="{{ old('representative_passport_no', $beneficiaryCompany->companyDetail->representative_passport_no ?? '') }}"
                                               class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm @error('representative_passport_no') border-red-500 @enderror">
                                        @error('representative_passport_no')
                                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div class="md:col-span-2">
                                        <label for="representative_photo" class="block text-sm font-medium text-gray-700">{{ __('صورة الممثل') }}</label>
                                        <input type="file" name="representative_photo" id="representative_photo"
                                               class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 @error('representative_photo') border-red-500 @enderror">
                                        @error('representative_photo')
                                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                        @enderror
                                        @if(isset($beneficiaryCompany->companyDetail->representative_photo_path) && $beneficiaryCompany->companyDetail->representative_photo_path)
                                            <div class="mt-2">
                                                <p class="text-xs text-gray-500 mb-1">{{ __('الصورة الحالية:') }}</p>
                                                <img src="{{ asset('storage/' . $beneficiaryCompany->companyDetail->representative_photo_path) }}" alt="صورة الممثل" class="w-24 h-24 object-cover rounded-md">
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            {{-- تبويب الوثائق والمخصصات --}}
                            <div x-show="currentTab === 'documents'" style="display: none;">
                                <h3 class="text-xl font-semibold text-gray-900 mb-6">{{ __('الوثائق والمخصصات') }}</h3>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    {{-- بيانات المخصصات --}}
                                    <div class="md:col-span-2">
                                        <h4 class="text-lg font-semibold text-gray-800 mb-4">{{ __('بيانات المخصصات') }}</h4>
                                    </div>
                                    <div>
                                        <label for="fuel_type" class="block text-sm font-medium text-gray-700">{{ __('نوع الوقود') }} <span class="text-red-500">*</span></label>
                                        <input type="text" name="fuel_type" id="fuel_type"
                                               value="{{ old('fuel_type', $beneficiaryCompany->companyDetail->fuel_type ?? '') }}"
                                               class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm @error('fuel_type') border-red-500 @enderror">
                                        @error('fuel_type')
                                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div>
                                        <label for="monthly_allowance" class="block text-sm font-medium text-gray-700">{{ __('المخصص الشهري') }} <span class="text-red-500">*</span></label>
                                        <input type="number" name="monthly_allowance" id="monthly_allowance"
                                               value="{{ old('monthly_allowance', $beneficiaryCompany->companyDetail->monthly_allowance ?? '') }}"
                                               class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm @error('monthly_allowance') border-red-500 @enderror">
                                        @error('monthly_allowance')
                                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div>
                                        <label for="supply_warehouse" class="block text-sm font-medium text-gray-700">{{ __('مستودع التوريد') }} <span class="text-red-500">*</span></label>
                                        <input type="text" name="supply_warehouse" id="supply_warehouse"
                                               value="{{ old('supply_warehouse', $beneficiaryCompany->companyDetail->supply_warehouse ?? '') }}"
                                               class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm @error('supply_warehouse') border-red-500 @enderror">
                                        @error('supply_warehouse')
                                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div>
                                        <label for="effective_date" class="block text-sm font-medium text-gray-700">{{ __('تاريخ سريان المخصصات') }} <span class="text-red-500">*</span></label>
                                        <input type="date" name="effective_date" id="effective_date"
                                               value="{{ old('effective_date', $beneficiaryCompany->companyDetail->effective_date ? \Carbon\Carbon::parse($beneficiaryCompany->companyDetail->effective_date)->format('Y-m-d') : '') }}"
                                               class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm @error('effective_date') border-red-500 @enderror">
                                        @error('effective_date')
                                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div class="md:col-span-2">
                                        <label for="notes" class="block text-sm font-medium text-gray-700">{{ __('ملاحظات المخصصات') }}</label>
                                        <textarea name="notes" id="notes" rows="3"
                                                  class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm @error('notes') border-red-500 @enderror">{{ old('notes', $beneficiaryCompany->companyDetail->notes ?? '') }}</textarea>
                                        @error('notes')
                                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    {{-- وثائق الشركة --}}
                                    <div class="md:col-span-2 mt-8">
                                        <h4 class="text-lg font-semibold text-gray-800 mb-4">{{ __('وثائق الشركة') }}</h4>
                                    </div>
                                    {{-- يمكنك هنا تكرار حقول المستندات إذا كانت هناك وثائق متعددة --}}
                                    {{-- للمستند الأول --}}
                                    <div>
                                        <label for="documents_0_document_type" class="block text-sm font-medium text-gray-700">{{ __('نوع الوثيقة') }}</label>
                                        <input type="text" name="documents[0][document_type]" id="documents_0_document_type"
                                               value="{{ old('documents.0.document_type', $beneficiaryCompany->documents->get(0)->document_type ?? '') }}"
                                               class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm @error('documents.0.document_type') border-red-500 @enderror">
                                        @error('documents.0.document_type')
                                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div>
                                        <label for="documents_0_document_number" class="block text-sm font-medium text-gray-700">{{ __('رقم الوثيقة') }}</label>
                                        <input type="text" name="documents[0][document_number]" id="documents_0_document_number"
                                               value="{{ old('documents.0.document_number', $beneficiaryCompany->documents->get(0)->document_number ?? '') }}"
                                               class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm @error('documents.0.document_number') border-red-500 @enderror">
                                        @error('documents.0.document_number')
                                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div>
                                        <label for="documents_0_expiry_date" class="block text-sm font-medium text-gray-700">{{ __('تاريخ الانتهاء') }}</label>
                                        <input type="date" name="documents[0][expiry_date]" id="documents_0_expiry_date"
                                               value="{{ old('documents.0.expiry_date', $beneficiaryCompany->documents->get(0)->expiry_date ?? '') }}"
                                               class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm @error('documents.0.expiry_date') border-red-500 @enderror">
                                        @error('documents.0.expiry_date')
                                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div>
                                        <label for="documents_0_document_status" class="block text-sm font-medium text-gray-700">{{ __('حالة الوثيقة') }}</label>
                                        <select name="documents[0][document_status]" id="documents_0_document_status"
                                                class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm @error('documents.0.document_status') border-red-500 @enderror">
                                            @php
                                                $docStatuses = ['ساري', 'منتهي', 'غير مستوفي', 'لا يوجد'];
                                                $currentDocStatus = old('documents.0.document_status', $beneficiaryCompany->documents->get(0)->document_status ?? 'لا يوجد');
                                            @endphp
                                            @foreach($docStatuses as $status)
                                                <option value="{{ $status }}" {{ $currentDocStatus == $status ? 'selected' : '' }}>{{ __($status) }}</option>
                                            @endforeach
                                        </select>
                                        @error('documents.0.document_status')
                                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div class="md:col-span-2">
                                        <label for="documents_0_file" class="block text-sm font-medium text-gray-700">{{ __('ملف الوثيقة') }}</label>
                                        <input type="file" name="documents[0][file]" id="documents_0_file"
                                               class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 @error('documents.0.file') border-red-500 @enderror">
                                        @error('documents.0.file')
                                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                        @enderror
                                        @if(isset($beneficiaryCompany->documents->get(0)->document_file) && $beneficiaryCompany->documents->get(0)->document_file)
                                            <div class="mt-2">
                                                <p class="text-xs text-gray-500 mb-1">{{ __('الملف الحالي:') }}</p>
                                                <a href="{{ asset('storage/' . $beneficiaryCompany->documents->get(0)->document_file) }}" target="_blank" class="text-blue-600 hover:underline">
                                                    {{ __('عرض الملف') }}
                                                </a>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="md:col-span-2">
                                        <label for="documents_0_notes" class="block text-sm font-medium text-gray-700">{{ __('ملاحظات الوثيقة') }}</label>
                                        <textarea name="documents[0][notes]" id="documents_0_notes" rows="3"
                                                  class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm @error('documents.0.notes') border-red-500 @enderror">{{ old('documents.0.notes', $beneficiaryCompany->documents->get(0)->notes ?? '') }}</textarea>
                                        @error('documents.0.notes')
                                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="flex justify-end mt-8">
                        <button type="submit"
                                class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            {{ __('حفظ التعديلات') }}
                        </button>
                        <a href="{{ route('beneficiaries.show', ['beneficiaryCompany' => $beneficiaryCompany->id]) }}" class="bg-gray-400 hover:bg-gray-500 text-white font-bold py-2 px-4 rounded-md shadow-sm ml-2">
                            {{ __('إلغاء') }}
                        </a>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>