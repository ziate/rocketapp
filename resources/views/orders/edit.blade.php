@extends('layouts.app')

@section('content')
    <h2 class="mb-3">تعديل طلب</h2>
    <form method="POST" action="{{ route('orders.update', $order) }}" class="card p-4 shadow-sm" id="order-form">
        @csrf
        @method('PUT')
        <div class="row">
            <div class="col-md-6 mb-3">
                <label class="form-label">العميل</label>
                <select name="customer_id" id="customer-select" class="form-select" required>
                    @foreach($customers as $customer)
                        <option value="{{ $customer->id }}" data-address="{{ $customer->address }}" @selected($order->customer_id === $customer->id)>{{ $customer->name }} - {{ $customer->phone }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-6 mb-3">
                <label class="form-label">نوع الطلب</label>
                <select name="order_type_id" class="form-select" required>
                    @foreach($orderTypes as $orderType)
                        <option value="{{ $orderType->id }}" @selected($order->order_type_id === $orderType->id)>{{ $orderType->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-6 mb-3">
                <label class="form-label">منطقة العميل</label>
                <select name="area_id" id="area-select" class="form-select" required>
                    @foreach($order->customer?->areas ?? [] as $area)
                        <option value="{{ $area->id }}" @selected($order->area_id === $area->id)>{{ $area->governorate?->name }} - {{ $area->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-6 mb-3">
                <label class="form-label">عنوان المستلم</label>
                <input type="text" name="recipient_address" id="recipient-address" value="{{ $order->recipient_address }}" class="form-control" required>
            </div>
            <div class="col-md-6 mb-3">
                <label class="form-label">اسم المستلم</label>
                <input type="text" name="recipient_name" value="{{ $order->recipient_name }}" class="form-control" required>
            </div>
            <div class="col-md-6 mb-3">
                <label class="form-label">هاتف المستلم</label>
                <input type="text" name="recipient_phone" value="{{ $order->recipient_phone }}" class="form-control" required>
            </div>
            <div class="col-md-6 mb-3">
                <label class="form-label">تحصيل مبلغ؟</label>
                <div class="form-check">
                    <input type="checkbox" name="collect_required" value="1" class="form-check-input" id="collect-required" @checked($order->collect_required)>
                    <label class="form-check-label" for="collect-required">نعم</label>
                </div>
            </div>
            <div class="col-md-6 mb-3">
                <label class="form-label">المبلغ المطلوب تحصيله</label>
                <input type="number" step="0.01" name="collect_amount" id="collect-amount" value="{{ $order->collect_amount }}" class="form-control" @disabled(! $order->collect_required)>
            </div>
            <div class="col-md-6 mb-3">
                <label class="form-label">الحالة</label>
                <select name="status" class="form-select">
                    @foreach(['pending' => 'قيد التنفيذ', 'assigned' => 'تم الإسناد', 'delivered' => 'تم التوصيل', 'cancelled' => 'ملغي'] as $value => $label)
                        <option value="{{ $value }}" @selected($order->status === $value)>{{ $label }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-12 mb-3">
                <label class="form-label">ملاحظات</label>
                <textarea name="notes" class="form-control" rows="2">{{ $order->notes }}</textarea>
            </div>
        </div>
        <button class="btn btn-primary" type="submit">تحديث الطلب</button>
    </form>

    <div class="card shadow-sm mt-4">
        <div class="card-header">سجل حالات الطلب</div>
        <div class="table-responsive">
            <table class="table mb-0">
                <thead>
                <tr>
                    <th>الحالة</th>
                    <th>الملاحظات</th>
                    <th>التاريخ</th>
                </tr>
                </thead>
                <tbody>
                @forelse($order->statusHistories as $history)
                    <tr>
                        <td>{{ $history->status }}</td>
                        <td>{{ $history->notes }}</td>
                        <td>{{ $history->created_at }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3">لا يوجد سجل بعد.</td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <script>
        const customerSelect = document.getElementById('customer-select');
        const areaSelect = document.getElementById('area-select');
        const recipientAddress = document.getElementById('recipient-address');
        const collectRequired = document.getElementById('collect-required');
        const collectAmount = document.getElementById('collect-amount');

        collectRequired.addEventListener('change', () => {
            collectAmount.disabled = !collectRequired.checked;
            if (!collectRequired.checked) {
                collectAmount.value = '';
            }
        });

        customerSelect.addEventListener('change', async () => {
            const customerId = customerSelect.value;
            const address = customerSelect.selectedOptions[0]?.dataset.address || '';
            recipientAddress.value = address;
            areaSelect.innerHTML = '';

            const response = await fetch(`/api/customers/${customerId}/areas`);
            if (!response.ok) {
                return;
            }

            const data = await response.json();
            data.areas.forEach((area) => {
                const option = document.createElement('option');
                option.value = area.id;
                option.textContent = `${area.governorate} - ${area.name}`;
                areaSelect.appendChild(option);
            });

            if (data.areas.length === 1) {
                areaSelect.value = data.areas[0].id;
            }
        });
    </script>
@endsection
