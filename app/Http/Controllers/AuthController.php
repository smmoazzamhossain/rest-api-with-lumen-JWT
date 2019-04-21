<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Mail;
use App\Http\Resources\UserResource;
use Illuminate\Http\Request;
use App\Models\User;
use Carbon\Carbon;

class AuthController extends Controller
{
    public function signupUser(Request $request)
    {
        try {
            $this->validate($request, [
                'user_name' => 'required|min:3',
                'email'     => 'required|email|unique:users',
                'password'  => 'required|min:6',
            ]);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 422);
        }

        try {
            $activationToken = str_random(60);

            // app('db')->table('users')->insert([
            //     'full_name'  => trim($request->full_name), 
            //     'user_name'  => strtolower(trim($request->user_name)), 
            //     'email'      => trim($request->email), 
            //     'password'   => app('hash')->make(trim($request->password)), 
            //     'created_at' => Carbon::now(), 
            //     'activation_token'   => $activationToken, 
            // ]);
            $user = User::create([
                'full_name' => trim($request->full_name),
                'user_name' => trim($request->user_name),
                'email' => trim($request->email),
                'password' => app('hash')->make(trim($request->password)),
                'created_at' => Carbon::now(),
                'activation_token' => str_random(60)
            ]);

            Mail::send('mails.signupActivate', ['user' => $user], function ($message) use ($user) {
                $message->to($user['email'], $user['full_name'])->subject('Confirm Your Account');
            });

            return response()->json([
                'success' => true,
                'message' => 'Account created successfully. To activate account please check your email'
            ], 201);
        } catch (Exception $e) {
            return repsonse()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 400);
        }
    }

    public function signupActivate($token)
    {
        try {
            $user = app('db')->table('users')->where('activation_token', $token)->first();

            if(!$user) {
                return response()->json([
                    'success' => false,
                    'message' => 'This activation token is invalid!'
                ], 400);
            }

            app('db')->table('users')->where('activation_token', $token)->update([
                'updated_at' => Carbon::now(),  
                'active'     => true,
                'activation_token' => ''
            ]);

            return new UserResource($user);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 400);
        }
    }

    public function authenticate(Request $request)
    {
        try {
            $this->validate($request, [
                'email'    => 'required|email',
                'password' => 'required|min:6',
            ]);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 422);
        }

        try {
            $credentials = $request->only('email', 'password');
            $credentials['active'] = true;
            
            $token = app('auth')->attempt($credentials);
            if(!$token) {
                return response()->json([
                    'success' => false,
                    'message' => 'You enter invalid credentials'
                ], 401);
            }

            return response()->json([
                'success'      => true,
                'access_token' => $token,
                'token_type'   => 'Bearer',
                'expires_at'   => ''
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 400);
        }
    }

    public function logout()
    {
        try {
            app('auth')->logout();

            return response()->json([
                'success' => true,
                'message' => 'Successfully logout'
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 400);
        }
    }
    
}
