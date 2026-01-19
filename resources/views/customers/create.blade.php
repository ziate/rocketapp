@extends('layouts.app')

@section('content')
    <h2 class="mb-3">إضافة عميل</h2>
    <form method="POST" action="{{ route('customers.store') }}" class="card p-4 shadow-sm">
        @csrf
        <div class="row">
            <div class="col-md-6 mb-3">
                <label class="form-label">اسم العميل</label>
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
                <label class="form-label">العنوان</label>
                <input type="text" name="address" class="form-control" required>
            </div>
            <div class="col-12 mb-3">
                <label class="form-label">ملاحظات</label>
                <textarea name="notes" class="form-control" rows="2"></textarea>
            </div>
        </div>

        <h5 class="mt-4">المناطق والأسعار الخاصة</h5>
        <div class="table-responsive">
            <table class="table">
                <thead>
                <tr>
                    <th>اختيار</th>
                    <th>المحافظة</th>
                    <th>المنطقة</th>
                    <th>سعر افتراضي</th>
                    <th>سعر خاص للعميل</th>
                </tr>
                </thead>
                <tbody>
                @foreach($areas as $area)
                    <tr>
                        <td>
                            <input type="checkbox" name="areas[{{ $area->id }}][selected]" value="1">
                        </td>
                        <td>{{ $area->governorate?->name }}</td>
                        <td>{{ $area->name }}</td>
                        <td>{{ $area->delivery_price_default }}</td>
                        <td>
                            <input type="number" step="0.01" name="areas[{{ $area->id }}][custom_delivery_price]" class="form-control" placeholder="اتركه فارغاً">
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
        <button class="btn btn-primary" type="submit">حفظ</button>
    </form>
@endsection
