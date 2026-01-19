@extends('layouts.app')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>العملاء</h2>
        <a class="btn btn-primary" href="{{ route('customers.create') }}">إضافة عميل</a>
    </div>
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
