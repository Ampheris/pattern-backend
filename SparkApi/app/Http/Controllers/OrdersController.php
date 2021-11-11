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
    public function ShowAllOrders()
    {
        return response()->json(Order::all());
    }

    public function ShowOneOrder($order_id)
    {
        return response()->json(Order::where($order_id)->get());
    }

    public function ShowCustomersOrders($customer_id)
    {
        return response()->json(Order::where($customer_id)->get());
    }

    public function create(Request $request)
    {
        /*
        * Requires:
        *  "customer_id"
        *  "order_date"
        *  "total_price"
        */

        $order = Order::create($request->all());

        return response()->json($order, 201);
    }

}
