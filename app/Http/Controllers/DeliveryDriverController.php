<?php

namespace App\Http\Controllers;

use App\Models\Area;
use App\Models\DeliveryDriver;
use App\Models\Governorate;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DeliveryDriverController extends Controller
{
    public function index(): View
    {
        $query = DeliveryDriver::with(['governorate', 'area'])->latest();

        if (request('search')) {
            $search = request('search');
            $query->where(function ($builder) use ($search) {
                $builder->where('name', 'like', "%{$search}%")
                    ->orWhere('phone', 'like', "%{$search}%");
            });
        }

        $drivers = $query->paginate(15)->withQueryString();

        return view('delivery-drivers.index', compact('drivers'));
    }

    public function create(): View
    {
        $governorates = Governorate::orderBy('name')->get();
        $areas = Area::with('governorate')->orderBy('name')->get();

        return view('delivery-drivers.create', compact('governorates', 'areas'));
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'string', 'max:30'],
            'email' => ['nullable', 'email'],
            'national_id' => ['nullable', 'string', 'max:50'],
            'address' => ['required', 'string'],
            'governorate_id' => ['nullable', 'exists:governorates,id'],
            'area_id' => ['nullable', 'exists:areas,id'],
            'status' => ['required', 'string', 'max:30'],
        ]);

        DeliveryDriver::create($data);

        return redirect()->route('delivery-drivers.index')
            ->with('status', 'تمت إضافة المندوب بنجاح.');
    }

    public function edit(DeliveryDriver $deliveryDriver): View
    {
        $governorates = Governorate::orderBy('name')->get();
        $areas = Area::with('governorate')->orderBy('name')->get();

        return view('delivery-drivers.edit', compact('deliveryDriver', 'governorates', 'areas'));
    }

    public function update(Request $request, DeliveryDriver $deliveryDriver): RedirectResponse
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'string', 'max:30'],
            'email' => ['nullable', 'email'],
            'national_id' => ['nullable', 'string', 'max:50'],
            'address' => ['required', 'string'],
            'governorate_id' => ['nullable', 'exists:governorates,id'],
            'area_id' => ['nullable', 'exists:areas,id'],
            'status' => ['required', 'string', 'max:30'],
        ]);

        $deliveryDriver->update($data);

        return redirect()->route('delivery-drivers.index')
            ->with('status', 'تم تحديث بيانات المندوب بنجاح.');
    }

    public function destroy(DeliveryDriver $deliveryDriver): RedirectResponse
    {
        $deliveryDriver->delete();

        return redirect()->route('delivery-drivers.index')
            ->with('status', 'تم حذف المندوب بنجاح.');
    }
}
