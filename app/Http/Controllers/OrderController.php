<?php

namespace App\Http\Controllers;

use App\Models\Area;
use App\Models\Customer;
use App\Models\DeliveryDriver;
use App\Models\Order;
use App\Models\OrderType;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use App\Services\ActivityLogger;

class OrderController extends Controller
{
    public function index(): View
    {
        $query = Order::with(['customer', 'orderType', 'area.governorate', 'deliveryDriver'])
            ->latest();

        if (request('status')) {
            $query->where('status', request('status'));
        }

        if (request('customer_id')) {
            $query->where('customer_id', request('customer_id'));
        }

        if (request('order_type_id')) {
            $query->where('order_type_id', request('order_type_id'));
        }

        if (request('delivery_driver_id')) {
            $query->where('delivery_driver_id', request('delivery_driver_id'));
        }

        $orders = $query->paginate(15)->withQueryString();
        $customers = Customer::orderBy('name')->get();
        $orderTypes = OrderType::orderBy('name')->get();
        $drivers = DeliveryDriver::orderBy('name')->get();

        return view('orders.index', compact('orders', 'customers', 'orderTypes', 'drivers'));
    }

    public function create(): View
    {
        $customers = Customer::with('areas.governorate')->orderBy('name')->get();
        $orderTypes = OrderType::where('is_active', true)->orderBy('name')->get();
        $drivers = DeliveryDriver::orderBy('name')->get();

        return view('orders.create', compact('customers', 'orderTypes', 'drivers'));
    }

    public function store(Request $request, ActivityLogger $activityLogger): RedirectResponse
    {
        $data = $request->validate([
            'customer_id' => ['required', 'exists:customers,id'],
            'order_type_id' => ['required', 'exists:order_types,id'],
            'area_id' => ['required', 'exists:areas,id'],
            'delivery_driver_id' => ['nullable', 'exists:delivery_drivers,id'],
            'recipient_name' => ['required', 'string', 'max:255'],
            'recipient_phone' => ['required', 'string', 'max:30'],
            'recipient_address' => ['required', 'string'],
            'collect_required' => ['boolean'],
            'collect_amount' => ['nullable', 'numeric', 'min:0'],
            'notes' => ['nullable', 'string'],
            'scheduled_at' => ['nullable', 'date'],
        ]);

        $data['collect_required'] = $request->boolean('collect_required');
        $data['delivery_price'] = $this->resolveDeliveryPrice(
            $data['customer_id'],
            $data['area_id']
        );

        if (! $data['collect_required']) {
            $data['collect_amount'] = null;
        }

        $order = Order::create($data);
        $order->statusHistories()->create([
            'status' => $order->status,
            'notes' => 'إنشاء الطلب',
            'changed_by' => Auth::id(),
        ]);
        $activityLogger->log('order.created', $order, ['status' => $order->status]);

        return redirect()->route('orders.index')
            ->with('status', 'تم إنشاء الطلب بنجاح.');
    }

    public function edit(Order $order): View
    {
        $customers = Customer::with('areas.governorate')->orderBy('name')->get();
        $orderTypes = OrderType::orderBy('name')->get();
        $drivers = DeliveryDriver::orderBy('name')->get();
        $order->load(['customer', 'orderType', 'area.governorate', 'statusHistories']);

        return view('orders.edit', compact('order', 'customers', 'orderTypes', 'drivers'));
    }

    public function update(Request $request, Order $order, ActivityLogger $activityLogger): RedirectResponse
    {
        $data = $request->validate([
            'customer_id' => ['required', 'exists:customers,id'],
            'order_type_id' => ['required', 'exists:order_types,id'],
            'area_id' => ['required', 'exists:areas,id'],
            'delivery_driver_id' => ['nullable', 'exists:delivery_drivers,id'],
            'recipient_name' => ['required', 'string', 'max:255'],
            'recipient_phone' => ['required', 'string', 'max:30'],
            'recipient_address' => ['required', 'string'],
            'collect_required' => ['boolean'],
            'collect_amount' => ['nullable', 'numeric', 'min:0'],
            'notes' => ['nullable', 'string'],
            'scheduled_at' => ['nullable', 'date'],
            'status' => ['nullable', 'string', 'max:50'],
            'status_note' => ['nullable', 'string', 'max:255'],
        ]);

        $data['collect_required'] = $request->boolean('collect_required');
        $data['delivery_price'] = $this->resolveDeliveryPrice(
            $data['customer_id'],
            $data['area_id']
        );

        if (! $data['collect_required']) {
            $data['collect_amount'] = null;
        }

        $originalStatus = $order->status;
        $order->update($data);

        if ($order->status !== $originalStatus) {
            $order->statusHistories()->create([
                'status' => $order->status,
                'notes' => $data['status_note'] ?? 'تحديث حالة الطلب',
                'changed_by' => Auth::id(),
            ]);
        }
        $activityLogger->log('order.updated', $order, [
            'status' => $order->status,
            'previous_status' => $originalStatus,
        ]);

        return redirect()->route('orders.index')
            ->with('status', 'تم تحديث الطلب بنجاح.');
    }

    public function destroy(Order $order, ActivityLogger $activityLogger): RedirectResponse
    {
        $activityLogger->log('order.deleted', $order, ['status' => $order->status]);
        $order->delete();

        return redirect()->route('orders.index')
            ->with('status', 'تم حذف الطلب بنجاح.');
    }

    private function resolveDeliveryPrice(int $customerId, int $areaId): float
    {
        $area = Area::findOrFail($areaId);
        $customer = Customer::with('areas')->findOrFail($customerId);

        $matchedArea = $customer->areas->firstWhere('id', $area->id);

        if ($matchedArea && $matchedArea->pivot?->custom_delivery_price !== null) {
            return (float) $matchedArea->pivot->custom_delivery_price;
        }

        return (float) $area->delivery_price_default;
    }
}
