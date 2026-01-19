<?php

namespace App\Http\Controllers;

use App\Models\Area;
use App\Models\Customer;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CustomerController extends Controller
{
    public function index(): View
    {
        $customers = Customer::with('areas')->latest()->paginate(15);

        return view('customers.index', compact('customers'));
    }

    public function create(): View
    {
        $areas = Area::with('governorate')->orderBy('name')->get();

        return view('customers.create', compact('areas'));
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'string', 'max:30'],
            'email' => ['nullable', 'email'],
            'address' => ['required', 'string'],
            'notes' => ['nullable', 'string'],
            'areas' => ['nullable', 'array'],
            'areas.*.custom_delivery_price' => ['nullable', 'numeric', 'min:0'],
            'areas.*.selected' => ['nullable', 'boolean'],
        ]);

        $customer = Customer::create($data);
        $this->syncAreas($customer, $this->filterSelectedAreas($request->input('areas', [])));

        return redirect()->route('customers.index')
            ->with('status', 'تمت إضافة العميل بنجاح.');
    }

    public function edit(Customer $customer): View
    {
        $areas = Area::with('governorate')->orderBy('name')->get();
        $customer->load('areas');

        return view('customers.edit', compact('customer', 'areas'));
    }

    public function update(Request $request, Customer $customer): RedirectResponse
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'string', 'max:30'],
            'email' => ['nullable', 'email'],
            'address' => ['required', 'string'],
            'notes' => ['nullable', 'string'],
            'areas' => ['nullable', 'array'],
            'areas.*.custom_delivery_price' => ['nullable', 'numeric', 'min:0'],
            'areas.*.selected' => ['nullable', 'boolean'],
        ]);

        $customer->update($data);
        $this->syncAreas($customer, $this->filterSelectedAreas($request->input('areas', [])));

        return redirect()->route('customers.index')
            ->with('status', 'تم تحديث بيانات العميل بنجاح.');
    }

    public function destroy(Customer $customer): RedirectResponse
    {
        $customer->delete();

        return redirect()->route('customers.index')
            ->with('status', 'تم حذف العميل بنجاح.');
    }

    private function syncAreas(Customer $customer, array $areas): void
    {
        $payload = [];
        foreach ($areas as $areaId => $areaData) {
            $payload[$areaId] = [
                'custom_delivery_price' => $areaData['custom_delivery_price'] ?? null,
            ];
        }

        $customer->areas()->sync($payload);
    }

    private function filterSelectedAreas(array $areas): array
    {
        return collect($areas)
            ->filter(fn ($area) => ! empty($area['selected']))
            ->toArray();
    }
}
