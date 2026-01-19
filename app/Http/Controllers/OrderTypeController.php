<?php

namespace App\Http\Controllers;

use App\Models\OrderType;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class OrderTypeController extends Controller
{
    public function index(): View
    {
        $orderTypes = OrderType::latest()->paginate(15);

        return view('order-types.index', compact('orderTypes'));
    }

    public function create(): View
    {
        return view('order-types.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'is_active' => ['boolean'],
        ]);

        $data['is_active'] = $request->boolean('is_active');

        OrderType::create($data);

        return redirect()->route('order-types.index')
            ->with('status', 'تمت إضافة نوع الطلب بنجاح.');
    }

    public function edit(OrderType $orderType): View
    {
        return view('order-types.edit', compact('orderType'));
    }

    public function update(Request $request, OrderType $orderType): RedirectResponse
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'is_active' => ['boolean'],
        ]);

        $data['is_active'] = $request->boolean('is_active');
        $orderType->update($data);

        return redirect()->route('order-types.index')
            ->with('status', 'تم تحديث نوع الطلب بنجاح.');
    }

    public function destroy(OrderType $orderType): RedirectResponse
    {
        $orderType->delete();

        return redirect()->route('order-types.index')
            ->with('status', 'تم حذف نوع الطلب بنجاح.');
    }
}
