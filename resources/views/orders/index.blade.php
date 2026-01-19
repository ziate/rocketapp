@extends('layouts.app')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>الطلبات</h2>
        <a class="btn btn-primary" href="{{ route('orders.create') }}">إضافة طلب</a>
    </div>
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
