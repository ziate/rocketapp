@extends('layouts.app')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>سجل النشاطات</h2>
    </div>

    <form class="card p-3 mb-3 shadow-sm" method="GET" action="{{ route('activity-logs.index') }}">
        <div class="row g-3">
            <div class="col-md-6">
                <label class="form-label">نوع الحدث</label>
                <input type="text" name="action" value="{{ request('action') }}" class="form-control" placeholder="order.updated">
            </div>
            <div class="col-md-6">
                <label class="form-label">نوع الكيان</label>
                <input type="text" name="subject_type" value="{{ request('subject_type') }}" class="form-control" placeholder="App\\Models\\Order">
            </div>
            <div class="col-md-12 d-flex gap-2">
                <button class="btn btn-secondary" type="submit">تصفية</button>
                <a class="btn btn-outline-secondary" href="{{ route('activity-logs.index') }}">إعادة ضبط</a>
            </div>
        </div>
    </form>

    <div class="card shadow-sm">
        <div class="table-responsive">
            <table class="table mb-0">
                <thead>
                <tr>
                    <th>الحدث</th>
                    <th>الكيان</th>
                    <th>رقم الكيان</th>
                    <th>التاريخ</th>
                </tr>
                </thead>
                <tbody>
                @foreach($logs as $log)
                    <tr>
                        <td>{{ $log->action }}</td>
                        <td>{{ $log->subject_type }}</td>
                        <td>{{ $log->subject_id }}</td>
                        <td>{{ $log->created_at }}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
