<?php

namespace App\Http\Controllers;

use App\Models\FuelStation;
use App\Models\Distributor;
use App\Models\FuelStationDetail;
use App\Models\FuelStationDocument;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage; // 🆕 إضافة الواجهة Facade للتخزين

class FuelStationController extends Controller
{
    /**
     * 🔹 عرض قائمة المحطات
     */
    public function index(Request $request)
    {
        $query = FuelStation::with('distributor');

        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('station_name', 'like', "%{$request->search}%")
                  ->orWhere('station_number', 'like', "%{$request->search}%");
            });
        }

        if ($request->filled('region')) {
            $query->where('region', $request->region);
        }

        if ($request->filled('city')) {
            $query->where('city', $request->city);
        }

        $fuelStations = $query->latest()->paginate(10);
        $regions = FuelStation::select('region')->distinct()->pluck('region')->filter()->toArray();
        $cities = FuelStation::select('city')->distinct()->pluck('city')->filter()->toArray();

        return view('fuel_stations.index', compact('fuelStations', 'regions', 'cities'));
    }

    /**
     * 🔹 عرض نموذج إنشاء محطة جديدة
     */
    public function create()
    {
        $distributors = Distributor::all();
        $regions = FuelStation::select('region')->distinct()->pluck('region')->filter()->toArray();
        $cities = FuelStation::select('city')->distinct()->pluck('city')->filter()->toArray();

        return view('fuel_stations.create', compact('distributors', 'regions', 'cities'));
    }

    /**
     * 🔹 حفظ محطة جديدة في قاعدة البيانات
     */
    public function store(Request $request)
    {
        $request->validate([
            'station_name'   => 'required|string|max:255',
            'station_number' => 'required|string|max:255|unique:fuel_stations',
            'city'           => 'required|string|max:255',
            'region'         => 'nullable|string|max:255',
            'address'        => 'nullable|string|max:255',
            'owner_name'     => 'required|string|max:255',
            'owner_phone'    => 'required|string|max:20',
            'distributor_id' => 'required|exists:distributors,id',
        ]);

        $fuelStation = FuelStation::create($request->only([
            'station_name',
            'station_number',
            'city',
            'region',
            'address',
            'owner_name',
            'owner_phone',
            'distributor_id',
        ]));

        // إنشاء سجل التفاصيل الافتراضي تلقائيًا عند إنشاء محطة
        FuelStationDetail::create([
            'station_id' => $fuelStation->id,
        ]);

        return redirect()->route('fuel_stations.index')->with('success', 'تمت إضافة المحطة بنجاح.');
    }

    /**
     * 🔹 عرض تفاصيل محطة محددة
     */
    public function show(FuelStation $fuelStation)
    {
        // تحميل جميع العلاقات المرتبطة
        $fuelStation->load(['distributor', 'details', 'documents']);

        return view('fuel_stations.show', compact('fuelStation'));
    }

    /**
     * 🔹 عرض نموذج تعديل محطة
     */
  public function edit(FuelStation $fuelStation)
{
    // تحميل التفاصيل المرتبطة بالمحطة
    $fuelStation->load(['details', 'documents']);

    // جلب شركات التوزيع
    $distributors = \App\Models\Distributor::all();

    // جلب المناطق المميزة
    $regions = FuelStation::select('region')->distinct()->pluck('region')->filter()->toArray();

    // جلب المدن المميزة
    $cities = FuelStation::select('city')->distinct()->pluck('city')->filter()->toArray();

    return view('fuel_stations.edit', compact('fuelStation', 'distributors', 'regions', 'cities'));
}

 /**
 * 🔹 تحديث بيانات محطة
 */
public function update(Request $request, FuelStation $fuelStation)
{
    // ✅ التحقق من صحة البيانات
    $validated = $request->validate([
        'station_name'   => 'required|string|max:255',
        'station_number' => 'required|string|max:255|unique:fuel_stations,station_number,' . $fuelStation->id,
        'city'           => 'required|string|max:255',
        'region'         => 'nullable|string|max:255',
        'address'        => 'nullable|string|max:255',
        'owner_name'     => 'required|string|max:255',
        'owner_phone'    => 'required|string|max:20',
        'distributor_id' => 'required|exists:distributors,id',
        // --- بيانات المالك والمشرف الإضافية (من جدول FuelStation) ---
        'owner_nid'        => 'nullable|string|max:255',
        'owner_passport'   => 'nullable|string|max:255',
        'owner_photo'      => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        'supervisor_name'  => 'nullable|string|max:255',
        'supervisor_phone' => 'nullable|string|max:20',
        'supervisor_nid'   => 'nullable|string|max:255',
        'supervisor_passport'=> 'nullable|string|max:255',
        'supervisor_photo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',


        // الحقول الإضافية الخاصة بالتفاصيل (من جدول fuel_station_details)
        'fuel_type'               => 'nullable|string|max:255',
        'fuel_quantity'           => 'nullable|numeric',
        'tank_count'              => 'nullable|integer',
        'meter_before'            => 'nullable|numeric',
        'meter_after'             => 'nullable|numeric',
        'supply_days'             => 'nullable|string|max:255',
        'fire_equipment'          => 'nullable|boolean',
        'signs'                   => 'nullable|boolean',
        'lighting'                => 'nullable|boolean',
        'flooring'                => 'nullable|boolean',
        'electrical_materials'    => 'nullable|boolean',
        'cameras'                 => 'nullable|boolean',
        'cleanliness'             => 'nullable|boolean',
        'station_contract'        => 'nullable|string|max:255',
        'station_contract_status' => 'nullable|string|max:255',
        'license'                 => 'nullable|string|max:255',
        'license_status'          => 'nullable|string|max:255',
        'last_calibration'        => 'nullable|date',
        'last_inspection'         => 'nullable|date',
        'number_of_workers'       => 'nullable|integer', // 👈 تم إضافة هذا السطر هنا
        'workers_health_status'   => 'nullable|string|max:255',
    ]);

    // ✅ تحديث بيانات المحطة الرئيسية (FuelStation)
    $fuelStation->update([
        'station_name'   => $validated['station_name'],
        'station_number' => $validated['station_number'],
        'city'           => $validated['city'],
        'region'         => $validated['region'] ?? null,
        'address'        => $validated['address'] ?? null,
        'owner_name'     => $validated['owner_name'],
        'owner_phone'    => $validated['owner_phone'],
        'distributor_id' => $validated['distributor_id'],
        // --- تحديث بيانات المالك والمشرف في جدول FuelStation ---
        'owner_nid'        => $validated['owner_nid'] ?? null,
        'owner_passport'   => $validated['owner_passport'] ?? null,
        'supervisor_name'  => $validated['supervisor_name'] ?? null,
        'supervisor_phone' => $validated['supervisor_phone'] ?? null,
        'supervisor_nid'   => $validated['supervisor_nid'] ?? null,
        'supervisor_passport'=> $validated['supervisor_passport'] ?? null,
    ]);

    // --- معالجة صور المالك والمشرف ---
    if ($request->hasFile('owner_photo')) {
        if ($fuelStation->owner_photo) {
            \Illuminate\Support\Facades\Storage::disk('public')->delete($fuelStation->owner_photo);
        }
        $fuelStation->owner_photo = $request->file('owner_photo')->store('owner_photos', 'public');
        $fuelStation->save();
    }
    if ($request->hasFile('supervisor_photo')) {
        if ($fuelStation->supervisor_photo) {
            \Illuminate\Support\Facades\Storage::disk('public')->delete($fuelStation->supervisor_photo);
        }
        $fuelStation->supervisor_photo = $request->file('supervisor_photo')->store('supervisor_photos', 'public');
        $fuelStation->save();
    }


    // ✅ تحديث التفاصيل المرتبطة إذا كانت موجودة (fuel_station_details)
    if ($fuelStation->details) {
        $fuelStation->details->update([
            'fuel_type'               => $validated['fuel_type'] ?? null,
            'fuel_quantity'           => $validated['fuel_quantity'] ?? null,
            'tank_count'              => $validated['tank_count'] ?? null,
            'meter_before'            => $validated['meter_before'] ?? null,
            'meter_after'             => $validated['meter_after'] ?? null,
            'supply_days'             => $validated['supply_days'] ?? null,
            'fire_equipment'          => $validated['fire_equipment'] ?? false, // تم التغيير هنا لـ false
            'signs'                   => $validated['signs'] ?? false,       // تم التغيير هنا لـ false
            'lighting'                => $validated['lighting'] ?? false,      // تم التغيير هنا لـ false
            'flooring'                => $validated['flooring'] ?? false,      // تم التغيير هنا لـ false
            'electrical_materials'    => $validated['electrical_materials'] ?? false, // تم التغيير هنا لـ false
            'cameras'                 => $validated['cameras'] ?? false,       // تم التغيير هنا لـ false
            'cleanliness'             => $validated['cleanliness'] ?? false,    // تم التغيير هنا لـ false
            'station_contract'        => $validated['station_contract'] ?? null,
            'station_contract_status' => $validated['station_contract_status'] ?? null,
            'license'                 => $validated['license'] ?? null,
            'license_status'          => $validated['license_status'] ?? null,
            'last_calibration'        => $validated['last_calibration'] ?? null,
            'last_inspection'         => $validated['last_inspection'] ?? null,
            'number_of_workers'       => $validated['number_of_workers'] ?? null, // 👈 تم إضافة هذا السطر
            'workers_health_status'   => $validated['workers_health_status'] ?? null,
        ]);
    }

    // --- معالجة المستندات المرفقة (جدول fuel_station_documents) ---
    // هذا الجزء يتطلب منطقاً أكثر تعقيداً إذا كنت تسمح بإضافة/تعديل مستندات متعددة
    // من خلال صفحة التعديل. يتطلب تكرار على $request->documents ومقارنتها بالمستندات الحالية.
    // لكن بما أن الـ view الحالي يظهر فقط المستندات الموجودة ولا يوفر حقولاً لإضافة مستندات جديدة
    // أو تعديلها بشكل ديناميكي، فسيكون هذا فارغاً حالياً.

    // ✅ إعادة التوجيه مع رسالة نجاح
    return redirect()
        ->route('fuel_stations.show', $fuelStation->id)
        ->with('success', 'تم تحديث بيانات المحطة بنجاح.');
}

    /**
     * 🔹 حذف محطة
     */
    public function destroy(FuelStation $fuelStation)
{
    // 🆕 أضف هذا السطر للتسجيل
    \Illuminate\Support\Facades\Log::info('Attempting to delete FuelStation with ID: ' . $fuelStation->id);

    try {
        // 🆕 قم بتحميل العلاقات لحذف أي مستندات أو تفاصيل مرتبطة بالملفات
        // هذه خطوة مهمة لتجنب ترك ملفات يتيمة أو سجلات في جداول أخرى
        $fuelStation->load('documents', 'details');

        // حذف الملفات المرتبطة بالمستندات أولاً
        foreach ($fuelStation->documents as $document) {
            if ($document->document_file) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($document->document_file);
            }
            $document->delete(); // حذف سجل المستند من قاعدة البيانات
        }

        // حذف تفاصيل المحطة (إذا كانت علاقة HasOne)
        if ($fuelStation->details) {
            $fuelStation->details->delete();
        }

        // أخيراً، حذف سجل محطة الوقود نفسه
        $fuelStation->delete();

        \Illuminate\Support\Facades\Log::info('FuelStation with ID: ' . $fuelStation->id . ' deleted successfully.');
        return response()->json(['success' => true, 'message' => 'تم حذف المحطة بنجاح.']); // 🆕 يجب أن تعيد JSON للـ AJAX
    } catch (\Exception $e) {
        \Illuminate\Support\Facades\Log::error('Error deleting fuel station ID: ' . $fuelStation->id . ' - ' . $e->getMessage());
        return response()->json(['success' => false, 'message' => 'حدث خطأ أثناء حذف المحطة: ' . $e->getMessage()], 500); // 🆕 يجب أن تعيد JSON للـ AJAX
    }
}

    /**
     * 🆕 عرض مستند خاص بمحطة وقود
     *
     * @param  \App\Models\FuelStation  $fuelStation
     * @param  \App\Models\FuelStationDocument  $document
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function viewDocument(FuelStation $fuelStation, FuelStationDocument $document)
    {
        // 🔒 التحقق من أن المستند ينتمي إلى محطة الوقود المحددة للأمان
        if ($document->station_id !== $fuelStation->id) {
            abort(404, 'المستند غير موجود لهذه المحطة.');
        }

        // ⚠️ التأكد من وجود مسار الملف في قاعدة البيانات
        // 🚨 تم التعديل هنا: استخدام $document->document_file بدلاً من $document->file_path
        if (!Storage::disk('public')->exists($document->document_file)) {
            Log::warning('File not found for document ID: ' . $document->id . ' at path: ' . $document->document_file);
            abort(404, 'الملف غير موجود.');
        }

        // ✅ إعادة الملف ليتم عرضه في المتصفح
        // 🚨 تم التعديل هنا: استخدام $document->document_file بدلاً من $document->file_path
        return Storage::disk('public')->response($document->document_file, null, ['Content-Type' => Storage::disk('public')->mimeType($document->document_file)]);
    }

    /**
     * 🆕 تنزيل مستند خاص بمحطة وقود
     *
     * @param  \App\Models\FuelStation  $fuelStation
     * @param  \App\Models\FuelStationDocument  $document
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse|\Illuminate\Http\RedirectResponse
     */
    public function downloadDocument(FuelStation $fuelStation, FuelStationDocument $document)
    {
        // 🔒 التحقق من أن المستند ينتمي إلى محطة الوقود المحددة للأمان
        if ($document->station_id !== $fuelStation->id) {
            abort(404, 'المستند غير موجود لهذه المحطة.');
        }

        // ⚠️ التأكد من وجود مسار الملف في قاعدة البيانات
        // 🚨 تم التعديل هنا: استخدام $document->document_file بدلاً من $document->file_path
        if (!Storage::disk('public')->exists($document->document_file)) {
            Log::warning('File not found for document ID: ' . $document->id . ' at path: ' . $document->document_file);
            abort(404, 'الملف غير موجود.');
        }

        // ✅ تحديد اسم الملف للتنزيل
        // إذا كان لديك عمود لاسم الملف الأصلي (مثلاً 'original_name') في جدول fuel_station_documents، استخدمه.
        // وإلا، استخدم basename للحصول على اسم الملف من المسار.
        // 🚨 تم التعديل هنا: استخدام $document->document_file بدلاً من $document->file_path
        $fileName = $document->original_name ?? basename($document->document_file);

        // ✅ إعادة الملف ليتم تنزيله
        // 🚨 تم التعديل هنا: استخدام $document->document_file بدلاً من $document->file_path
        return Storage::disk('public')->download($document->document_file, $fileName);
    }
}