<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>لوحة التحكم - نظام التوصيل</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background-color: #f5f6fa; }
        .sidebar { min-height: 100vh; background: #1f2937; }
        .sidebar a { color: #e5e7eb; text-decoration: none; display: block; padding: 0.75rem 1rem; }
        .sidebar a:hover { background: #111827; }
        .content { padding: 2rem; }
        .card-stat { border: none; border-radius: 12px; }
    </style>
</head>
<body>
<div class="container-fluid">
    <div class="row">
        <aside class="col-md-3 col-lg-2 sidebar">
            @include('partials.sidebar')
        </aside>
        <main class="col-md-9 col-lg-10 content">
            @if(session('status'))
                <div class="alert alert-success">{{ session('status') }}</div>
            @endif
            @yield('content')
        </main>
    </div>
</div>
</body>
</html>
