<div class="p-3">
    <h4 class="text-white mb-4">لوحة التحكم</h4>
    <nav class="nav flex-column">
        <a href="{{ route('dashboard') }}">الرئيسية</a>
        <a href="{{ route('orders.index') }}">الطلبات</a>
        <a href="#">المستخدمين</a>
        <a href="{{ route('customers.index') }}">العملاء</a>
        <a href="{{ route('delivery-drivers.index') }}">مناديب التوصيل</a>
        <a href="{{ route('order-types.index') }}">أنواع الطلبات</a>
        <a href="{{ route('governorates.index') }}">المحافظات</a>
        <a href="{{ route('areas.index') }}">المناطق</a>
        <a href="{{ route('activity-logs.index') }}">سجل النشاطات</a>
    </nav>
</div>
