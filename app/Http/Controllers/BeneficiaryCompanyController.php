<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BeneficiaryCompany;
use App\Models\Distributor;
use App\Models\CompanyDetail;
use App\Models\CompanyDocument;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Log;

class BeneficiaryCompanyController extends Controller
{
    private $sessionKey = 'beneficiary_company_data';

    // ==========================================================
    // عرض قائمة الشركات المستفيدة
    // ==========================================================
    public function index(Request $request)
    {
        // ✅ تأكد من تحميل العلاقة 'companyDetail' دائماً
        $query = BeneficiaryCompany::with(['distributor', 'companyDetail']);

        // 🔍 البحث باسم الشركة أو المفوض
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where('name', 'like', "%$search%")
                  ->orWhereHas('companyDetail', function ($q) use ($search) {
                      $q->where('authorized_person_name', 'like', "%$search%");
                  });
        }

        // 🏙️ التصفية حسب المنطقة
        if ($request->filled('region')) {
            $query->whereHas('companyDetail', function ($q) use ($request) {
                $q->where('region', $request->region);
            });
        }

        // 🏘️ التصفية حسب المدينة
        if ($request->filled('city')) {
            $query->whereHas('companyDetail', function ($q) use ($request) {
                $q->where('city', $request->city);
            });
        }

        // 📊 ترتيب وPagination
        $beneficiaries = $query->latest()->paginate(10);

        return view('beneficiaries.index', compact('beneficiaries'));
    }


    // ==========================================================
    // الخطوة 1 (لإنشاء جديد)
    // ==========================================================
    public function createStep1()
    {
        $distributors = Distributor::select('id', 'name')->get();
        $company_data = Session::get($this->sessionKey, []);

        return view('beneficiaries.steps.create-step1', compact('distributors', 'company_data'));
    }

    public function storeStep1(Request $request)
    {
        $validated = $request->validate([
            'distributor_id' => 'required|exists:distributors,id',
            'name' => 'required|string|max:255',
            'activity_type' => 'required|string|max:255',
            'fuel_code' => 'nullable|string|max:50|unique:beneficiary_companies,fuel_code',
            'region' => 'nullable|string|max:255', // ✅ هذه الحقول لـ CompanyDetail ولكن نجمعها هنا
            'city' => 'nullable|string|max:255',   // ✅ هذه الحقول لـ CompanyDetail ولكن نجمعها هنا
            'address' => 'nullable|string|max:255',
            'latitude' => 'nullable|numeric|between:-90,90',
            'longitude' => 'nullable|numeric|between:-180,180',
            'status' => ['required', Rule::in(['نشطة', 'غير_نشطة', 'موثقة'])],
            'email' => 'nullable|email|max:255', // ✅ تأكد من وجود هذا العمود في beneficiary_companies
            'registration_number' => 'nullable|string|max:255', // ✅ تأكد من وجود هذا العمود في beneficiary_companies
        ]);

        Session::put($this->sessionKey, $validated);

        return redirect()->route('beneficiaries.create_step_2');
    }

    // ==========================================================
    // الخطوة 2 (المفوض والمندوب والمخصصات) (لإنشاء جديد)
    // ==========================================================
    public function createStep2()
    {
        $company_data = Session::get($this->sessionKey, []);
        if (empty($company_data['name'])) {
            return redirect()->route('beneficiaries.create_step_1')
                ->with('error', 'الرجاء إكمال الخطوة الأولى أولاً.');
        }

        return view('beneficiaries.steps.create-step2', compact('company_data'));
    }

   public function storeStep2(Request $request)
    {
        $validatedData = $request->validate([
            'fuel_type' => 'required|string|max:50',
            'monthly_allowance' => 'required|integer',
            'supply_warehouse' => 'required|string|max:255',
            'authorized_person_name' => 'required|string|max:255',
            'authorized_person_phone' => 'required|string|max:50',
            'authorized_person_email' => 'required|email|max:255',
            'representative_name' => 'required|string|max:255',
            'representative_phone' => 'required|string|max:50',
            'representative_email' => 'required|email|max:255',
            'notes' => 'nullable|string',
            'effective_date' => 'required|date',

            'authorized_person_national_id' => 'nullable|string|max:50',
            'authorized_person_passport_no' => 'nullable|string|max:50',
            'representative_national_id' => 'nullable|string|max:50',
            'representative_passport_no' => 'nullable|string|max:50',

            'authorized_person_photo' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'representative_photo' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        // تخزين مسار الصورة الأولى
        $authorizedPhotoPath = null;
        if ($request->hasFile('authorized_person_photo')) {
            $authorizedPhotoPath = $request->file('authorized_person_photo')->store('authorized_photos', 'public');
        }

        // تخزين مسار الصورة الثانية
        $representativePhotoPath = null;
        if ($request->hasFile('representative_photo')) {
            $representativePhotoPath = $request->file('representative_photo')->store('representative_photos', 'public');
        }

        $finalValidatedData = array_merge($validatedData, [
            'authorized_person_photo_path' => $authorizedPhotoPath, // ✅ تغيير الاسم ليتطابق مع الـ Model والجدول بعد الهجرة
            'representative_photo_path' => $representativePhotoPath, // ✅ تغيير الاسم ليتطابق
        ]);

        $step1 = Session::get($this->sessionKey, []);
        Session::put($this->sessionKey, array_merge($step1, $finalValidatedData));

        return redirect()->route('beneficiaries.create_step_3');
    }

    // ==========================================================
    // الخطوة 3 (المراجعة النهائية والحفظ) (لإنشاء جديد)
    // ==========================================================
    public function createStep3()
    {
        $company_data = Session::get($this->sessionKey, []);
        if (empty($company_data['authorized_person_name'])) {
            return redirect()->route('beneficiaries.create_step_2')
                ->with('error', 'الرجاء إكمال الخطوة الثانية أولاً.');
        }

        // بما أننا لا نخزن document_number في الجدول، لن نمرر قيمته هنا
        // لكن نحتاج للتأكد من وجود $beneficiaryCompany->documents في الـ View إذا كان هناك مستندات سابقة
        $dummyDocuments = []; // أو جلب من الـ Session إذا كنت تخزنها هناك مؤقتًا

        return view('beneficiaries.steps.create-step3', compact('company_data', 'dummyDocuments')); // ✅ تمرير dummyDocuments أو البيانات الفعلية
    }

   public function store(Request $request)
    {
        $data = Session::get($this->sessionKey, []);

        if (empty($data)) {
            return redirect()->route('beneficiaries.create_step_1')
                ->with('error', 'البيانات غير موجودة. الرجاء إعادة إدخال الخطوة الأولى.');
        }

        // ✅ إضافة validation لبيانات المستندات التي تأتي من الخطوة الثالثة
        $validator = Validator::make($request->all(), [
            'documents.*.document_type'   => 'nullable|string|max:255',
            'documents.*.document_status' => ['nullable', Rule::in(['ساري', 'منتهي', 'غير مستوفي', 'لا يوجد'])],
            'documents.*.expiry_date'     => 'nullable|date',
            // 'documents.*.document_number' => 'nullable|string|max:255', // ❌ تم إزالة التحقق من document_number
            'documents.*.file'            => 'nullable|file|mimes:pdf,doc,docx,jpg,png|max:5000',
            'documents.*.notes'           => 'nullable|string|max:1000',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $validatedDocuments = $validator->validated()['documents'] ?? [];


        // ✅ 2. إنشاء الشركة المستفيدة (BeneficiaryCompany)
        $company = BeneficiaryCompany::create([
            'distributor_id' => $data['distributor_id'],
            'name' => $data['name'],
            'activity_type' => $data['activity_type'],
            'fuel_code' => $data['fuel_code'] ?? null,
            'current_status' => $data['status'] ?? 'ساري',
            'address' => $data['address'] ?? null,
            'latitude' => $data['latitude'] ?? null,
            'longitude' => $data['longitude'] ?? null,
            'email' => $data['email'] ?? null,
            'registration_number' => $data['registration_number'] ?? null,
        ]);

        // ✅ 3. إنشاء تفاصيل الشركة (CompanyDetail)
        $company->companyDetail()->create([
            'company_id' => $company->id,
            'fuel_type' => $data['fuel_type'],
            'monthly_allowance' => $data['monthly_allowance'],
            'supply_warehouse' => $data['supply_warehouse'],
            'authorized_person_name' => $data['authorized_person_name'],
            'authorized_person_phone' => $data['authorized_person_phone'],
            'authorized_person_email' => $data['authorized_person_email'],
            'authorized_person_photo_path' => $data['authorized_person_photo_path'] ?? null,
            'authorized_person_national_id' => $data['authorized_person_national_id'] ?? null,
            'authorized_person_passport_no' => $data['authorized_person_passport_no'] ?? null,
            'representative_name' => $data['representative_name'],
            'representative_phone' => $data['representative_phone'],
            'representative_email' => $data['representative_email'],
            'representative_photo_path' => $data['representative_photo_path'] ?? null,
            'representative_national_id' => $data['representative_national_id'] ?? null,
            'representative_passport_no' => $data['representative_passport_no'] ?? null,
            'notes' => $data['notes'] ?? null,
            'effective_date' => $data['effective_date'],
            'region' => $data['region'] ?? null,
            'city' => $data['city'] ?? null,
        ]);

        // ✅ 4. حفظ المستندات من الخطوة الثالثة
        foreach ($validatedDocuments as $docData) {
            $path = null;
            if (isset($docData['file']) && $docData['file'] instanceof \Illuminate\Http\UploadedFile) {
                $path = $docData['file']->store('company_documents', 'public');
            }

             $company->documents()->create([
                'document_type' => $docData['document_type'] ?? null,
                'document_status' => $docData['document_status'] ?? 'غير محدد',
                'expiry_date' => $docData['expiry_date'] ?? null,
                // 'document_number' => $docData['document_number'] ?? null, // ❌ تم إزالته
                'document_file' => $path, // ✅ استخدام الاسم الصحيح 'document_file'
                'notes' => $docData['notes'] ?? null,
            ]);
        }

        Session::forget($this->sessionKey);

        return redirect()->route('beneficiaries.index')
            ->with('success', 'تم حفظ الشركة المستفيدة بنجاح 🎉');
    }

    // ==========================================================
    // دوال CRUD الأخرى (Show, Edit, Update, Destroy)
    // ==========================================================

    public function show(BeneficiaryCompany $beneficiaryCompany)
    {
        $beneficiaryCompany->load('companyDetail', 'documents', 'distributor');
        return view('beneficiaries.show', compact('beneficiaryCompany'));
    }

    public function edit(BeneficiaryCompany $beneficiaryCompany)
    {
        $distributors = Distributor::all();
        $beneficiaryCompany->load('companyDetail', 'documents');

        return view('beneficiaries.edit', compact('beneficiaryCompany', 'distributors'));
    }

    public function update(Request $request, BeneficiaryCompany $beneficiaryCompany)
    {
        // 1. التحقق من صحة البيانات
        $validated = $request->validate([
            // بيانات الشركة الأساسية (BeneficiaryCompany)
            'distributor_id'        => 'required|exists:distributors,id',
            'name'                  => 'required|string|max:255',
            'activity_type'         => 'required|string|max:255',
            'fuel_code'             => 'nullable|string|max:50|unique:beneficiary_companies,fuel_code,' . $beneficiaryCompany->id,
            'address'               => 'nullable|string|max:255',
            'latitude'              => 'nullable|numeric|between:-90,90',
            'longitude'             => 'nullable|numeric|between:-180,180',
            'current_status'        => ['required', Rule::in(['نشطة', 'غير_نشطة', 'موثقة'])],
            'email'                 => 'nullable|email|max:255',
            'registration_number'   => 'nullable|string|max:255',

            // بيانات المفوض والممثل والمخصصات (CompanyDetail)
            'fuel_type'             => 'nullable|string|max:50',
            'monthly_allowance'     => 'nullable|integer',
            'supply_warehouse'      => 'nullable|string|max:255',
            'authorized_person_name' => 'nullable|string|max:255',
            'authorized_person_phone' => 'nullable|string|max:50',
            'authorized_person_email' => 'nullable|email|max:255',
            'authorized_person_national_id' => 'nullable|string|max:50',
            'authorized_person_passport_no' => 'nullable|string|max:50',
            'authorized_person_photo' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'representative_name'   => 'nullable|string|max:255',
            'representative_phone'  => 'nullable|string|max:50',
            'representative_email'  => 'nullable|email|max:255',
            'representative_national_id' => 'nullable|string|max:50',
            'representative_passport_no' => 'nullable|string|max:50',
            'representative_photo'  => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'notes'                 => 'nullable|string',
            'effective_date'        => 'nullable|date',
            'region'                => 'nullable|string|max:255',
            'city'                  => 'nullable|string|max:255',

            // بيانات المستندات (CompanyDocument)
            'documents'                     => 'array',
            'documents.*.id'              => 'nullable|exists:company_documents,id',
            'documents.*.document_type'   => 'nullable|string|max:255',
            // 'documents.*.document_number' => 'nullable|string|max:255', // ❌ تم إزالة التحقق من document_number
            'documents.*.expiry_date'     => 'nullable|date',
            'documents.*.document_status' => ['nullable', Rule::in(['ساري', 'منتهي', 'غير مستوفي', 'لا يوجد'])],
            'documents.*.file'            => 'nullable|file|mimes:pdf,doc,docx,jpg,png|max:5000',
            'documents.*.notes'           => 'nullable|string|max:1000',
        ]);

        // 2. فصل البيانات وتحديث سجل BeneficiaryCompany
        $beneficiaryCompanyData = $request->only([
            'distributor_id', 'name', 'activity_type', 'fuel_code',
            'address', 'latitude', 'longitude', 'current_status', 'email',
            'registration_number'
        ]);
        $beneficiaryCompany->update($beneficiaryCompanyData);

        // 3. تحديث أو إنشاء سجل CompanyDetail
        $companyDetailData = $request->only([
            'fuel_type', 'monthly_allowance', 'supply_warehouse',
            'authorized_person_name', 'authorized_person_phone', 'authorized_person_email',
            'authorized_person_national_id', 'authorized_person_passport_no',
            'representative_name', 'representative_phone', 'representative_email',
            'representative_national_id', 'representative_passport_no',
            'notes', 'effective_date', 'region', 'city'
        ]);

        // معالجة رفع صورة المفوض
        if ($request->hasFile('authorized_person_photo')) {
            if ($beneficiaryCompany->companyDetail && $beneficiaryCompany->companyDetail->authorized_person_photo_path) {
                Storage::disk('public')->delete($beneficiaryCompany->companyDetail->authorized_person_photo_path);
            }
            $path = $request->file('authorized_person_photo')->store('authorized_photos', 'public');
            $companyDetailData['authorized_person_photo_path'] = $path;
        }

        // معالجة رفع صورة الممثل
        if ($request->hasFile('representative_photo')) {
            if ($beneficiaryCompany->companyDetail && $beneficiaryCompany->companyDetail->representative_photo_path) {
                Storage::disk('public')->delete($beneficiaryCompany->companyDetail->representative_photo_path);
            }
            $path = $request->file('representative_photo')->store('representative_photos', 'public');
            $companyDetailData['representative_photo_path'] = $path;
        }

        $beneficiaryCompany->companyDetail()->updateOrCreate(
            ['company_id' => $beneficiaryCompany->id],
            $companyDetailData
        );


        // 4. تحديث أو إنشاء سجلات CompanyDocument
        if ($request->has('documents')) {
            foreach ($request->input('documents') as $index => $documentData) {
                $docId = $documentData['id'] ?? null;
                $documentToUpdateOrCreate = $documentData;

                // معالجة رفع ملف المستند
                if ($request->hasFile("documents.$index.file")) {
                    if ($docId) {
                        $oldDocument = CompanyDocument::find($docId);
                        if ($oldDocument && $oldDocument->document_file) {
                             Storage::disk('public')->delete($oldDocument->document_file);
                        }
                    }
                    $filePath = $request->file("documents.$index.file")->store('company_documents', 'public');
                    $documentToUpdateOrCreate['document_file'] = $filePath;
                } else if ($docId && $beneficiaryCompany->documents->find($docId) && $beneficiaryCompany->documents->find($docId)->document_file && !isset($documentData['file'])) {
                    $documentToUpdateOrCreate['document_file'] = $beneficiaryCompany->documents->find($docId)->document_file;
                } else {
                     $documentToUpdateOrCreate['document_file'] = null;
                }
                
                // ❌ تم حذف هذا السطر لأنه يحاول استخدام document_number
                unset($documentToUpdateOrCreate['document_number']); // ✅ حذف document_number من البيانات قبل الحفظ

                unset($documentToUpdateOrCreate['id']); // إزالة ID لتجنب مشاكل Mass Assignment
                $beneficiaryCompany->documents()->updateOrCreate(
                    ['id' => $docId, 'company_id' => $beneficiaryCompany->id],
                    $documentToUpdateOrCreate
                );
            }
        }


        return redirect()->route('beneficiaries.index')
            ->with('success', 'تم تحديث بيانات الشركة المستفيدة بنجاح!');
    }

    /**
     * حذف شركة مستفيدة.
     */
    public function destroy(BeneficiaryCompany $beneficiaryCompany)
    {
        try {
            // Laravel عادةً ما تتعامل مع حذف العلاقات عبر onDelete('cascade') في الهجرة
            // لذا يكفي حذف الشركة الأم
            $beneficiaryCompany->delete();
            return response()->json(['success' => true, 'message' => 'تم حذف الشركة المستفيدة بنجاح.']);
        } catch (\Exception $e) {
            Log::error('Error deleting beneficiary company: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'حدث خطأ أثناء حذف الشركة المستفيدة.'], 500);
        }
    }
}