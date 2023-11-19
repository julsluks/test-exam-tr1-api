<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Mail\Email;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class AuthController extends Controller
{
    public function register(Request $request){
        $fields = $request->validate([
            'name' => 'required|string',
            'email'=> 'required|string|unique:users,email',
            'password'=> 'required|string|confirmed'
        ]);

        $user = User::create([
            'name'=> $fields['name'],
            'email'=> $fields['email'],
            'password'=> bcrypt($fields['password'])
        ]);

        $token = $user->createToken('myapptoken')->plainTextToken;

        $response = [
            'user' => $user,
            'token'=> $token
        ];

        Mail::to($user->email)->send(new Email($user));

        return response($response, 201);
    }

    public function login(Request $request){
        $fields = $request->validate([
            'email'=> 'required|string',
            'password'=> 'required|string'
        ]);

        //Check email
        $user = User::where('email', $fields['email'])->first();

        //Check password
        if(!$user || !Hash::check($fields['password'], $user->password)){
            return response([
                'message' => 'Credencials incorrectes'
            ], 401);
        }

        $token = $user->createToken('myapptoken')->plainTextToken;

        $response = [
            'user' => $user,
            'token'=> $token
        ];

        return response($response, 201);
    }

    public function logout(Request $request){
        auth()->user()->User::tokens()->delete();

        return [
            'message'=> 'Logged out'
        ];
    }
}
