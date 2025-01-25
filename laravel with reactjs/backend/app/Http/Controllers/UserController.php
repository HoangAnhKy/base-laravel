<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Validation\ValidationException;

class UserController extends Controller
{
    public function register(Request $request)
    {
        try {
            $valite = $request->validate([
                'name' => 'required|string|unique:users',
                'email' => 'required|email|unique:users',
                'password' => 'required|string|min:6'
            ]);

            if (User::query()->create($valite)) {
                return response()->json([
                    'message' => 'Successfully created user!'
                ], 201);
            }
            throw new \Exception("Could not create user");
        } catch (ValidationException $e) {
            $error = current(current($e->errors()));

            return response()->json([
                "error" => $e->errors(),
                'message' => "Register failed: " . $error
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Register failed: ' . $e->getMessage()
            ], 422);
        }

    }

    public function login(Request $request)
    {
        try {
            $validated = $request->validate([
                'email' => 'required|email',
                'password' => 'required|string|min:6'
            ]);

            if (!auth()->attempt($validated)) {
                throw new \Exception("Invalid email or password");
            }
            $user = auth()->user();
            $token = $user->createToken($user->name)->plainTextToken;

            return response()->json([
                'token' => $token,
                'user' => $user,
                'message' => "Hi {$user->name}, Login success"
            ])->cookie("sys_token", $token, time() + 3600, null, null, true, false);

        } catch (ValidationException $e) {
            $error = current(current($e->errors()));

            return response()->json([
                "error" => $e->errors(),
                'message' => "Login failed: " . $error
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Login failed: ' . $e->getMessage()
            ], 422);
        }
    }

    public function getUser(Request $request)
    {
        if (!empty($request->user())) {
            return response()->json([
                'user' => $request->user()
            ]);
        }
        return response()->json([
            'message' => 'Not found userLogin'
        ], 422);
    }

    public function logout(Request $request)
    {
        try {
            if (!empty($user = $request->user())) {
                $user->tokens()->where("name", $user->name)->delete();
                $cookie = Cookie::forget('sys_token');
                return response()->json([
                    'message' => 'Logout success'
                ])->withCookie($cookie);
            }
        }catch (\Exception $e){
            return response()->json([
                'message' => 'bug: ' . $e->getMessage()
            ], 422);
        }
        return response()->json([
            'message' => 'Not found userLogin'
        ], 403);
    }
}
