@extends('layouts.app')

@section('content')
    <h2 class="mb-3">تعديل مندوب</h2>
    <form method="POST" action="{{ route('delivery-drivers.update', $deliveryDriver) }}" class="card p-4 shadow-sm">
        @csrf
        @method('PUT')
        <div class="row">
            <div class="col-md-6 mb-3">
                <label class="form-label">اسم المندوب</label>
                <input type="text" name="name" value="{{ $deliveryDriver->name }}" class="form-control" required>
            </div>
            <div class="col-md-6 mb-3">
                <label class="form-label">الهاتف</label>
                <input type="text" name="phone" value="{{ $deliveryDriver->phone }}" class="form-control" required>
            </div>
            <div class="col-md-6 mb-3">
                <label class="form-label">البريد الإلكتروني</label>
                <input type="email" name="email" value="{{ $deliveryDriver->email }}" class="form-control">
            </div>
            <div class="col-md-6 mb-3">
                <label class="form-label">رقم الهوية</label>
                <input type="text" name="national_id" value="{{ $deliveryDriver->national_id }}" class="form-control">
            </div>
            <div class="col-12 mb-3">
                <label class="form-label">العنوان</label>
                <input type="text" name="address" value="{{ $deliveryDriver->address }}" class="form-control" required>
            </div>
            <div class="col-md-6 mb-3">
                <label class="form-label">المحافظة</label>
                <select name="governorate_id" class="form-select">
                    <option value="">اختياري</option>
                    @foreach($governorates as $governorate)
                        <option value="{{ $governorate->id }}" @selected($deliveryDriver->governorate_id === $governorate->id)>{{ $governorate->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-6 mb-3">
                <label class="form-label">المنطقة</label>
                <select name="area_id" class="form-select">
                    <option value="">اختياري</option>
                    @foreach($areas as $area)
                        <option value="{{ $area->id }}" @selected($deliveryDriver->area_id === $area->id)>{{ $area->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-6 mb-3">
                <label class="form-label">الحالة</label>
                <select name="status" class="form-select" required>
                    <option value="active" @selected($deliveryDriver->status === 'active')>نشط</option>
                    <option value="inactive" @selected($deliveryDriver->status === 'inactive')>غير نشط</option>
                </select>
            </div>
        </div>
        <button class="btn btn-primary" type="submit">تحديث</button>
    </form>
@endsection
