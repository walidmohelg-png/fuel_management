<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('تعديل بيانات شركة التوزيع') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">

                <form method="POST" action="{{ route('distributors.update', $distributor->id) }}">
                    @csrf
                    @method('PUT')

                    {{-- اسم الشركة --}}
                    <div class="mt-4">
                        <x-input-label for="name" :value="__('اسم الشركة')" />
                        <x-text-input id="name" class="block mt-1 w-full" type="text" name="name"
                                      value="{{ old('name', $distributor->name) }}" required />
                    </div>

                    {{-- المدير --}}
                    <div class="mt-4">
                        <x-input-label for="manager_name" :value="__('اسم المدير')" />
                        <x-text-input id="manager_name" class="block mt-1 w-full" type="text" name="manager_name"
                                      value="{{ old('manager_name', $distributor->manager_name) }}" />
                    </div>

                    {{-- الهاتف والبريد --}}
                    <div class="flex space-x-4 space-x-reverse">
                        <div class="mt-4 w-1/2">
                            <x-input-label for="phone" :value="__('رقم الهاتف')" />
                            <x-text-input id="phone" class="block mt-1 w-full" type="text" name="phone"
                                          value="{{ old('phone', $distributor->phone) }}" />
                        </div>
                        <div class="mt-4 w-1/2">
                            <x-input-label for="email" :value="__('البريد الإلكتروني')" />
                            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email"
                                          value="{{ old('email', $distributor->email) }}" />
                        </div>
                    </div>

                    {{-- المفوض --}}
                    <div class="flex space-x-4 space-x-reverse">
                        <div class="mt-4 w-1/2">
                            <x-input-label for="delegate_name" :value="__('اسم المفوض')" />
                            <x-text-input id="delegate_name" class="block mt-1 w-full" type="text" name="delegate_name"
                                          value="{{ old('delegate_name', $distributor->delegate_name) }}" />
                        </div>
                        <div class="mt-4 w-1/2">
                            <x-input-label for="delegate_phone" :value="__('هاتف المفوض')" />
                            <x-text-input id="delegate_phone" class="block mt-1 w-full" type="text" name="delegate_phone"
                                          value="{{ old('delegate_phone', $distributor->delegate_phone) }}" />
                        </div>
                    </div>

                    {{-- الموقع --}}
                    <div class="flex space-x-4 space-x-reverse">
                        <div class="mt-4 w-1/2">
                            <x-input-label for="region" :value="__('المنطقة')" />
                            <x-text-input id="region" class="block mt-1 w-full" type="text" name="region"
                                          value="{{ old('region', $distributor->region) }}" />
                        </div>
                        <div class="mt-4 w-1/2">
                            <x-input-label for="city" :value="__('المدينة')" />
                            <x-text-input id="city" class="block mt-1 w-full" type="text" name="city"
                                          value="{{ old('city', $distributor->city) }}" />
                        </div>
                    </div>

                    {{-- العنوان --}}
                    <div class="mt-4">
                        <x-input-label for="address" :value="__('العنوان التفصيلي')" />
                        <textarea id="address" class="block mt-1 w-full border-gray-300 rounded-md shadow-sm"
                                  name="address">{{ old('address', $distributor->address) }}</textarea>
                    </div>

                    {{-- الإحداثيات --}}
                    <div class="flex space-x-4 space-x-reverse">
                        <div class="mt-4 w-1/2">
                            <x-input-label for="latitude" :value="__('خط العرض')" />
                            <x-text-input id="latitude" class="block mt-1 w-full" type="text" name="latitude"
                                          value="{{ old('latitude', $distributor->latitude) }}" />
                        </div>
                        <div class="mt-4 w-1/2">
                            <x-input-label for="longitude" :value="__('خط الطول')" />
                            <x-text-input id="longitude" class="block mt-1 w-full" type="text" name="longitude"
                                          value="{{ old('longitude', $distributor->longitude) }}" />
                        </div>
                    </div>

                    <div class="flex items-center justify-end mt-6">
                        <x-primary-button>{{ __('تحديث البيانات') }}</x-primary-button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>
