<?php
/*
|--------------------------------------------------------------------------
| Bike controller
|--------------------------------------------------------------------------
*/

namespace App\Http\Controllers;

use App\Models\Orders;
use Illuminate\Http\Request;

class OrdersController extends Controller
{
    public function ShowAllOrders()
    {
        return response()->json(Orders::all());
    }
    
    public function ShowOneOrder($id)
    {
        return response()->json(Orders::find($id));
    }

    public function ShowOneOShowAllCustomerOrdersrder()
    {
        return response()->json(Orders::all());
    }


    public function create(Request $request)
    {
        /*
        * Requires:
        *  "customer_id"
        *  "order_date"
        *  "total_price"
        */

        $order = Orders::create($request->all());

        return response()->json($order, 201);
    }

}