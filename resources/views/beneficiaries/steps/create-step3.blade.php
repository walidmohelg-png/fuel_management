<x-app-layout>
    {{-- 1. استخدام x-slot لتعريف العنوان العلوي (Header) --}}
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            الخطوة 3 من 3: الوثائق والمستندات
        </h2>
    </x-slot>

    {{-- 2. المحتوى الرئيسي (تم تعديل الـ classes لتكون Tailwind CSS) --}}
    <div class="container mx-auto mt-4">
        <form action="{{ route('beneficiaries.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            {{-- تم استبدال div.card بـ div بتنسيق Tailwind --}}
            <div class="bg-white shadow-md p-6 mb-4 rounded-lg">
                <h5 class="mb-4 text-lg font-bold text-gray-700">📑 بيانات المستندات</h5>

                @php
                    $documents = [
                        'العقد' => 'العقد',
                        'إخلاء الطرف' => 'إخلاء الطرف',
                        'موافقة السلامة' => 'موافقة السلامة',
                        'السداد الضريبي' => 'السداد الضريبي',
                        'الترخيص' => 'الترخيص',
                    ];
                @endphp

                {{-- تم استبدال الـ table بتنسيق Tailwind (Grid أو Flexbox) ليكون أكثر مرونة --}}
                <div class="space-y-6">
                    @foreach ($documents as $key => $label)
                        <div class="grid grid-cols-5 gap-4 items-center border-b pb-3">
                            {{-- نوع الوثيقة --}}
                            <div class="col-span-1 font-medium text-gray-800">{{ $label }}</div>
                            
                            {{-- حالة الوثيقة (Dropdown) --}}
                            <div class="col-span-1">
                                <select name="documents[{{ $key }}][status]" class="block w-full border-gray-300 rounded-md shadow-sm mt-1">
                                    <option value="ساري">ساري</option>
                                    <option value="منتهي">منتهي</option>
                                    <option value="غير مستوفي">غير مستوفي</option>
                                    <option value="لا يوجد">لا يوجد</option>
                                    <option value="محضر اتفاق">محضر اتفاق</option>
                                </select>
                            </div>
                            
                            {{-- تاريخ الانتهاء --}}
                            <div class="col-span-1">
                                <input type="date" name="documents[{{ $key }}][expiry_date]" class="block w-full border-gray-300 rounded-md shadow-sm mt-1" />
                            </div>
                            
                            {{-- رفع الملف --}}
                            <div class="col-span-1">
                                <input type="file" name="documents[{{ $key }}][file]" class="block w-full text-sm text-gray-500
                                    file:mr-4 file:py-2 file:px-4
                                    file:rounded-md file:border-0
                                    file:text-sm file:font-semibold
                                    file:bg-blue-50 file:text-blue-700
                                    hover:file:bg-blue-100" 
                                    accept=".pdf,.jpg,.jpeg,.png" />
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            {{-- ملاحظات عامة --}}
            <div class="bg-white shadow-md p-6 mb-6 rounded-lg">
                <div class="mb-3">
                    <label for="notes" class="block text-sm font-medium text-gray-700 mb-1">ملاحظات عامة حول الوثائق أو الشركة</label>
                    <textarea name="notes" class="block w-full border-gray-300 rounded-md shadow-sm mt-1 p-2" rows="3" placeholder="اكتب أي ملاحظات إضافية..."></textarea>
                </div>
            </div>

            {{-- أزرار التنقل (تم تعديلها لتناسب Tailwind) --}}
            <div class="flex justify-between mt-6">
                <a href="{{ route('beneficiaries.create_step_2') }}" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-md hover:bg-gray-300">
                    ⬅ الرجوع للخطوة السابقة
                </a>
                <button type="submit" class="px-6 py-2 bg-green-600 text-white font-semibold rounded-md shadow-md hover:bg-green-700">
                    💾 إنهاء وحفظ الشركة
                </button>
            </div>
        </form>
    </div>
</x-app-layout>