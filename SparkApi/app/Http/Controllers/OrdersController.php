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

    public function showCustomersOrders($customerId)
    {
        $order = new Order();
        return response()->json($order::where('customer_id', $customerId)->orderBy('created_at', 'desc')->get());
    }

    public function showOrderForBikeride($bikehistoryId)
    {
        $order = new Order();
        return response()->json($order::where('bikehistory_id', $bikehistoryId)->get());
    }

    public function showSingleOrder($orderId)
    {
        $order = new Order();
        return response()->json($order::find($orderId)->get());
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
