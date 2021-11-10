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
    
    public function ShowOneOrder($id)
    {
        return response()->json(Order::find($id));
    }

    public function ShowOneOShowAllCustomerOrdersrder()
    {
        return response()->json(Order::all());
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