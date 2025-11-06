<?php

namespace App\Http\Controllers;

use App\Models\Distributor;
use Illuminate\Http\Request;

class DistributorController extends Controller
{
    /**
     * عرض قائمة شركات التوزيع (مع دعم البحث).
     */
    public function index(Request $request)
    {
        $query = Distributor::query();

        // بحث بالاسم أو المدير
        if ($request->filled('search')) {
            $query->where('name', 'like', "%{$request->search}%")
                ->orWhere('manager_name', 'like', "%{$request->search}%");
        }

        // فلتر المنطقة
        if ($request->filled('region')) {
            $query->where('region', $request->region);
        }

        // فلتر المدينة
        if ($request->filled('city')) {
            $query->where('city', $request->city);
        }

        $distributors = $query->get();

        // لجلب القيم المتاحة للفلاتر من قاعدة البيانات
        $regions = Distributor::whereNotNull('region')->distinct()->pluck('region');
        $cities = Distributor::whereNotNull('city')->distinct()->pluck('city');

        return view('distributors.index', compact('distributors', 'regions', 'cities'));
    }

    /**
     * عرض نموذج إضافة شركة جديدة.
     */
    public function create()
    {
        return view('distributors.create');
    }

    /**
     * حفظ شركة توزيع جديدة في قاعدة البيانات.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'manager_name' => 'nullable|string|max:255',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:50',
            'delegate_name' => 'nullable|string|max:255',
            'delegate_phone' => 'nullable|string|max:50',
            'region' => 'nullable|string|max:255',
            'city' => 'nullable|string|max:255',
            'address' => 'nullable|string',
            'latitude' => 'nullable|string|max:255',
            'longitude' => 'nullable|string|max:255',
        ]);

        Distributor::create($validated);

        return redirect()->route('distributors.index')
            ->with('success', '✅ تم حفظ شركة التوزيع بنجاح!');
    }

    public function show(Distributor $distributor)
    {
        return view('distributors.show', compact('distributor'));
    }

    /**
 * عرض نموذج تعديل شركة توزيع.
 */
    public function edit(Distributor $distributor)
    {
        return view('distributors.edit', compact('distributor'));
    }

    /**
     * حفظ التعديلات على شركة توزيع موجودة.
     */
    public function update(Request $request, Distributor $distributor)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'manager_name' => 'nullable|string|max:255',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:50',
            'delegate_name' => 'nullable|string|max:255',
            'delegate_phone' => 'nullable|string|max:50',
            'region' => 'nullable|string|max:255',
            'city' => 'nullable|string|max:255',
            'address' => 'nullable|string',
            'latitude' => 'nullable|string|max:255',
            'longitude' => 'nullable|string|max:255',
        ]);

        $distributor->update($validated);

        return redirect()->route('distributors.index')
            ->with('success', '✅ تم تحديث بيانات شركة التوزيع بنجاح!');
    }

    /**
     * حذف شركة توزيع.
     */
    public function destroy(Distributor $distributor)
    {
        $distributor->delete();

        return response()->json([
            'success' => true,
            'message' => '🗑️ تم حذف شركة التوزيع بنجاح!'
        ]);
    }

}
