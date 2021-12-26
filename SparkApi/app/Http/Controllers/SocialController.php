<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Symfony\Component\HttpFoundation\Cookie;
use Illuminate\Support\Facades\DB;
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

        // Checks after the user and updates their information.
        $role = $this->checkUser(json_decode($user), $access_token);

        if ($role == 'admin') {
            return redirect('http://localhost:8000/admin')->withCookies([Cookie::create('access_token', $access_token), Cookie::create('role', $role)]);
        }

        return redirect('http://localhost:8000/')->withCookies([Cookie::create('access_token', $access_token), Cookie::create('role', $role)]);

    }

    /*
     * Checks after the user and
     */
    public function checkUser($user, $access_token)
    {
        // $user is decoded
        $email = $user->email;
        $name = $user->name;
        $avatar_url = $user->avatar_url;
        $github_id = $user->id;


        try {
            $DBUser = DB::table('users')->where('github_id', $user->id)->first();
        } catch (\Throwable $e) {
            $DBUser = null;
        }

        if ($DBUser) {
            // If user exist, update user info
            DB::table('users')->where('id', $DBUser->id)->update([
                'access_token' => $access_token,
                'email' => $email,
                'github_name' => $name,
                'avatar_url' => $avatar_url,
                'updated_at' => Carbon::now(),
                'token_expires' => Carbon::now()->addHour()
            ]);
        } else {
            // If not exist, create user
            DB::table('users')->insert([
                'access_token' => $access_token,
                'token_expires' => Carbon::now()->addHour(),
                'email' => $email,
                'github_name' => $name,
                'github_id' => $github_id,
                'avatar_url' => $avatar_url,
                'created_at' => Carbon::now()
            ]);
        }

        $role = DB::table('users')->where('github_id', $user->id)->value('role');
        return $role;
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
