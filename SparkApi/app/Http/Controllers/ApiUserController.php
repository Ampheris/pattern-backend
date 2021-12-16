<?php

namespace App\Http\Controllers;

// use App\Http\Controllers\Controller;
use App\Models\ApiUser;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

class ApiUserController extends Controller
{
    public function showAllUsers()
    {
        $bike = new ApiUser();
        return response()->json($bike::all());
    }
    /**
     * Show the profile for a given user.
     *
     * @param  int  $id
     * @return \Illuminate\View\View
     */
    public function show($id)
    {
        return view('user.profile', [
            'user' => ApiUser::findOrFail($id)
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     */
    public function create(Request $request)
    {
        $user = new ApiUser();
        $request['api_token'] = Str::random(60);
        $user = $user::create($request->all());

        return response()->json($user, 201);
    }

    /**
     * Update the authenticated user's API token.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function updateToken(Request $request)
    {
        $token = Str::random(60);

        $request->user()->forceFill([
            Str::random(60),
        ])->save();

        return ['token' => $token];
    }

    public function update($userId, Request $request)
    {
        $user = new ApiUser();
        $user = $user::findOrFail($userId);
        $user->update($request->all());

        return response()->json($user, 200);
    }

    public function delete($userId)
    {
        $user = new ApiUser();
        $user::findOrFail($userId)->delete();
        return response('Deleted Successfully', 200);
    }
}
