@extends('layouts.app')

@section('content')
    <h2 class="mb-3">إضافة محافظة</h2>
    <form method="POST" action="{{ route('governorates.store') }}" class="card p-4 shadow-sm">
        @csrf
        <div class="mb-3">
            <label class="form-label">اسم المحافظة</label>
            <input type="text" name="name" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">سعر التوصيل</label>
            <input type="number" step="0.01" name="delivery_price_default" class="form-control" required>
        </div>
        <button class="btn btn-primary" type="submit">حفظ</button>
    </form>
@endsection
