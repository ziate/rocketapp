@extends('layouts.app')

@section('content')
    <h2 class="mb-3">إضافة مندوب</h2>
    <form method="POST" action="{{ route('delivery-drivers.store') }}" class="card p-4 shadow-sm">
        @csrf
        <div class="row">
            <div class="col-md-6 mb-3">
                <label class="form-label">اسم المندوب</label>
                <input type="text" name="name" class="form-control" required>
            </div>
            <div class="col-md-6 mb-3">
                <label class="form-label">الهاتف</label>
                <input type="text" name="phone" class="form-control" required>
            </div>
            <div class="col-md-6 mb-3">
                <label class="form-label">البريد الإلكتروني</label>
                <input type="email" name="email" class="form-control">
            </div>
            <div class="col-md-6 mb-3">
                <label class="form-label">رقم الهوية</label>
                <input type="text" name="national_id" class="form-control">
            </div>
            <div class="col-12 mb-3">
                <label class="form-label">العنوان</label>
                <input type="text" name="address" class="form-control" required>
            </div>
            <div class="col-md-6 mb-3">
                <label class="form-label">المحافظة</label>
                <select name="governorate_id" class="form-select">
                    <option value="">اختياري</option>
                    @foreach($governorates as $governorate)
                        <option value="{{ $governorate->id }}">{{ $governorate->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-6 mb-3">
                <label class="form-label">المنطقة</label>
                <select name="area_id" class="form-select">
                    <option value="">اختياري</option>
                    @foreach($areas as $area)
                        <option value="{{ $area->id }}">{{ $area->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-6 mb-3">
                <label class="form-label">الحالة</label>
                <select name="status" class="form-select" required>
                    <option value="active">نشط</option>
                    <option value="inactive">غير نشط</option>
                </select>
            </div>
        </div>
        <button class="btn btn-primary" type="submit">حفظ</button>
    </form>
@endsection
