@extends('layouts.app')

@section('content')
    <h2 class="mb-3">إنشاء طلب</h2>
    <form method="POST" action="{{ route('orders.store') }}" class="card p-4 shadow-sm" id="order-form">
        @csrf
        <div class="row">
            <div class="col-md-6 mb-3">
                <label class="form-label">العميل</label>
                <select name="customer_id" id="customer-select" class="form-select" required>
                    <option value="">اختر العميل</option>
                    @foreach($customers as $customer)
                        <option value="{{ $customer->id }}" data-address="{{ $customer->address }}">{{ $customer->name }} - {{ $customer->phone }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-6 mb-3">
                <label class="form-label">نوع الطلب</label>
                <select name="order_type_id" class="form-select" required>
                    <option value="">اختر نوع الطلب</option>
                    @foreach($orderTypes as $orderType)
                        <option value="{{ $orderType->id }}">{{ $orderType->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-6 mb-3">
                <label class="form-label">تعيين مندوب (اختياري)</label>
                <select name="delivery_driver_id" class="form-select">
                    <option value="">بدون تعيين</option>
                    @foreach($drivers as $driver)
                        <option value="{{ $driver->id }}">{{ $driver->name }} - {{ $driver->phone }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-6 mb-3">
                <label class="form-label">منطقة العميل</label>
                <select name="area_id" id="area-select" class="form-select" required>
                    <option value="">اختر المنطقة</option>
                </select>
                <div class="form-text">يتم جلب مناطق العميل تلقائياً.</div>
            </div>
            <div class="col-md-6 mb-3">
                <label class="form-label">عنوان المستلم</label>
                <input type="text" name="recipient_address" id="recipient-address" class="form-control" required>
            </div>
            <div class="col-md-6 mb-3">
                <label class="form-label">اسم المستلم</label>
                <input type="text" name="recipient_name" class="form-control" required>
            </div>
            <div class="col-md-6 mb-3">
                <label class="form-label">هاتف المستلم</label>
                <input type="text" name="recipient_phone" class="form-control" required>
            </div>
            <div class="col-md-6 mb-3">
                <label class="form-label">تحصيل مبلغ؟</label>
                <div class="form-check">
                    <input type="checkbox" name="collect_required" value="1" class="form-check-input" id="collect-required">
                    <label class="form-check-label" for="collect-required">نعم</label>
                </div>
            </div>
            <div class="col-md-6 mb-3">
                <label class="form-label">المبلغ المطلوب تحصيله</label>
                <input type="number" step="0.01" name="collect_amount" id="collect-amount" class="form-control" disabled>
            </div>
            <div class="col-12 mb-3">
                <label class="form-label">ملاحظات</label>
                <textarea name="notes" class="form-control" rows="2"></textarea>
            </div>
        </div>
        <button class="btn btn-primary" type="submit">حفظ الطلب</button>
    </form>

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
            areaSelect.innerHTML = '<option value="">اختر المنطقة</option>';

            if (!customerId) {
                return;
            }

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
