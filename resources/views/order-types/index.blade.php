@extends('layouts.app')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>أنواع الطلبات</h2>
        <a class="btn btn-primary" href="{{ route('order-types.create') }}">إضافة نوع طلب</a>
    </div>
    <div class="card shadow-sm">
        <div class="table-responsive">
            <table class="table mb-0">
                <thead>
                <tr>
                    <th>#</th>
                    <th>الاسم</th>
                    <th>الحالة</th>
                    <th>إجراءات</th>
                </tr>
                </thead>
                <tbody>
                @foreach($orderTypes as $orderType)
                    <tr>
                        <td>{{ $orderType->id }}</td>
                        <td>{{ $orderType->name }}</td>
                        <td>{{ $orderType->is_active ? 'نشط' : 'غير نشط' }}</td>
                        <td class="d-flex gap-2">
                            <a class="btn btn-sm btn-outline-secondary" href="{{ route('order-types.edit', $orderType) }}">تعديل</a>
                            <form method="POST" action="{{ route('order-types.destroy', $orderType) }}">
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
