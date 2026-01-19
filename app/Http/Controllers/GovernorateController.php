<?php

namespace App\Http\Controllers;

use App\Models\Governorate;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class GovernorateController extends Controller
{
    public function index(): View
    {
        $governorates = Governorate::latest()->paginate(15);

        return view('governorates.index', compact('governorates'));
    }

    public function create(): View
    {
        return view('governorates.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'delivery_price_default' => ['required', 'numeric', 'min:0'],
        ]);

        Governorate::create($data);

        return redirect()->route('governorates.index')
            ->with('status', 'تمت إضافة المحافظة بنجاح.');
    }

    public function edit(Governorate $governorate): View
    {
        return view('governorates.edit', compact('governorate'));
    }

    public function update(Request $request, Governorate $governorate): RedirectResponse
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'delivery_price_default' => ['required', 'numeric', 'min:0'],
        ]);

        $governorate->update($data);

        return redirect()->route('governorates.index')
            ->with('status', 'تم تحديث المحافظة بنجاح.');
    }

    public function destroy(Governorate $governorate): RedirectResponse
    {
        $governorate->delete();

        return redirect()->route('governorates.index')
            ->with('status', 'تم حذف المحافظة بنجاح.');
    }
}
