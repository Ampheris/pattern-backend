<?php

namespace App\Http\Controllers;

// use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function showAllUsers()
    {
        $bike = new User();
        return response()->json($bike::all());
    }
    /**
     * Show the profile for a given user.
     *
     * @param  int  $id
     * @return \Illuminate\View\View
     */
    public function showOneUser($userId)
    {
        $user = new User();
        return response()->json($user::where($userId)->get());
    }

    /**
     * Create a new user instance after a valid registration.
     *
     */
    public function create(Request $request)
    {
        $user = new User();
        $user = $user::create($request->all());

        return response()->json($user, 201);
    }

    public function update($userId, Request $request)
    {
        $user = new User();
        $user = $user::findOrFail($userId);
        $user->update($request->all());

        return response()->json($user, 200);
    }

    public function delete($userId)
    {
        $user = new User();
        $user::findOrFail($userId)->delete();
        return response('Deleted Successfully', 200);
    }
}
