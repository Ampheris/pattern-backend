<?php

namespace App\Http\Controllers;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use mysql_xdevapi\Exception;
use Symfony\Component\HttpFoundation\RedirectResponse;

class SocialController extends Controller
{
    public function redirect(): RedirectResponse
    {
        $clientID = env('GITHUB_CLIENT_ID');
        $redirect_uri = env('GITHUB_URL');
        $redirectURL = "https://github.com/login/oauth/authorize?client_id=$clientID&redirect_uri=$redirect_uri&scope=user:email";

        return redirect($redirectURL);
    }

    public function Callback()
    {
        // Retrieve code
        $code = $_GET['code'];
        $URL = 'https://github.com/login/oauth/access_token';

        // POST request to get access token
        $access_token = $this->getAccessToken($URL, $code);

        // GET request to get user information
        $user = $this->httpGET($access_token);

        // User check
        return $this->checkUser(json_decode($user), $access_token);
    }

    public function checkUser($user, $access_token)
    {
        // $user is decoded
        $email = $user->email;
        $name = $user->name;
        $avatar_url = $user->avatar_url;
        $github_id = $user->id;


        try {
            $DBUser = DB::table('users')->where('github_id',$user->id)->first();
        } catch (\Throwable $e) {
            $DBUser = null;
        }

        if ($DBUser) {
            // If user exist, update user info
            DB::table('users')->update([
                'access_token' => $access_token,
                'email' => $email,
                'github_name' => $name,
                'avatar_url' => $avatar_url,
                'updated_at' => Carbon::now()
            ]);
        } else {
            // If not exist, create user
            DB::table('users')->insert([
                'access_token' => $access_token,
                'email' => $email,
                'github_name' => $name,
                'github_id' => $github_id,
                'avatar_url' => $avatar_url,
                'created_at' => Carbon::now()
            ]);
        }

        // Login user
        //Auth::login($user);
        $getUser = DB::table('users')->where('github_id',$user->id)->value('id');;

        return $getUser;
    }

    public function getAccessToken($url, $code)
    {
        // POST request
        $data = [
            'client_id' => env('GITHUB_CLIENT_ID'),
            'client_secret' => env('GITHUB_CLIENT_SECRET'),
            'code' => $code,
        ];

        $options = array(
            'http' => array(
                'header' => "Content-type: application/x-www-form-urlencoded",
                'method' => 'POST',
                'content' => http_build_query($data)
            )
        );
        $context = stream_context_create($options);
        $resp = file_get_contents($url, false, $context);

        $parameters = [];

        foreach (explode('&', $resp) as $chunk) {
            $param = explode("=", $chunk);

            $parameters[urldecode($param[0])] = urldecode($param[1]);
        }

        return $parameters['access_token'];
    }

    public function httpGET($access_token)
    {
        $url = "https://api.github.com/user";

        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

        $headers = array(
            "Accept: application/json",
            "Authorization: Bearer $access_token",
            "User-Agent: sparkapi/v1"
        );
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

        $resp = curl_exec($curl);
        curl_close($curl);
        return $resp;
    }
}
