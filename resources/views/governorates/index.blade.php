@extends('layouts.app')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>المحافظات</h2>
        <a class="btn btn-primary" href="{{ route('governorates.create') }}">إضافة محافظة</a>
    </div>
    <div class="card shadow-sm">
        <div class="table-responsive">
            <table class="table mb-0">
                <thead>
                <tr>
                    <th>#</th>
                    <th>الاسم</th>
                    <th>سعر التوصيل</th>
                    <th>إجراءات</th>
                </tr>
                </thead>
                <tbody>
                @foreach($governorates as $governorate)
                    <tr>
                        <td>{{ $governorate->id }}</td>
                        <td>{{ $governorate->name }}</td>
                        <td>{{ $governorate->delivery_price_default }}</td>
                        <td class="d-flex gap-2">
                            <a class="btn btn-sm btn-outline-secondary" href="{{ route('governorates.edit', $governorate) }}">تعديل</a>
                            <form method="POST" action="{{ route('governorates.destroy', $governorate) }}">
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
