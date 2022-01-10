<?php

namespace App\Providers;

use App\Models\ApiUser;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Boot the authentication services for the application.
     *
     * @return void
     */
    public function boot()
    {
        // Here you may define how you wish users to be authenticated for your Lumen
        // application. The callback which receives the incoming request instance
        // should return either a User instance or null. You're free to obtain
        // the User instance via an API token or any other method necessary.

        // $this->app['auth']->viaRequest('api', function ($request) {
        //     if ($request->input('api_token')) {
        //         return User::where('api_token', $request->input('api_token'))->first();
        //     }
            $this->app['auth']->viaRequest('api', function ($request) {
                // $ApiKey = $request->header('Api_Token');
                if ($request->header('Api_Token')) {
                    $user = ApiUser::where('api_token', $request->header('Api_Token'))->first();
                    if (!is_null($user)) {
                        $number_of_requests = $user->value('requests') + 1;
                        $user->update(['requests' => $number_of_requests]);
                        return $user;
                    }
                }
            //
                return null;
            });
        // });
    }
}
