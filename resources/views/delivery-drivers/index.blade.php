@extends('layouts.app')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>مناديب التوصيل</h2>
        <a class="btn btn-primary" href="{{ route('delivery-drivers.create') }}">إضافة مندوب</a>
    </div>

    <form class="card p-3 mb-3 shadow-sm" method="GET" action="{{ route('delivery-drivers.index') }}">
        <div class="row g-3 align-items-end">
            <div class="col-md-6">
                <label class="form-label">بحث بالاسم أو الهاتف</label>
                <input type="text" name="search" value="{{ request('search') }}" class="form-control" placeholder="مثال: محمد أو 011">
            </div>
            <div class="col-md-6 d-flex gap-2">
                <button class="btn btn-secondary" type="submit">بحث</button>
                <a class="btn btn-outline-secondary" href="{{ route('delivery-drivers.index') }}">إعادة ضبط</a>
            </div>
        </div>
    </form>

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
