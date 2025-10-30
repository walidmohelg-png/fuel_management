<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Distributor; // تأكد من استيراد نموذج الموزع
use Illuminate\Http\Response; // تم إضافته لضمان عمل الدوال القياسية

class DistributorController extends Controller
{
    /**
     * عرض قائمة شركات التوزيع. (الـ URL: /distributors)
     */
    public function index()
    {
        // 1. جلب جميع شركات التوزيع من قاعدة البيانات
        $distributors = Distributor::all(); 
        
        // 2. إرجاع الـ View (resources/views/distributors/index.blade.php) 
        //    مع تمرير البيانات إليها.
        return view('distributors.index', [
            'distributors' => $distributors,
        ]);
    }

    /**
     * عرض نموذج إضافة شركة توزيع جديدة. (الـ URL: /distributors/create)
     */
    public function create()
    {
        return view('distributors.create');
    }

    /**
     * حفظ بيانات شركة التوزيع الجديدة في قاعدة البيانات. (الـ POST)
     */
    public function store(Request $request)
    {
        // 1. قواعد التحقق (Validation Rules) - تأكد من متطلبات البيانات
        $request->validate([
            'name' => ['required', 'string', 'max:255', 'unique:distributors'],
            'manager_name' => ['nullable', 'string', 'max:255'],
            'phone_number' => ['nullable', 'string', 'max:50'],
            'email' => ['nullable', 'email', 'max:255'],
            // حقول الموقع (اختيارية)
            'latitude' => ['nullable', 'numeric'],
            'longitude' => ['nullable', 'numeric'],
        ]);

        // 2. إنشاء سجل جديد في قاعدة البيانات
        // بما أن الأعمدة في جدول distributors هي نفسها أسماء الـ inputs في الفورم، يمكن استخدام $request->all()
        Distributor::create($request->only([
            'name', 
            'manager_name', 
            'phone_number', 
            'email', 
            'address', 
            'latitude', 
            'longitude'
        ]));

        // 3. إعادة التوجيه إلى صفحة القائمة مع رسالة نجاح
        return redirect()->route('distributors.index')
                         ->with('success', 'تم إضافة شركة التوزيع بنجاح!');
    }
    
    /**
     * عرض تفاصيل شركة التوزيع. (سنستخدمها لاحقاً)
     */
    public function show(Distributor $distributor)
    {
        // ليس مطلوباً حالياً، لكن يجب وجوده لـ Resource Route
    }

    /**
     * عرض نموذج تعديل شركة التوزيع. (سنستخدمها لاحقاً)
     */
    public function edit(Distributor $distributor)
    {
        // ليس مطلوباً حالياً، لكن يجب وجوده لـ Resource Route
    }

    /**
     * تحديث بيانات شركة التوزيع في قاعدة البيانات. (سنستخدمها لاحقاً)
     */
    public function update(Request $request, Distributor $distributor)
    {
        // ليس مطلوباً حالياً، لكن يجب وجوده لـ Resource Route
    }

    /**
     * حذف شركة التوزيع. (سنستخدمها لاحقاً)
     */
    public function destroy(Distributor $distributor)
    {
        // ليس مطلوباً حالياً، لكن يجب وجوده لـ Resource Route
    }
}