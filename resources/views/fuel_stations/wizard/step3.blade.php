<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('إضافة محطة وقود جديدة - الخطوة 3/3') }}
        </h2>
    </x-slot>

    <div class="py-10">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-md sm:rounded-lg p-6">

                <h3 class="text-lg font-semibold text-gray-900 mb-4">{{ __('المستندات والمعلومات النهائية') }}</h3>

                <form action="{{ route('fuel_stations.create.storeStep3', ['fuelStation' => $fuelStation->id]) }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <h4 class="text-md font-semibold text-gray-800 mb-4">{{ __('بيانات المستندات') }}</h4>
                    <div id="documents-container">
                        @php
                            // Determine the starting index for new documents
                            $startIndex = $fuelStationDocuments->count();
                            // If there are old inputs for documents, we need to handle them for re-population
                            $oldDocuments = old('documents', []);
                        @endphp

                        {{-- Loop through existing documents or old inputs if validation failed --}}
                        @forelse ($fuelStationDocuments as $index => $doc)
                            @php
                                $currentDocData = $oldDocuments[$index] ?? null;
                            @endphp
                            <div class="document-item border-t border-gray-200 pt-6 mt-6 first:border-t-0 first:mt-0 first:pt-0">
                                <input type="hidden" name="documents[{{ $index }}][id]" value="{{ $doc->id }}">

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-4">
                                    <div>
                                        <label for="document_type_{{ $index }}" class="block text-sm font-medium text-gray-700">{{ __('نوع المستند') }} <span class="text-red-500">*</span></label>
                                        <input type="text" name="documents[{{ $index }}][document_type]" id="document_type_{{ $index }}"
                                               value="{{ $currentDocData['document_type'] ?? $doc->document_type }}"
                                               class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm @error('documents.'.$index.'.document_type') border-red-500 @enderror">
                                        @error('documents.'.$index.'.document_type')
                                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div>
                                        <label for="document_status_{{ $index }}" class="block text-sm font-medium text-gray-700">{{ __('حالة المستند') }}</label>
                                        <select name="documents[{{ $index }}][document_status]" id="document_status_{{ $index }}"
                                                class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm @error('documents.'.$index.'.document_status') border-red-500 @enderror">
                                            @php
                                                $selectedStatus = $currentDocData['document_status'] ?? $doc->document_status;
                                            @endphp
                                            <option value="">{{ __('اختر حالة المستند') }}</option>
                                            @foreach($documentStatuses as $status)
                                                <option value="{{ $status }}" {{ $selectedStatus == $status ? 'selected' : '' }}>{{ __($status) }}</option>
                                            @endforeach
                                        </select>
                                        @error('documents.'.$index.'.document_status')
                                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div>
                                        <label for="expiry_date_{{ $index }}" class="block text-sm font-medium text-gray-700">{{ __('تاريخ الانتهاء') }}</label>
                                        <input type="date" name="documents[{{ $index }}][expiry_date]" id="expiry_date_{{ $index }}"
                                               value="{{ $currentDocData['expiry_date'] ?? ($doc->expiry_date?->format('Y-m-d') ?? '') }}"
                                               class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm @error('documents.'.$index.'.expiry_date') border-red-500 @enderror">
                                        @error('documents.'.$index.'.expiry_date')
                                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div class="col-span-1">
                                        <label for="notes_{{ $index }}" class="block text-sm font-medium text-gray-700">{{ __('ملاحظات المستند') }}</label>
                                        <textarea name="documents[{{ $index }}][notes]" id="notes_{{ $index }}" rows="1"
                                                  class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm @error('documents.'.$index.'.notes') border-red-500 @enderror">{{ $currentDocData['notes'] ?? $doc->notes }}</textarea>
                                        @error('documents.'.$index.'.notes')
                                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div class="col-span-2">
                                        <label for="document_file_{{ $index }}" class="block text-sm font-medium text-gray-700">{{ __('ملف المستند') }}</label>
                                        <input type="file" name="documents[{{ $index }}][file]" id="document_file_{{ $index }}"
                                               class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 @error('documents.'.$index.'.file') border-red-500 @enderror">
                                        @if ($doc->document_file)
                                            <p class="text-xs text-gray-500 mt-1">
                                                {{ __('الملف الحالي:') }}
                                                <a href="{{ route('fuel_stations.documents.view', ['fuel_station' => $fuelStation->id, 'document' => $doc->id]) }}" target="_blank" class="text-blue-600 hover:underline">{{ basename($doc->document_file) }}</a>
                                                <label class="inline-flex items-center ml-4">
                                                    <input type="checkbox" name="documents[{{ $index }}][delete]" value="1" class="rounded border-gray-300 text-red-600 shadow-sm focus:ring-red-500">
                                                    <span class="ml-2 text-sm text-red-600">{{ __('حذف') }}</span>
                                                </label>
                                            </p>
                                        @endif
                                        @error('documents.'.$index.'.file')
                                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        @empty
                            {{-- Default empty document fields for new entry if no existing documents --}}
                            <div class="document-item">
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-4">
                                    <div>
                                        <label for="document_type_0" class="block text-sm font-medium text-gray-700">{{ __('نوع المستند') }} <span class="text-red-500">*</span></label>
                                        <input type="text" name="documents[0][document_type]" id="document_type_0"
                                               value="{{ old('documents.0.document_type') }}"
                                               class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm @error('documents.0.document_type') border-red-500 @enderror">
                                        @error('documents.0.document_type')
                                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div>
                                        <label for="document_status_0" class="block text-sm font-medium text-gray-700">{{ __('حالة المستند') }}</label>
                                        <select name="documents[0][document_status]" id="document_status_0"
                                                class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm @error('documents.0.document_status') border-red-500 @enderror">
                                            @php
                                                $currentStatus = old('documents.0.document_status', 'لا يوجد');
                                            @endphp
                                            <option value="">{{ __('اختر حالة المستند') }}</option>
                                            @foreach($documentStatuses as $status)
                                                <option value="{{ $status }}" {{ $currentStatus == $status ? 'selected' : '' }}>{{ __($status) }}</option>
                                            @endforeach
                                        </select>
                                        @error('documents.0.document_status')
                                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div>
                                        <label for="expiry_date_0" class="block text-sm font-medium text-gray-700">{{ __('تاريخ الانتهاء') }}</label>
                                        <input type="date" name="documents[0][expiry_date]" id="expiry_date_0"
                                               value="{{ old('documents.0.expiry_date') }}"
                                               class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm @error('documents.0.expiry_date') border-red-500 @enderror">
                                        @error('documents.0.expiry_date')
                                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div class="col-span-1">
                                        <label for="notes_0" class="block text-sm font-medium text-gray-700">{{ __('ملاحظات المستند') }}</label>
                                        <textarea name="documents[0][notes]" id="notes_0" rows="1"
                                                  class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm @error('documents.0.notes') border-red-500 @enderror">{{ old('documents.0.notes') }}</textarea>
                                        @error('documents.0.notes')
                                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div class="col-span-2">
                                        <label for="document_file_0" class="block text-sm font-medium text-gray-700">{{ __('ملف المستند') }}</label>
                                        <input type="file" name="documents[0][file]" id="document_file_0"
                                               class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 @error('documents.0.file') border-red-500 @enderror">
                                        @error('documents.0.file')
                                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        @endforelse
                    </div>

                    <button type="button" id="add-document-btn" class="mt-4 bg-indigo-500 hover:bg-indigo-600 text-white px-4 py-2 rounded-md shadow-sm">{{ __('إضافة مستند آخر') }}</button>


                    <h4 class="text-md font-semibold text-gray-800 mb-4 mt-8">{{ __('بيانات العمالة وتواريخ الفحص') }}</h4>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        {{-- عدد العمالة --}}
                        <div>
                            <label for="number_of_workers" class="block text-sm font-medium text-gray-700">{{ __('عدد العمالة') }} <span class="text-red-500">*</span></label>
                            <input type="number" name="number_of_workers" id="number_of_workers"
                                   value="{{ old('number_of_workers', $fuelStationDetail->number_of_workers ?? '') }}"
                                   min="0"
                                   class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm @error('number_of_workers') border-red-500 @enderror">
                            @error('number_of_workers')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- حالة الشهادة الصحية للعمالة --}}
                        <div>
                            <label for="workers_health_status" class="block text-sm font-medium text-gray-700">{{ __('حالة الشهادة الصحية للعمالة') }} <span class="text-red-500">*</span></label>
                            <select name="workers_health_status" id="workers_health_status"
                                    class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm @error('workers_health_status') border-red-500 @enderror">
                                @php
                                    $healthStatuses = ['موجودة', 'غير موجودة'];
                                    $currentHealthStatus = old('workers_health_status', $fuelStationDetail->workers_health_status ?? '');
                                @endphp
                                <option value="">{{ __('اختر حالة الشهادة') }}</option>
                                @foreach($healthStatuses as $status)
                                    <option value="{{ $status }}" {{ $currentHealthStatus == $status ? 'selected' : '' }}>{{ __($status) }}</option>
                            @endforeach
                        </select>
                        @error('workers_health_status')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- تاريخ آخر معايرة --}}
                    <div>
                        <label for="last_calibration" class="block text-sm font-medium text-gray-700">{{ __('تاريخ آخر معايرة') }}</label>
                        <input type="date" name="last_calibration" id="last_calibration"
                               value="{{ old('last_calibration', $fuelStationDetail->last_calibration ?? '') }}"
                               class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm @error('last_calibration') border-red-500 @enderror">
                        @error('last_calibration')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- تاريخ آخر زيارة تفتيش --}}
                    <div>
                        <label for="last_inspection" class="block text-sm font-medium text-gray-700">{{ __('تاريخ آخر زيارة تفتيش') }}</label>
                        <input type="date" name="last_inspection" id="last_inspection"
                               value="{{ old('last_inspection', $fuelStationDetail->last_inspection ?? '') }}"
                               class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm @error('last_inspection') border-red-500 @enderror">
                        @error('last_inspection')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- ملاحظات عامة للخطوة 3 --}}
                    <div class="md:col-span-2">
                        <label for="general_notes" class="block text-sm font-medium text-gray-700">{{ __('ملاحظات عامة') }}</label>
                        <textarea name="general_notes" id="general_notes" rows="3"
                                  class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm @error('general_notes') border-red-500 @enderror">{{ old('general_notes', $fuelStationDetail->general_notes ?? '') }}</textarea>
                        @error('general_notes')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>


                <div class="flex justify-between mt-8">
                    <a href="{{ route('fuel_stations.create.step2', ['fuelStation' => $fuelStation->id]) }}"
                       class="bg-gray-400 hover:bg-gray-500 text-white font-bold py-2 px-4 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-300">
                        {{ __('السابق') }}
                    </a>
                    <button type="submit"
                            class="bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-4 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                        {{ __('إنهاء وحفظ') }}
                    </button>
                </div>
            </form>

        </div>
    </div>
</div>

<script>
    // JavaScript لتمكين إضافة حقول مستندات ديناميكية
    document.addEventListener('DOMContentLoaded', function() {
        const addDocumentBtn = document.getElementById('add-document-btn');
        const documentsContainer = document.getElementById('documents-container');
        let documentIndex = {{ $startIndex }}; // Start index after existing docs or 0 if no existing.

        // Make documentStatuses available in JS
        const documentStatuses = @json($documentStatuses);

        function createNewDocumentFields(index) {
            const newDocumentHtml = `
                <div class="document-item border-t border-gray-200 pt-6 mt-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-4">
                        <div>
                            <label for="document_type_${index}" class="block text-sm font-medium text-gray-700">{{ __('نوع المستند') }} <span class="text-red-500">*</span></label>
                            <input type="text" name="documents[${index}][document_type]" id="document_type_${index}"
                                   value=""
                                   class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                        </div>

                        <div>
                            <label for="document_status_${index}" class="block text-sm font-medium text-gray-700">{{ __('حالة المستند') }}</label>
                            <select name="documents[${index}][document_status]" id="document_status_${index}"
                                    class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                <option value="">{{ __('اختر حالة المستند') }}</option>
                                ${documentStatuses.map(status => `<option value="${status}">${status}</option>`).join('')}
                            </select>
                        </div>

                        <div>
                            <label for="expiry_date_${index}" class="block text-sm font-medium text-gray-700">{{ __('تاريخ الانتهاء') }}</label>
                            <input type="date" name="documents[${index}][expiry_date]" id="expiry_date_${index}"
                                   value=""
                                   class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                        </div>

                        <div class="col-span-1">
                            <label for="notes_${index}" class="block text-sm font-medium text-gray-700">{{ __('ملاحظات المستند') }}</label>
                            <textarea name="documents[${index}][notes]" id="notes_${index}" rows="1"
                                      class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"></textarea>
                        </div>

                        <div class="col-span-2">
                            <label for="document_file_${index}" class="block text-sm font-medium text-gray-700">{{ __('ملف المستند') }}</label>
                            <input type="file" name="documents[${index}][file]" id="document_file_${index}"
                                   class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                        </div>
                    </div>
                    <button type="button" class="remove-document-btn mt-2 bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded-md shadow-sm text-sm">{{ __('إزالة المستند') }}</button>
                </div>
            `;
            return newDocumentHtml;
        }


        addDocumentBtn.addEventListener('click', function() {
            documentsContainer.insertAdjacentHTML('beforeend', createNewDocumentFields(documentIndex));
            documentIndex++;
            attachRemoveListeners(); // Attach listener to the new remove button
        });

        // Function to attach remove listeners (for dynamically added buttons)
        function attachRemoveListeners() {
            document.querySelectorAll('.remove-document-btn').forEach(button => {
                button.onclick = function() {
                    // Find the closest parent .document-item and remove it
                    this.closest('.document-item').remove();
                };
            });
        }

        // Attach listeners to any initial remove buttons (if they existed, which they don't for new docs here, but good practice)
        attachRemoveListeners();
    });
</script>

</x-app-layout>