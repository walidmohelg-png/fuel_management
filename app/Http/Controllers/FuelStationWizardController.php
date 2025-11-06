<?php

namespace App\Http\Controllers;

use App\Models\Distributor;
use App\Models\FuelStation;
use App\Models\FuelStationDocument;
use App\Models\FuelStationDetail; // تأكد من استيراد هذا
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Storage;

class FuelStationWizardController extends Controller
{
    /**
     * عرض نموذج الخطوة 1: معلومات المحطة الأساسية والمالك.
     */
    public function createStep1(Request $request)
    {
        $distributors = Distributor::all(); // لجلب شركات التوزيع

        $fuelStation = null;
        // التحقق مما إذا كان هناك station_id محفوظ في الـ Session لاستئناف العملية
        if (Session::has('current_fuel_station_id')) {
            $stationId = Session::get('current_fuel_station_id');
            $fuelStation = FuelStation::find($stationId);
        }

        // جلب المناطق والمدن لملء القوائم المنسدلة
        $regions = FuelStation::select('region')->distinct()->pluck('region')->filter()->toArray();
        $cities = FuelStation::select('city')->distinct()->pluck('city')->filter()->toArray();

        return view('fuel_stations.wizard.step1', compact('distributors', 'fuelStation', 'regions', 'cities'));
    }

    /**
     * حفظ بيانات الخطوة 1: معلومات المحطة الأساسية والمالك.
     */
    public function storeStep1(Request $request)
    {
        $validatedData = $request->validate([
            'distributor_id'  => 'required|exists:distributors,id',
            'station_name'    => 'required|string|max:255',
            'station_number'  => 'required|string|max:255', // Unique rule will be more complex here, maybe custom rule
            'city'            => 'required|string|max:255',
            'region'          => 'nullable|string|max:255',
            'address'         => 'nullable|string|max:255',
            'latitude'        => 'nullable|numeric',
            'longitude'       => 'nullable|numeric',
            'owner_name'      => 'required|string|max:255',
            'owner_phone'     => 'required|string|max:20',
            'owner_nid'       => 'nullable|string|max:255',
            'owner_passport'  => 'nullable|string|max:255',
            'owner_photo'     => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // للتعامل مع رفع الصور
        ]);

        $stationId = Session::get('current_fuel_station_id');
        if ($stationId) {
            $fuelStation = FuelStation::find($stationId);
            $fuelStation->update($validatedData);
        } else {
            $fuelStation = FuelStation::create($validatedData);
            FuelStationDetail::firstOrCreate(['station_id' => $fuelStation->id]);
            Session::put('current_fuel_station_id', $fuelStation->id); // حفظ الـ ID في الـ Session
        }

        // معالجة رفع الصورة إذا كانت موجودة
        if ($request->hasFile('owner_photo')) {
            $path = $request->file('owner_photo')->store('owner_photos', 'public');
            $fuelStation->owner_photo = $path;
            $fuelStation->save();
        }

        return redirect()->route('fuel_stations.create.step2', ['fuelStation' => $fuelStation->id]);
    }

     /**
     * عرض نموذج الخطوة 2: تفاصيل التشغيل والموظفين.
     * يستقبل FuelStation Model Bound من الـ URL.
     */
    public function createStep2(Request $request, FuelStation $fuelStation)
    {
        if (!$fuelStation->id) {
            return redirect()->route('fuel_stations.create.step1')->with('error', 'الرجاء إكمال الخطوة الأولى أولاً.');
        }

        $fuelStationDetail = $fuelStation->details;

        return view('fuel_stations.wizard.step2', compact('fuelStation', 'fuelStationDetail'));
    }

    /**
     * حفظ بيانات الخطوة 2: تفاصيل التشغيل والموظفين.
     */
    public function storeStep2(Request $request, FuelStation $fuelStation)
    {
        if (!$fuelStation->id) {
            return redirect()->route('fuel_stations.create.step1')->with('error', 'حدث خطأ. الرجاء البدء من الخطوة الأولى.');
        }

        $validatedData = $request->validate([
            // بيانات المشرف (من جدول FuelStation) - لا تغيير هنا
            'supervisor_name'       => 'nullable|string|max:255',
            'supervisor_phone'      => 'nullable|string|max:20',
            'supervisor_nid'        => 'nullable|string|max:255',
            'supervisor_passport'   => 'nullable|string|max:255',
            'supervisor_photo'      => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',

            // تفاصيل التشغيل والسلامة (من جدول FuelStationDetail)
            'fuel_type'             => 'nullable|string|max:255',
            'fuel_quantity'         => 'nullable|numeric',
            'tank_count'            => 'nullable|integer',
            'meter_before'          => 'nullable|numeric',
            'meter_after'           => 'nullable|numeric',

            // ✅ تعديل حقل أيام التزويد
            'supply_days_option'    => ['nullable', Rule::in(['يومياً', 'يوم بعد يوم', 'يوم واحد في الأسبوع', 'يومان في الأسبوع'])],
            // في حال رغبت بتخزين القيمة النصية مباشرة في عمود supply_days

            'fire_equipment'        => 'boolean',
            'signs'                 => 'boolean',
            'lighting'              => 'boolean',
            'flooring'              => 'boolean',
            'electrical_materials'  => 'boolean',
            'cameras'               => 'boolean',
            'cleanliness'           => 'boolean',

            // ✅ تعديل حقول العقد
            'station_contract_number'   => 'nullable|string|max:255',
            'station_contract_status'   => ['nullable', Rule::in(['ساري', 'منتهي'])],

            // ✅ تعديل حقول الترخيص
            'license_number'            => 'nullable|string|max:255',
            'license_status'            => ['nullable', Rule::in(['صالح', 'منتهي الصلاحية'])],

            // ✅ إزالة حقل العمالة من هنا
            // 'workers_health_status' => 'nullable|string|max:255',

            'last_calibration'      => 'nullable|date',
            'last_inspection'       => 'nullable|date',
        ]);

        // تحديث بيانات المشرف في جدول FuelStation
        $fuelStation->update($request->only([
            'supervisor_name', 'supervisor_phone', 'supervisor_nid',
            'supervisor_passport'
        ]));

        // معالجة رفع صورة المشرف
        if ($request->hasFile('supervisor_photo')) {
            $path = $request->file('supervisor_photo')->store('supervisor_photos', 'public');
            $fuelStation->supervisor_photo = $path;
            $fuelStation->save();
        }

        // تحضير بيانات FuelStationDetail
        $detailData = $request->only([
            'fuel_type', 'fuel_quantity', 'tank_count', 'meter_before',
            'meter_after', 'fire_equipment', 'signs', 'lighting',
            'flooring', 'electrical_materials', 'cameras', 'cleanliness',
            'last_calibration', 'last_inspection'
        ]);

        // ✅ معالجة حقل أيام التزويد
        $detailData['supply_days'] = $request->input('supply_days_option');

        // ✅ معالجة حقول العقد والترخيص - يجب أن تكون هذه الأعمدة موجودة في جدول fuel_station_details
        $detailData['station_contract'] = $request->input('station_contract_number'); // حفظ الرقم في نفس العمود
        $detailData['station_contract_status'] = $request->input('station_contract_status'); // عمود جديد في details
        $detailData['license'] = $request->input('license_number'); // حفظ الرقم في نفس العمود
        $detailData['license_status'] = $request->input('license_status'); // عمود جديد في details


        if (!$fuelStation->details) {
            FuelStationDetail::create(array_merge($detailData, ['station_id' => $fuelStation->id]));
        } else {
            $fuelStation->details->update($detailData);
        }


        // ✅ إزالة حقل العمالة من بيانات التفاصيل
        // إذا كنت تنوي نقلها، فلا يجب حفظها هنا.

            FuelStationDetail::updateOrCreate(
            ['station_id' => $fuelStation->id],
            $detailData
        );


        return redirect()->route('fuel_stations.create.step3', ['fuelStation' => $fuelStation->id]);
    }

    /**
     * عرض نموذج الخطوة 3: المستندات، عدد العمالة، الشهادة الصحية، تواريخ المعايرة والتفتيش، الملاحظات.
     */
     public function createStep3(FuelStation $fuelStation)
    {
        if (!$fuelStation->id) {
            return redirect()->route('fuel_stations.create.step1')->with('error', 'حدث خطأ. الرجاء البدء من الخطوة الأولى.');
        }

        // 🆕 جلب تفاصيل المحطة والمستندات الموجودة
        $fuelStation->load(['details', 'documents']);
        $fuelStationDetail = $fuelStation->details;
        $fuelStationDocuments = $fuelStation->documents; // Collection of FuelStationDocument models

        // لتمريرها إلى JavaScript
        $documentStatuses = ['ساري', 'منتهي', 'غير مستوفي', 'لا يوجد'];

        return view('fuel_stations.wizard.step3', compact('fuelStation', 'fuelStationDetail', 'fuelStationDocuments', 'documentStatuses'));
    }


    /**
     * حفظ بيانات الخطوة 3: المستندات، عدد العمالة، الشهادة الصحية، تواريخ المعايرة والتفتيش، الملاحظات.
     */
        public function storeStep3(Request $request, FuelStation $fuelStation)
    {
        // التحقق من وجود معرف لمحطة الوقود
        if (!$fuelStation->id) {
            return redirect()->route('fuel_stations.create.step1')->with('error', 'حدث خطأ. الرجاء البدء من الخطوة الأولى.');
        }

        // ✅ قواعد التحقق من صحة البيانات
        $validatedData = $request->validate([
            // بيانات المستندات (مع الملفات)
            'documents.*.id'              => 'nullable|integer|exists:fuel_station_documents,id', // 🆕 إذا كان المستند موجوداً
            'documents.*.document_type'   => 'required|string|max:255', // 🚨 جعل النوع مطلوباً لضمان التمييز
            'documents.*.document_status' => ['nullable', Rule::in(['ساري', 'منتهي', 'غير مستوفي', 'لا يوجد'])],
            'documents.*.expiry_date'     => 'nullable|date',
            'documents.*.notes'           => 'nullable|string|max:1000',
            'documents.*.file'            => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:10240', // 👈 قاعدة تحقق لملف المستند (10MB كحد أقصى)
            'documents.*.delete'          => 'nullable|boolean', // 🆕 لإتاحة حذف مستند موجود

            // بيانات العمالة وتفاصيل أخرى (تُحفظ في FuelStationDetail)
            'number_of_workers'     => 'required|integer|min:0',
            'workers_health_status' => ['required', Rule::in(['موجودة', 'غير موجودة'])],
            'last_calibration'      => 'nullable|date',
            'last_inspection'       => 'nullable|date',
            'general_notes'         => 'nullable|string|max:1000',
        ]);

        // 1. معالجة وحفظ المستندات
        if ($request->has('documents')) {
            foreach ($request->input('documents') as $index => $documentData) {
                $documentId = $documentData['id'] ?? null;
                $file = $request->file('documents.'.$index.'.file');

                // 🆕 منطق حذف المستند إذا تم تحديد ذلك
                if (isset($documentData['delete']) && $documentData['delete'] && $documentId) {
                    $existingDocument = FuelStationDocument::find($documentId);
                    if ($existingDocument && $existingDocument->station_id === $fuelStation->id) {
                        if ($existingDocument->document_file) {
                            Storage::disk('public')->delete($existingDocument->document_file);
                        }
                        $existingDocument->delete();
                    }
                    continue; // الانتقال للمستند التالي بعد الحذف
                }

                $filePath = null;
                $existingDocument = null;

                // إذا كان هناك ID، حاول العثور على المستند الموجود
                if ($documentId) {
                    $existingDocument = FuelStationDocument::where('id', $documentId)
                                                          ->where('station_id', $fuelStation->id)
                                                          ->first();
                }

                // إذا تم رفع ملف جديد، قم بتخزينه
                if ($file) {
                    // إذا كان هناك مستند موجود ولديه ملف قديم، احذفه أولاً
                    if ($existingDocument && $existingDocument->document_file) {
                        Storage::disk('public')->delete($existingDocument->document_file);
                    }
                    $filePath = $file->store('fuel_station_documents', 'public');
                } elseif ($existingDocument) {
                    // إذا لم يتم رفع ملف جديد ولكن المستند موجود، احتفظ بالمسار الحالي
                    $filePath = $existingDocument->document_file;
                }

                $documentToSave = array_merge($documentData, [
                    'station_id'    => $fuelStation->id,
                    'document_file' => $filePath,
                ]);

                // 🆕 استخدام updateOrCreate مع ID لتحديث المستندات الموجودة أو إنشاء الجديدة
                // إذا لم يتم توفير id (أي مستند جديد)، سيتم إنشاء سجل جديد.
                // إذا تم توفير id، سيتم البحث عن المستند بهذا الـ ID وتحديثه.
                FuelStationDocument::updateOrCreate(
                    ['id' => $documentId], // الشرط للبحث عن المستند (بالـ ID إذا كان متوفراً)
                    $documentToSave // البيانات المراد تحديثها أو إنشاءها
                );
            }
        }

        // 2. تحديث تفاصيل محطة الوقود (FuelStationDetail)
        // تفترض أن FuelStationDetail يتم إنشاؤه في خطوة سابقة أو موجود
        if ($fuelStation->details) {
            $fuelStation->details->update([
                'number_of_workers'     => $validatedData['number_of_workers'],
                'workers_health_status' => $validatedData['workers_health_status'],
                'last_calibration'      => $validatedData['last_calibration'] ?? null,
                'last_inspection'       => $validatedData['last_inspection'] ?? null,
                'general_notes'         => $validatedData['general_notes'] ?? null,
            ]);
        } else {
            // في حالة عدم وجود تفاصيل (يجب أن يتم إنشاؤها في الخطوة 1 أو 2 عادةً)
            // ولكن نضيف هذا كحماية
            FuelStationDetail::create([
                'station_id'            => $fuelStation->id,
                'number_of_workers'     => $validatedData['number_of_workers'],
                'workers_health_status' => $validatedData['workers_health_status'],
                'last_calibration'      => $validatedData['last_calibration'] ?? null,
                'last_inspection'       => $validatedData['last_inspection'] ?? null,
                'general_notes'         => $validatedData['general_notes'] ?? null,
            ]);
        }

        // 3. 🚀 إعادة التوجيه بعد إتمام جميع العمليات بنجاح
        return redirect()->route('fuel_stations.show', $fuelStation->id)->with('success', 'تم حفظ بيانات محطة الوقود والمستندات بنجاح.');
    }
}