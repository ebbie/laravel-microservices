<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Http\Response as HttpResponse;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        \Log::info("inside login function: ".print_r($request->only('email','password'),true));
        \Log::info("Auth::attempt($request->only('email','password'): ".Auth::attempt($request->only('email','password')));
        if(Auth::attempt($request->only('email','password'))) {

            $user = Auth::user();

            $token = $user->createToken("admin")->accessToken; // This is working now

            $cookie = \cookie('jwt',$token,3600);

            return \response([
                'token' => $token,
            ])->withCookie($cookie);
        }

        return response([
            'error' => 'Invald Credentials!'
        ], Response::HTTP_UNAUTHORIZED);
    }

    public function logout()
    {
        $cookie = \Cookie::forget('jwt');

        return \response([
            'messsage' => 'success'
        ])->withCookie($cookie);
    }

    public function register(RegisterRequest $request) {
        $user = User::create($request->only('first_name','last_name','email','role_id') + [
            'password' => Hash::make($request->input('password'))
        ]);

        return response($user, HttpResponse::HTTP_CREATED);
    }

}
