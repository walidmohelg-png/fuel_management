<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DistributorController;
use App\Http\Controllers\BeneficiaryCompanyController;
use App\Http\Controllers\CompanyDetailController;
use App\Http\Controllers\CompanyDocumentController;
use App\Http\Controllers\FuelStationController;
use App\Http\Controllers\FuelStationWizardController;

Route::get('/', function () {
    return Auth::check() ? redirect('/dashboard') : redirect('/login');
});

Route::middleware(['auth', 'verified'])->group(function () {

    // 🏠 لوحة التحكم
    Route::get('/dashboard', fn() => view('dashboard'))->name('dashboard');

    // 👤 الملف الشخصي
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // 🏭 شركات التوزيع
    Route::resource('distributors', DistributorController::class)->names('distributors');

    // ==========================================================
    // 🧩 معالج الخطوات (Multi-Step Form) للشركات المستفيدة
    // ==========================================================
    Route::prefix('beneficiaries')->name('beneficiaries.')->group(function () {

        // الخطوة 1️⃣
        Route::get('/create', [BeneficiaryCompanyController::class, 'createStep1'])->name('create_step_1');
        Route::post('/store-step-1', [BeneficiaryCompanyController::class, 'storeStep1'])->name('store_step_1');

        // الخطوة 2️⃣
        Route::get('/step-2', [BeneficiaryCompanyController::class, 'createStep2'])->name('create_step_2');
        Route::post('/store-step-2', [BeneficiaryCompanyController::class, 'storeStep2'])->name('store_step_2');

        // الخطوة 3️⃣
        Route::get('/step-3', [BeneficiaryCompanyController::class, 'createStep3'])->name('create_step_3');
        Route::post('/store', [BeneficiaryCompanyController::class, 'store'])->name('store');
    });

    // ==========================================================
    // 🏢 إدارة الشركات المستفيدة (Resource Route)
    // ==========================================================
    // ✅ هنا التعديل: استخدام parameters([]) لتعريف اسم الـ wildcard
    Route::resource('beneficiaries', BeneficiaryCompanyController::class)
        ->names('beneficiaries')
        ->parameters([
            'beneficiaries' => 'beneficiaryCompany', // ✅ يجعل الـ wildcard هو {beneficiaryCompany}
        ])
        ->except(['create', 'store']); // احتفظ بـ 'edit' و 'destroy' ضمن Resource Route الآن

    // 📋 تفاصيل الشركات
    Route::resource('company-details', CompanyDetailController::class)->names('company_details');

    // 📎 وثائق الشركات
    Route::resource('company-documents', CompanyDocumentController::class)->names('company_documents');

    // 🆕 إضافة مسار DELETE صريح لمحطات الوقود (مهم لحل مشكلة 405)
    // ----------------------------------------------------------
    Route::delete('/fuel_stations/{fuelStation}', [FuelStationController::class, 'destroy'])->name('fuel_stations.destroy');
    // ----------------------------------------------------------

    // ==========================================================
    // ⛽️ معالج الخطوات (Multi-Step Form) لمحطات الوقود
    // ==========================================================
    Route::prefix('fuel-stations/create')->name('fuel_stations.create.')->group(function () {
        // الخطوة 1: معلومات المحطة الأساسية والمالك
        Route::get('/', [FuelStationWizardController::class, 'createStep1'])->name('step1');
        Route::post('/step1', [FuelStationWizardController::class, 'storeStep1'])->name('storeStep1');

        // الخطوة 2: تفاصيل التشغيل والموظفين
        Route::get('/step2/{fuelStation?}', [FuelStationWizardController::class, 'createStep2'])->name('step2');
        Route::post('/step2/{fuelStation}', [FuelStationWizardController::class, 'storeStep2'])->name('storeStep2');

        // الخطوة 3: المستندات والمراجعة النهائية
        Route::get('/step3/{fuelStation?}', [FuelStationWizardController::class, 'createStep3'])->name('step3');
        Route::post('/step3/{fuelStation}', [FuelStationWizardController::class, 'storeStep3'])->name('storeStep3');
    });

    // ==========================================================
    // ⛽️ إدارة محطات الوقود (Resource Route)
    // ==========================================================
    Route::resource('fuel_stations', FuelStationController::class)
        ->names('fuel_stations')
        ->except(['create', 'store', 'destroy']); // 🆕 استبعد 'destroy' هنا لأننا عرفناه صراحةً أعلاه

    // 🆕 إضافة مسارات جديدة لعرض وتنزيل مستندات محطة الوقود
    // ----------------------------------------------------------
    Route::get('/fuel_stations/{fuel_station}/documents/{document}/view', [FuelStationController::class, 'viewDocument'])->name('fuel_stations.documents.view');
    Route::get('/fuel_stations/{fuel_station}/documents/{document}/download', [FuelStationController::class, 'downloadDocument'])->name('fuel_stations.documents.download');
    // ----------------------------------------------------------

});

require __DIR__ . '/auth.php';