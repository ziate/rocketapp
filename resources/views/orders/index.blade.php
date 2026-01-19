@extends('layouts.app')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>الطلبات</h2>
        <a class="btn btn-primary" href="{{ route('orders.create') }}">إضافة طلب</a>
    </div>

    <form class="card p-3 mb-3 shadow-sm" method="GET" action="{{ route('orders.index') }}">
        <div class="row g-3">
            <div class="col-md-4">
                <label class="form-label">العميل</label>
                <select name="customer_id" class="form-select">
                    <option value="">الكل</option>
                    @foreach($customers as $customer)
                        <option value="{{ $customer->id }}" @selected(request('customer_id') == $customer->id)>{{ $customer->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-4">
                <label class="form-label">نوع الطلب</label>
                <select name="order_type_id" class="form-select">
                    <option value="">الكل</option>
                    @foreach($orderTypes as $orderType)
                        <option value="{{ $orderType->id }}" @selected(request('order_type_id') == $orderType->id)>{{ $orderType->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-4">
                <label class="form-label">الحالة</label>
                <select name="status" class="form-select">
                    <option value="">الكل</option>
                    @foreach(['pending' => 'قيد التنفيذ', 'assigned' => 'تم الإسناد', 'delivered' => 'تم التوصيل', 'cancelled' => 'ملغي'] as $value => $label)
                        <option value="{{ $value }}" @selected(request('status') === $value)>{{ $label }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-12 d-flex gap-2">
                <button class="btn btn-secondary" type="submit">تصفية</button>
                <a class="btn btn-outline-secondary" href="{{ route('orders.index') }}">إعادة ضبط</a>
            </div>
        </div>
    </form>

    <div class="card shadow-sm">
        <div class="table-responsive">
            <table class="table mb-0">
                <thead>
                <tr>
                    <th>#</th>
                    <th>العميل</th>
                    <th>نوع الطلب</th>
                    <th>المنطقة</th>
                    <th>سعر التوصيل</th>
                    <th>الحالة</th>
                    <th>إجراءات</th>
                </tr>
                </thead>
                <tbody>
                @foreach($orders as $order)
                    <tr>
                        <td>{{ $order->id }}</td>
                        <td>{{ $order->customer?->name }}</td>
                        <td>{{ $order->orderType?->name }}</td>
                        <td>{{ $order->area?->name }}</td>
                        <td>{{ $order->delivery_price }}</td>
                        <td>{{ $order->status }}</td>
                        <td class="d-flex gap-2">
                            <a class="btn btn-sm btn-outline-secondary" href="{{ route('orders.edit', $order) }}">تعديل</a>
                            <form method="POST" action="{{ route('orders.destroy', $order) }}">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-outline-danger" type="submit">حذف</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
