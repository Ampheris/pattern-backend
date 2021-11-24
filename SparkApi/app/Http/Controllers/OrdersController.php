<?php

/*
|--------------------------------------------------------------------------
| Bike controller
|--------------------------------------------------------------------------
*/

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class OrdersController extends Controller
{
    public function showAllOrders()
    {
        $order = new Order();
        return response()->json($order::all());
    }

    public function showOneOrder($orderId)
    {
        $order = new Order();
        return response()->json($order::where($orderId)->get());
    }

    public function showCustomersOrders($customerId)
    {
        $order = new Order();
        return response()->json($order::where($customerId)->get());
    }

    public function create(Request $request)
    {
        /*
        * Requires:
        *  "customer_id"
        *  "order_date"
        *  "total_price"
        */

        $order = new Order();
        $order = $order::create($request->all());

        return response()->json($order, 201);
    }
}
