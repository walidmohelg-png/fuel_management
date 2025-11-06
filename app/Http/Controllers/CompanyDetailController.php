<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CompanyDetail;
use App\Models\BeneficiaryCompany;

class CompanyDetailController extends Controller
{
    /**
     * عرض تفاصيل الشركات المسجلة
     */
    public function index()
    {
        $details = CompanyDetail::with('company')->get();
        return view('company_details.index', compact('details'));
    }

    /**
     * عرض نموذج إضافة تفاصيل جديدة
     */
    public function create()
    {
        $companies = BeneficiaryCompany::all();
        return view('company_details.create', compact('companies'));
    }

    /**
     * حفظ التفاصيل في قاعدة البيانات
     */
    public function store(Request $request)
    {
        $request->validate([
            'company_id' => 'required|exists:beneficiary_companies,id',
            'warehouse_location' => 'nullable|string|max:255',
            'storage_capacity' => 'nullable|numeric',
            'number_of_employees' => 'nullable|integer',
        ]);

        CompanyDetail::create($request->all());

        return redirect()->route('company_details.index')
                         ->with('success', 'تم حفظ تفاصيل الشركة بنجاح!');
    }

    /**
     * حذف التفاصيل
     */
    public function destroy($id)
    {
        $detail = CompanyDetail::findOrFail($id);
        $detail->delete();

        return redirect()->route('company_details.index')
                         ->with('success', 'تم حذف تفاصيل الشركة بنجاح!');
    }
}
