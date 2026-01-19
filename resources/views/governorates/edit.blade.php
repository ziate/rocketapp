@extends('layouts.app')

@section('content')
    <h2 class="mb-3">تعديل محافظة</h2>
    <form method="POST" action="{{ route('governorates.update', $governorate) }}" class="card p-4 shadow-sm">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label class="form-label">اسم المحافظة</label>
            <input type="text" name="name" value="{{ $governorate->name }}" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">سعر التوصيل</label>
            <input type="number" step="0.01" name="delivery_price_default" value="{{ $governorate->delivery_price_default }}" class="form-control" required>
        </div>
        <button class="btn btn-primary" type="submit">تحديث</button>
    </form>
@endsection
