<?php

/*
|--------------------------------------------------------------------------
| Bike controller
|--------------------------------------------------------------------------
*/

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrdersController extends Controller
{
    public function showAllOrders()
    {
        $order = new Order();
        return response()->json($order::all());
    }

    public function showCustomersOrders(Request $request)
    {
        $user = $request->user();
        $order = DB::table('orders')->where('customer_id', $user->id)->orderBy('created_at', 'desc')->get();
        return response()->json($order);
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
