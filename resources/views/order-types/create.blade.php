@extends('layouts.app')

@section('content')
    <h2 class="mb-3">إضافة نوع طلب</h2>
    <form method="POST" action="{{ route('order-types.store') }}" class="card p-4 shadow-sm">
        @csrf
        <div class="mb-3">
            <label class="form-label">اسم النوع</label>
            <input type="text" name="name" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">الوصف</label>
            <textarea name="description" class="form-control" rows="2"></textarea>
        </div>
        <div class="form-check mb-3">
            <input type="checkbox" name="is_active" value="1" class="form-check-input" checked>
            <label class="form-check-label">نشط</label>
        </div>
        <button class="btn btn-primary" type="submit">حفظ</button>
    </form>
@endsection
