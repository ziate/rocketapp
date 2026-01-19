<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\DeliveryDriver;
use App\Models\Order;
use App\Models\OrderType;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $stats = [
            'orders' => Order::count(),
            'customers' => Customer::count(),
            'drivers' => DeliveryDriver::count(),
            'order_types' => OrderType::count(),
            'pending_orders' => Order::where('status', 'pending')->count(),
            'delivered_orders' => Order::where('status', 'delivered')->count(),
        ];

        return view('dashboard.index', compact('stats'));
    }
}
