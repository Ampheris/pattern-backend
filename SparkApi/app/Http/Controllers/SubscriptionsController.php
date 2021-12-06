<?php

/*
|--------------------------------------------------------------------------
| Bike controller
|--------------------------------------------------------------------------
*/

namespace App\Http\Controllers;

use App\Models\Subscription;
use App\Models\User;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class SubscriptionsController extends Controller
{
    public function showAllSubscriptions()
    {
        $subscription = new Subscription();
        return response()->json($subscription::all());
    }

    // public function showOneSubscription($customerId)
    // {
    //     $subscription = new Subscription();
    //     return response()->json($subscription::where($customerId)->get());
    // }

    public function showCustomersCurrentSubscription($customerId)
    {
        $subscription = new Subscription();
        return response()->json($subscription::where('customer_id', $customerId)->latest()->first());
    }

    // public function showCustomersAllSubscriptions($customerId)
    // {
    //     $subscription = new Subscription();
    //     return response()->json($subscription::where($customerId)->get());
    // }

    public function start(Request $request)
    {
        date_default_timezone_set('Europe/Stockholm');
        $carbon = new Carbon();
        $date = $carbon::now();
        $renewalDate = $carbon::now();
        $renewalDate = $renewalDate->addDays(30);

        $currentSubscription = Subscription::where('customer_id', $request['customer_id'])->latest()->first();

        if ($currentSubscription && is_null($currentSubscription['cancelation_date'])) {
            return response('The user already has an active subscription.', 500);
        }
        /*
        * Requires:
        *  "start_date"
        *  "renewal_date"
        *  "cancelation_date"
        *  "price"
        *  "user_id"
        */

        $subscription = new Subscription();
        $request['start_date'] = $date;
        $request['renewal_date'] = $renewalDate;
        $request['price'] = 199;
        $subscription = $subscription::create($request->all());

        $this->createSubscriptionOrder($subscription);

        return response()->json($subscription, 201);
    }

    public function renew($subscriptionId, Request $request)
    {
        $carbon = new Carbon();
        $todaysDate = $carbon::now();

        $subscription = new Subscription();
        $subscription = $subscription::find($subscriptionId);

        $user = new User();
        $user = $user::find($subscription['customer_id']);

        if ($subscription['cancelation_date != null']) {
            return response()->json(['message' => 'Subscription not active'], 500);
        }

        if ($carbon::parse($subscription['renewal_date'])->gt($todaysDate)) {
            return response()->json(['message' => 'The subscription is active until ' . $subscription['renewal_date'] . ', and does not need to be renewed'], 500);
        }

        $renewalDate = $carbon::now();
        $renewalDate = $renewalDate->addDays(30);

        $request['start_date'] = $todaysDate;
        $request['renewal_date'] = $renewalDate;

        $subscription->update($request->all());

        $this->createSubscriptionOrder($subscription);
        return response()->json($subscription, 200);
    }

    public function createSubscriptionOrder($subscription)
    {
        $order = new Order();

        $data = [
            'customer_id' => $subscription->customer_id,
            'total_price' => $subscription->price,
            'order_date' => $subscription->start_date,
            'subscription' => 1
        ];

        $order = $order::create($data);

        return response()->json($order, 201);
    }

    public function stop($subscriptionId)
    {
        $carbon = new Carbon();
        $date = $carbon::now();

        $subscription = new Subscription();
        $subscription = $subscription::findOrFail($subscriptionId);
        $subscription->update(['cancelation_date' => $date]);

        return response()->json($subscription, 200);
    }
}
