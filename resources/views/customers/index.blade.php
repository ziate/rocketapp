@extends('layouts.app')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>العملاء</h2>
        <a class="btn btn-primary" href="{{ route('customers.create') }}">إضافة عميل</a>
    </div>

    <form class="card p-3 mb-3 shadow-sm" method="GET" action="{{ route('customers.index') }}">
        <div class="row g-3 align-items-end">
            <div class="col-md-6">
                <label class="form-label">بحث بالاسم أو الهاتف</label>
                <input type="text" name="search" value="{{ request('search') }}" class="form-control" placeholder="مثال: أحمد أو 0100">
            </div>
            <div class="col-md-6 d-flex gap-2">
                <button class="btn btn-secondary" type="submit">بحث</button>
                <a class="btn btn-outline-secondary" href="{{ route('customers.index') }}">إعادة ضبط</a>
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
                    <th>عدد المناطق</th>
                    <th>إجراءات</th>
                </tr>
                </thead>
                <tbody>
                @foreach($customers as $customer)
                    <tr>
                        <td>{{ $customer->id }}</td>
                        <td>{{ $customer->name }}</td>
                        <td>{{ $customer->phone }}</td>
                        <td>{{ $customer->areas->count() }}</td>
                        <td class="d-flex gap-2">
                            <a class="btn btn-sm btn-outline-secondary" href="{{ route('customers.edit', $customer) }}">تعديل</a>
                            <form method="POST" action="{{ route('customers.destroy', $customer) }}">
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
