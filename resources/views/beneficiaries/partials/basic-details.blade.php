<div class="grid grid-cols-1 md:grid-cols-2 gap-6">

    {{-- العمود الأيمن (البيانات الأساسية) --}}
    <div>
        <h4 class="text-lg font-medium text-gray-800 mb-4 border-b pb-2">{{ __('تحديد المورد') }}</h4>
        
        {{-- 1. الشركة المزودة (يختار من قائمة شركات التوزيع) --}}
        <div class="mt-4">
            <x-input-label for="distributor_id" :value="__('الشركة المزودة (المورد)')" />
            <select id="distributor_id" name="distributor_id" required class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                <option value="">{{ __('اختر شركة التوزيع...') }}</option>
                {{-- الحلقة لعرض الموردين --}}
                @foreach ($distributors as $distributor)
                    <option value="{{ $distributor->id }}" {{ old('distributor_id') == $distributor->id ? 'selected' : '' }}>
                        {{ $distributor->name }}
                    </option>
                @endforeach
            </select>
            <x-input-error :messages="$errors->get('distributor_id')" class="mt-2" />
        </div>

        <h4 class="text-lg font-medium text-gray-800 mt-6 mb-4 border-b pb-2">{{ __('بيانات الشركة') }}</h4>

        {{-- 2. اسم الشركة المستفيدة --}}
        <div class="mt-4">
            <x-input-label for="name" :value="__('اسم الشركة المستفيدة')" />
            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        {{-- 3. نوع النشاط (إدخال يدوي) --}}
        <div class="mt-4">
            <x-input-label for="activity_type" :value="__('نوع النشاط')" />
            <x-text-input id="activity_type" class="block mt-1 w-full" type="text" name="activity_type" :value="old('activity_type')" />
        </div>
        
        {{-- 4. الرمز (مثل NS-001) --}}
        <div class="mt-4">
            <x-input-label for="fuel_code" :value="__('رمز الشركة')" />
            <x-text-input id="fuel_code" class="block mt-1 w-full" type="text" name="fuel_code" :value="old('fuel_code')" />
        </div>

        {{-- 5. حالة الشركة (للبدء) --}}
        <div class="mt-4">
            <x-input-label for="current_status" :value="__('الحالة الأولية للشركة')" />
            <select id="current_status" name="current_status" required class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                <option value="pending" {{ old('current_status') == 'pending' ? 'selected' : '' }}>{{ __('تحت الإجراء') }}</option>
                <option value="active" {{ old('current_status') == 'active' ? 'selected' : '' }}>{{ __('مفعلة') }}</option>
                <option value="suspended" {{ old('current_status') == 'suspended' ? 'selected' : '' }}>{{ __('موقوفة') }}</option>
            </select>
        </div>
    </div>


    {{-- العمود الأيسر (بيانات المخصصات والموقع) --}}
    <div>
        <h4 class="text-lg font-medium text-gray-800 mb-4 border-b pb-2">{{ __('بيانات المخصص والموقع') }}</h4>
        
        {{-- 6. نوع الوقود --}}
        <div class="mt-4">
            <x-input-label for="fuel_type" :value="__('نوع الوقود المخصص')" />
            <select id="fuel_type" name="fuel_type" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                <option value="ديزل" {{ old('fuel_type') == 'ديزل' ? 'selected' : '' }}>{{ __('ديزل') }}</option>
                <option value="بنزين" {{ old('fuel_type') == 'بنزين' ? 'selected' : '' }}>{{ __('بنزين') }}</option>
            </select>
        </div>

        {{-- 7. المخصص الشهري --}}
        <div class="mt-4">
            <x-input-label for="monthly_allowance" :value="__('المخصص الشهري (باللتر)')" />
            <x-text-input id="monthly_allowance" class="block mt-1 w-full" type="number" name="monthly_allowance" :value="old('monthly_allowance')" />
        </div>

        {{-- 8. تاريخ بدء سريان المخصص --}}
        <div class="mt-4">
            <x-input-label for="effective_date" :value="__('تاريخ بدء سريان المخصص')" />
            <x-text-input id="effective_date" class="block mt-1 w-full" type="date" name="effective_date" :value="old('effective_date')" />
        </div>

        {{-- 9. مستودع التزويد --}}
        <div class="mt-4">
            <x-input-label for="supply_warehouse" :value="__('مستودع التزويد (نص)')" />
            <x-text-input id="supply_warehouse" class="block mt-1 w-full" type="text" name="supply_warehouse" :value="old('supply_warehouse')" />
        </div>

        <h4 class="text-lg font-medium text-gray-800 mt-6 mb-4 border-b pb-2">{{ __('بيانات الموقع') }}</h4>

        {{-- 10. العنوان وأقرب نقطة دالة --}}
        <div class="mt-4">
            <x-input-label for="address" :value="__('العنوان التفصيلي')" />
            <textarea id="address" name="address" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">{{ old('address') }}</textarea>
        </div>
        <div class="mt-4">
            <x-input-label for="nearest_landmark" :value="__('أقرب نقطة دالة')" />
            <x-text-input id="nearest_landmark" class="block mt-1 w-full" type="text" name="nearest_landmark" :value="old('nearest_landmark')" />
        </div>
        
        {{-- 11.  حقلي الإحداثيات --}}
        <h4 class="text-lg font-medium text-gray-800 mt-6 mb-4 border-b pb-2">{{ __('الإحداثيات الجغرافية (GPRS)') }}</h4>

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

    </div>
</div>