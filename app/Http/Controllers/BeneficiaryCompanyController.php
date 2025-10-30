<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BeneficiaryCompany;
use App\Models\Distributor; // سنحتاج هذا لاحقاً للربط

class BeneficiaryCompanyController extends Controller
{

    /**
     * عرض نموذج الخطوة الثانية (المفوض والمندوب)
     */
    public function createStep2(BeneficiaryCompany $company)
    {
        return view('beneficiaries.create-step2', compact('company'));
    }
     /**
     * حفظ بيانات الخطوة الثانية (المفوض والمندوب)
     */
    public function storeStep2(Request $request, BeneficiaryCompany $company)
    {
        // ليس مطلوباً حالياً - سنعالج الحفظ النهائي في الدالة التالية
    }
    /**
     * عرض نموذج الخطوة الثالثة (الوثائق)
     */
    public function createStep3(BeneficiaryCompany $company)
    {
        return view('beneficiaries.create-step3', compact('company'));
    }

    /**
     * عرض قائمة الشركات المستفيدة. (الـ URL: /beneficiaries)
     */
    public function index()
    {
        // 1. جلب جميع الشركات المستفيدة
        $beneficiaries = BeneficiaryCompany::with('distributor')->get();
        
        // 2. إرجاع الـ View
        return view('beneficiaries.index', compact('beneficiaries'));
    }

    /**
     * عرض نموذج إضافة شركة مستفيدة جديدة. (الـ URL: /beneficiaries/create)
     */
    public function create()
    {
        // سنحتاج لإرسال قائمة شركات التوزيع إلى الواجهة
        $distributors = Distributor::all();
        return view('beneficiaries.create', compact('distributors'));
    }

    /**
     * حفظ بيانات الشركة المستفيدة الجديدة.
     */
   public function store(Request $request)
    {
        // 1. ==========================================================
    // التحقق من صحة البيانات (Validation)
    // ==========================================================
    $request->validate([
        'distributor_id' => 'required|exists:distributors,id',
        'name' => 'required|string|max:255',
        'fuel_code' => 'nullable|string|max:50|unique:beneficiary_companies,fuel_code',
        'latitude' => 'nullable|numeric|between:-90,90',
        'longitude' => 'nullable|numeric|between:-180,180',
        'authorized_person_photo_path' => 'nullable|file', 
        'representative_photo_path' => 'nullable|file',
        'documents.*.file' => 'nullable|file', 
        'documents.*.expiry_date' => 'nullable|date',
    ]);
        
        // 2. ==========================================================
        // حفظ الشركة الأساسية (BeneficiaryCompany) - لن يتغير
        // ==========================================================
        $company = BeneficiaryCompany::create([
            'distributor_id' => $request->distributor_id,
            'name' => $request->name,
            'activity_type' => $request->activity_type,
            'fuel_code' => $request->fuel_code,
            'current_status' => $request->current_status,
            'address' => $request->address,
            'nearest_landmark' => $request->nearest_landmark,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
        ]);
        
        // 3. ==========================================================
        // حفظ التفاصيل والمخصصات (CompanyDetails)
        // ==========================================================
        
        // رفع صور المفوض والمندوب - تبسيط مسار الحفظ
        $auth_photo_path = null;
        if ($request->hasFile('authorized_person_photo_path')) {
            $auth_photo_path = $request->file('authorized_person_photo_path')->store('personnel_photos', 'public');
        }

        $rep_photo_path = null;
        if ($request->hasFile('representative_photo_path')) {
            $rep_photo_path = $request->file('representative_photo_path')->store('personnel_photos', 'public');
        }
        
        // إنشاء سجل التفاصيل وربطه بالشركة
        $company->details()->create([
            'fuel_type' => $request->fuel_type,
            'monthly_allowance' => $request->monthly_allowance,
            'effective_date' => $request->effective_date,
            'supply_warehouse' => $request->supply_warehouse,
            'authorized_person_name' => $request->authorized_person_name,
            'authorized_person_phone' => $request->authorized_person_phone,
            'authorized_person_email' => $request->authorized_person_email,
            'authorized_person_photo_path' => $auth_photo_path,
            'representative_name' => $request->representative_name,
            'representative_phone' => $request->representative_phone,
            'representative_email' => $request->representative_email,
            'representative_photo_path' => $rep_photo_path,
            'notes' => $request->notes,
        ]);
        
        // 4. ==========================================================
        // حفظ الوثائق (CompanyDocuments)
        // ==========================================================
        if ($request->has('documents')) {
            foreach ($request->documents as $documentType => $docData) {
                
                $doc_file_path = null;
                $fileKey = "documents.$documentType.file";
                
                if ($request->hasFile($fileKey)) {
                    $doc_file_path = $request->file($fileKey)->store('company_documents', 'public');
                }
                
                // حفظ سجل الوثيقة في قاعدة البيانات
                $company->documents()->create([
                    'document_type' => $documentType,
                    'status' => $docData['status'],
                    'expiry_date' => $docData['expiry_date'],
                    'file_path' => $doc_file_path,
                ]);
            }
        }

        // 5. إعادة التوجيه
        return redirect()->route('beneficiaries.index')
                         ->with('success', 'تم إضافة الشركة المستفيدة وجميع وثائقها بنجاح!');
    }
    
    // الدوال التالية يجب أن تكون موجودة لدعم Resource Route

    public function show(BeneficiaryCompany $beneficiary)
    {
        // ليس مطلوباً حالياً
    }

      public function edit(BeneficiaryCompany $beneficiary)
    {
        // جلب جميع شركات التوزيع لاستخدامها في قائمة الاختيار
        $distributors = Distributor::all();
        
        // إرجاع الـ View مع تمرير الشركة وجميع بياناتها المرتبطة
        return view('beneficiaries.edit', [
            'company' => $beneficiary,
            'distributors' => $distributors,
        ]);
    }

    public function update(Request $request, BeneficiaryCompany $beneficiary)
    {
        // ليس مطلوباً حالياً
    }

    public function destroy(BeneficiaryCompany $beneficiary)
    {
        // ليس مطلوباً حالياً
    }
}