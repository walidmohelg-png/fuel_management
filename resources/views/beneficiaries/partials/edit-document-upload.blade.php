@php
    // جلب الوثائق الموجودة في قاعدة البيانات وتصنيفها حسب النوع (Key by document_type)
    $savedDocuments = $company->documents->keyBy('document_type');
    
    // تعريف قائمة الوثائق وأنواعها
    $documentTypes = [
        'contract' => 'العقد',
        'release' => 'إخلاء الطرف',
        'safety' => 'موافقة السلامة',
        'tax' => 'السداد الضريبي',
        'license' => 'الترخيص',
    ];
    $statuses = [
        'ساري' => 'ساري',
        'منتهي' => 'منتهي',
        'لا يوجد' => 'لا يوجد',
        'محضر اتفاق' => 'محضر اتفاق',
        'مستوفي' => 'مستوفي',
        'غير مستوفي' => 'غير مستوفي',
    ];
@endphp

<div class="overflow-x-auto">
    <table class="min-w-full divide-y divide-gray-200">
        <thead class="bg-gray-50">
            <tr>
                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('نوع الوثيقة') }}</th>
                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('حالة الوثيقة') }}</th>
                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('تاريخ الانتهاء') }}</th>
                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('الملف المرفوع') }}</th>
                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('تعديل/رفع جديد') }}</th>
            </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200">
            
            @foreach ($documentTypes as $type => $label)
                @php
                    // جلب البيانات المحفوظة للوثيقة الحالية
                    $doc = $savedDocuments->get($type);
                @endphp
                
                <tr class="hover:bg-gray-50">
                    {{-- نوع الوثيقة (ثابت) --}}
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                        {{ __($label) }}
                        <input type="hidden" name="documents[{{ $type }}][type]" value="{{ $type }}">
                    </td>
                    
                    {{-- حالة الوثيقة --}}
                    <td class="px-6 py-4 whitespace-nowrap">
                        <select name="documents[{{ $type }}][status]" class="w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm text-sm">
                            @foreach ($statuses as $val => $text)
                                {{-- قراءة القيمة المحفوظة --}}
                                <option value="{{ $val }}" {{ old("documents.$type.status", $doc->status ?? 'لا يوجد') == $val ? 'selected' : '' }}>{{ $text }}</option>
                            @endforeach
                        </select>
                    </td>

                    {{-- تاريخ الانتهاء --}}
                    <td class="px-6 py-4 whitespace-nowrap">
                        {{-- قراءة القيمة المحفوظة --}}
                        <input type="date" name="documents[{{ $type }}][expiry_date]" value="{{ old("documents.$type.expiry_date", $doc->expiry_date ?? '') }}" class="w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm text-sm" />
                    </td>

                    {{-- الملف المرفوع حالياً --}}
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                        @if($doc->file_path ?? false)
                            {{-- عرض رابط للملف المحفوظ --}}
                            <a href="{{ asset('storage/' . $doc->file_path) }}" target="_blank" class="text-blue-600 hover:text-blue-800">
                                {{ __('مشاهدة الملف') }}
                            </a>
                        @else
                            {{ __('لا يوجد ملف مرفوع') }}
                        @endif
                    </td>
                    
                    {{-- حقل رفع ملف جديد --}}
                    <td class="px-6 py-4 whitespace-nowrap">
                        <input type="file" name="documents[{{ $type }}][file]" class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 focus:outline-none" />
                    </td>
                </tr>
            @endforeach
            
        </tbody>
    </table>
    
    {{-- الملاحظات العامة (من جدول CompanyDetails) --}}
    <div class="mt-8">
        <x-input-label for="notes" :value="__('ملاحظات عامة حول الشركة أو العقد')" />
        {{-- قراءة القيمة المحفوظة --}}
        <textarea id="notes" name="notes" rows="3" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">{{ old('notes', $company->details->notes ?? '') }}</textarea>
    </div>
</div>