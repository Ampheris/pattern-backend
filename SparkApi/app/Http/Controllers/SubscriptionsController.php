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
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Laravel\Lumen\Http\ResponseFactory;

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

    public function showCustomersCurrentSubscription(Request $request): JsonResponse
    {
        $user = $request->user();
        $subscription = new Subscription();
        return response()->json($subscription::where('customer_id', $user->id)->latest()->first());
    }

    // public function showCustomersAllSubscriptions($customerId)
    // {
    //     $subscription = new Subscription();
    //     return response()->json($subscription::where($customerId)->get());
    // }

    public function start(Request $request): Response|JsonResponse|ResponseFactory
    {
        date_default_timezone_set('Europe/Stockholm');
        $date = Carbon::now();
        $renewalDate = Carbon::now()->addDays(30);
        $user = $request->user();

        try {
            $currentSubscription = Subscription::where('customer_id', $user->id)->latest()->first();
        } catch (\Throwable $e) {
            $currentSubscription = null;
        }

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

        DB::table('subscriptions')->insert([
            'start_date' => $date,
            'renewal_date' => $renewalDate,
            'price' => 199,
            'customer_id' => $user->id,
            'created_at' => Carbon::now()
        ]);

        $subscription = DB::table('subscriptions')->where('customer_id', $user->id)->first();

        $this->createSubscriptionOrder($subscription);

        return response()->json($subscription, 201);
    }

    public function renew(Request $request): JsonResponse
    {
        $todaysDate = Carbon::now();
        $user = $request->user();

        $subscription = DB::table('subscriptions')->where('customer_id', $user->id)->first();

        if ($subscription['cancelation_date != null']) {
            return response()->json(['message' => 'Subscription not active'], 500);
        }

        if (Carbon::parse($subscription['renewal_date'])->gt($todaysDate)) {
            return response()->json(['message' => 'The subscription is active until ' . $subscription['renewal_date'] . ', and does not need to be renewed'], 500);
        }

        $renewalDate = Carbon::now()->addMonth();

        $subscription->update([
            'renewal_date' => $renewalDate,
            'updated_at' => Carbon::now()
        ]);

        $this->createSubscriptionOrder($subscription);
        return response()->json($subscription, 200);
    }

    public function createSubscriptionOrder($subscription): JsonResponse
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

    public function stop(): JsonResponse
    {
        $date = Carbon::now();
        $sub_id = $_GET['subscription_id'];

        DB::table('subscriptions')->where('id', $sub_id)->update([
            'cancelation_date' => $date,
            'updated_at' => $date
        ]);

        return response()->json(DB::table('subscriptions')->where('subscription_id', $_GET['subscription_id'])->get(), 200);
    }
}
