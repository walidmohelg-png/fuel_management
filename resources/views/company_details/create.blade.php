<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('إضافة تفاصيل شركة جديدة') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <form method="POST" action="{{ route('company_details.store') }}">
                    @csrf

                    <div class="mb-4">
                        <label for="company_id" class="block text-sm font-medium text-gray-700">اختر الشركة</label>
                        <select id="company_id" name="company_id" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                            @foreach($companies as $company)
                                <option value="{{ $company->id }}">{{ $company->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-4">
                        <label for="warehouse_location" class="block text-sm font-medium text-gray-700">موقع المخزن</label>
                        <input type="text" name="warehouse_location" id="warehouse_location" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                    </div>

                    <div class="mb-4">
                        <label for="storage_capacity" class="block text-sm font-medium text-gray-700">السعة التخزينية</label>
                        <input type="number" name="storage_capacity" id="storage_capacity" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                    </div>

                    <div class="mb-4">
                        <label for="number_of_employees" class="block text-sm font-medium text-gray-700">عدد الموظفين</label>
                        <input type="number" name="number_of_employees" id="number_of_employees" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                    </div>

                    <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700">
                        حفظ التفاصيل
                    </button>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
