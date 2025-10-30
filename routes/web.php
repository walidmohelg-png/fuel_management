<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\DistributorController; // <--- 1. السطر الجديد: تعريف Controller التوزيع
use App\Http\Controllers\BeneficiaryCompanyController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// 1. تعديل المسار الرئيسي (الجذر) ليناسب حالة تسجيل الدخول/الخروج
Route::get('/', function () {
    // إذا كان المستخدم مسجلاً دخوله بالفعل، وجهه مباشرة إلى لوحة التحكم
    if (Auth::check()) {
        return redirect('/dashboard'); 
    }
    // إذا لم يكن مسجلاً دخوله، وجهه إلى صفحة تسجيل الدخول (التي أنشأها Breeze)
    return redirect('/login');
});

// 2. مسارات التطبيق المحمية (التي تتطلب تسجيل دخول)
Route::middleware(['auth', 'verified'])->group(function () {
    
    // المسار الرئيسي للوحة التحكم
    Route::get('/dashboard', function () {
        return view('dashboard'); 
    })->name('dashboard');

    // مسارات الملف الشخصي (Profile Routes)
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    
    // ==========================================================
    // 3. مسارات المشروع الرئيسية (إدارة التوزيع والمستفيدين)
    // ==========================================================
    
    // مسارات إدارة شركات التوزيع
    // (يُنشئ 7 مسارات تلقائية: index, create, store, show, edit, update, destroy)
    Route::resource('distributors', DistributorController::class)
        ->names('distributors'); // <--- 2. السطر الجديد: مسار إدارة شركات التوزيع

        // مسارات إدارة الشركات المستفيدة
    Route::resource('beneficiaries', BeneficiaryCompanyController::class)
    ->names('beneficiaries')
    ->except(['create', 'store']);

    // مسارات المعالج الخطي (Multi-Step Form)
    Route::controller(BeneficiaryCompanyController::class)->prefix('beneficiaries')->name('beneficiaries.')->group(function () {
    // 1. الصفحة الأولى (المخصصات) - لا تحتاج إلى مسار جديد للعرض (ستكون دالة create)
    Route::post('store-step-1', 'storeStep1')->name('store_step_1'); 

    // 2. الصفحة الثانية (المفوض والمندوب)
    Route::get('{company}/step-2', 'createStep2')->name('create_step_2');
    Route::post('{company}/store-step-2', 'storeStep2')->name('store_step_2');
    
    // 3. الصفحة الثالثة (الوثائق)
    Route::get('{company}/step-3', 'createStep3')->name('create_step_3');
    // دالة store النهائية ستكون هي الدالة العادية لـ Resource Route
});

    // هنا سيتم إضافة مسارات الشركات المستفيدة والتقارير لاحقاً
    
});

// 4. تضمين مسارات التوثيق (تسجيل الدخول، التسجيل، كلمة المرور)
require __DIR__.'/auth.php';

// 5. مسارات الصلاحيات (Permissions) - يمكن استخدامها لاحقاً لتقييد الوصول
// Route::middleware(['auth', 'role:admin'])->group(function () {
//    // ...
// });