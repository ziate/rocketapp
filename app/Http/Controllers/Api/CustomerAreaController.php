<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use Illuminate\Http\JsonResponse;

class CustomerAreaController extends Controller
{
    public function index(Customer $customer): JsonResponse
    {
        $customer->load('areas.governorate');

        $areas = $customer->areas->map(function ($area) {
            return [
                'id' => $area->id,
                'name' => $area->name,
                'governorate' => $area->governorate?->name,
                'delivery_price_default' => $area->delivery_price_default,
                'custom_delivery_price' => $area->pivot?->custom_delivery_price,
            ];
        });

        return response()->json([
            'customer_id' => $customer->id,
            'areas' => $areas,
        ]);
    }
}
