@extends('layouts.app')

@section('content')
    <h2 class="mb-3">تعديل منطقة</h2>
    <form method="POST" action="{{ route('areas.update', $area) }}" class="card p-4 shadow-sm">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label class="form-label">المحافظة</label>
            <select name="governorate_id" class="form-select" required>
                @foreach($governorates as $governorate)
                    <option value="{{ $governorate->id }}" @selected($area->governorate_id === $governorate->id)>{{ $governorate->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="mb-3">
            <label class="form-label">اسم المنطقة</label>
            <input type="text" name="name" value="{{ $area->name }}" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">سعر التوصيل</label>
            <input type="number" step="0.01" name="delivery_price_default" value="{{ $area->delivery_price_default }}" class="form-control" required>
        </div>
        <button class="btn btn-primary" type="submit">تحديث</button>
    </form>
@endsection
