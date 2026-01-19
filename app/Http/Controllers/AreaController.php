<?php

namespace App\Http\Controllers;

use App\Models\Area;
use App\Models\Governorate;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AreaController extends Controller
{
    public function index(): View
    {
        $areas = Area::with('governorate')->latest()->paginate(15);

        return view('areas.index', compact('areas'));
    }

    public function create(): View
    {
        $governorates = Governorate::orderBy('name')->get();

        return view('areas.create', compact('governorates'));
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'governorate_id' => ['required', 'exists:governorates,id'],
            'name' => ['required', 'string', 'max:255'],
            'delivery_price_default' => ['required', 'numeric', 'min:0'],
        ]);

        Area::create($data);

        return redirect()->route('areas.index')
            ->with('status', 'تمت إضافة المنطقة بنجاح.');
    }

    public function edit(Area $area): View
    {
        $governorates = Governorate::orderBy('name')->get();

        return view('areas.edit', compact('area', 'governorates'));
    }

    public function update(Request $request, Area $area): RedirectResponse
    {
        $data = $request->validate([
            'governorate_id' => ['required', 'exists:governorates,id'],
            'name' => ['required', 'string', 'max:255'],
            'delivery_price_default' => ['required', 'numeric', 'min:0'],
        ]);

        $area->update($data);

        return redirect()->route('areas.index')
            ->with('status', 'تم تحديث المنطقة بنجاح.');
    }

    public function destroy(Area $area): RedirectResponse
    {
        $area->delete();

        return redirect()->route('areas.index')
            ->with('status', 'تم حذف المنطقة بنجاح.');
    }
}
