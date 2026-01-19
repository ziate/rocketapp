@extends('layouts.app')

@section('content')
    <h2 class="mb-4">نظرة عامة</h2>
    <div class="row g-4">
        <div class="col-md-4">
            <div class="card card-stat shadow-sm">
                <div class="card-body">
                    <h6>إجمالي الطلبات</h6>
                    <h3>{{ $stats['orders'] }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card card-stat shadow-sm">
                <div class="card-body">
                    <h6>العملاء</h6>
                    <h3>{{ $stats['customers'] }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card card-stat shadow-sm">
                <div class="card-body">
                    <h6>مناديب التوصيل</h6>
                    <h3>{{ $stats['drivers'] }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card card-stat shadow-sm">
                <div class="card-body">
                    <h6>الطلبات المعلقة</h6>
                    <h3>{{ $stats['pending_orders'] }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card card-stat shadow-sm">
                <div class="card-body">
                    <h6>الطلبات المسلمة</h6>
                    <h3>{{ $stats['delivered_orders'] }}</h3>
                </div>
            </div>
        </div>
    </div>
@endsection
