@extends('layouts.app')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>مناديب التوصيل</h2>
        <a class="btn btn-primary" href="{{ route('delivery-drivers.create') }}">إضافة مندوب</a>
    </div>
    <div class="card shadow-sm">
        <div class="table-responsive">
            <table class="table mb-0">
                <thead>
                <tr>
                    <th>#</th>
                    <th>الاسم</th>
                    <th>الهاتف</th>
                    <th>المحافظة</th>
                    <th>المنطقة</th>
                    <th>الحالة</th>
                    <th>إجراءات</th>
                </tr>
                </thead>
                <tbody>
                @foreach($drivers as $driver)
                    <tr>
                        <td>{{ $driver->id }}</td>
                        <td>{{ $driver->name }}</td>
                        <td>{{ $driver->phone }}</td>
                        <td>{{ $driver->governorate?->name }}</td>
                        <td>{{ $driver->area?->name }}</td>
                        <td>{{ $driver->status }}</td>
                        <td class="d-flex gap-2">
                            <a class="btn btn-sm btn-outline-secondary" href="{{ route('delivery-drivers.edit', $driver) }}">تعديل</a>
                            <form method="POST" action="{{ route('delivery-drivers.destroy', $driver) }}">
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
