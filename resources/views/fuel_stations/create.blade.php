<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight text-center">
            {{ __('إضافة محطة وقود جديدة') }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">

                <form action="{{ route('fuel_stations.store') }}" method="POST">
                    @csrf

                    {{-- اسم المحطة --}}
                    <div class="mb-4">
                        <label for="station_name" class="block text-gray-700 font-semibold mb-2">اسم المحطة</label>
                        <input type="text" id="station_name" name="station_name"
                            value="{{ old('station_name') }}"
                            class="w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-200"
                            required>
                        @error('station_name')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- رقم المحطة --}}
                    <div class="mb-4">
                        <label for="station_number" class="block text-gray-700 font-semibold mb-2">رقم المحطة</label>
                        <input type="text" id="station_number" name="station_number"
                            value="{{ old('station_number') }}"
                            class="w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-200"
                            required>
                        @error('station_number')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- المدينة --}}
                    <div class="mb-4">
                        <label for="city" class="block text-gray-700 font-semibold mb-2">المدينة</label>
                        <input type="text" id="city" name="city"
                            value="{{ old('city') }}"
                            class="w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-200"
                            required>
                        @error('city')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- العنوان --}}
                    <div class="mb-4">
                        <label for="address" class="block text-gray-700 font-semibold mb-2">العنوان</label>
                        <input type="text" id="address" name="address"
                            value="{{ old('address') }}"
                            class="w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-200"
                            required>
                        @error('address')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- اسم المالك --}}
                    <div class="mb-4">
                        <label for="owner_name" class="block text-gray-700 font-semibold mb-2">اسم المالك</label>
                        <input type="text" id="owner_name" name="owner_name"
                            value="{{ old('owner_name') }}"
                            class="w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-200">
                        @error('owner_name')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- رقم الهاتف --}}
                    <div class="mb-4">
                        <label for="owner_phone" class="block text-gray-700 font-semibold mb-2">رقم الهاتف</label>
                        <input type="text" id="owner_phone" name="owner_phone"
                            value="{{ old('owner_phone') }}"
                            class="w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-200">
                        @error('owner_phone')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- شركة التوزيع --}}
                    <div class="mb-4">
                        <label for="distributor_id" class="block text-gray-700 font-semibold mb-2">شركة التوزيع</label>
                        <select id="distributor_id" name="distributor_id"
                            class="w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-200"
                            required>
                            <option value="">اختر الشركة المزودة</option>
                            @foreach ($distributors as $distributor)
                                <option value="{{ $distributor->id }}"
                                    {{ old('distributor_id') == $distributor->id ? 'selected' : '' }}>
                                    {{ $distributor->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('distributor_id')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- أزرار التحكم --}}
                    <div class="flex justify-end mt-6">
                        <a href="{{ route('fuel_stations.index') }}"
                           class="bg-gray-500 text-white px-4 py-2 rounded-md ml-2 hover:bg-gray-600">
                           إلغاء
                        </a>
                        <button type="submit"
                                class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700">
                            التالي
                        </button>
                    </div>

                </form>

            </div>
        </div>
    </div>
</x-app-layout>
