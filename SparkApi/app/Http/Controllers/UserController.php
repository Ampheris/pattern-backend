<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class UserController extends Controller
{
    public function showAllUsers()
    {
        $bike = new User();
        return response()->json($bike::all());
    }

    public function showOneUser(Request $request): JsonResponse
    {
        return response()->json($request->user());
    }

    public function create(Request $request)
    {
        $user = new User();
        $user = $user::create($request->all());

        return response()->json($user, 201);
    }

    public function update(Request $request)
    {
        $user = $request->user();
        DB::table('users')->where('access_token', $user->access_token)->increment('balance', $_GET['balance']);

        return response()->json($user, 200);
    }

    public function delete($userId)
    {
        $user = new User();
        $user::findOrFail($userId)->delete();
        return response('Deleted Successfully', 200);
    }
}
