<?php

namespace App\Http\Controllers\API\v1\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Repositories\UserRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Response;

class AuthController extends Controller
{
    /**
     * Register new user
     * @method Post
     * @param Request $request
     * @return JsonResponse
     */
    public function register(Request $request)
    {
        // validate form inputs
        $request->validate([
            'name' => ['required'],
            'email' => ['required', 'email', 'unique:users'],
            'password' => ['required']
        ]);

        // Insert user into database
        resolve(UserRepository::class)->create($request);

        return response()->json([
            'message' => "user created successfully"
        ] . Response::HTTP_CREATED);
    }

    /**
     * Login user
     * @method GET
     * @param Request $request
     * @return JsonResponse
     * @throws ValidationException
     */
    public function login(Request $request)
    {
        // validate form inputs
        $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required']
        ]);

        // Check user credentials for login
        if (Auth::attempt($request->only(['email', 'password']))) {
            return response()->json(Auth::user(), Response::HTTP_OK);
        }

        throw ValidationException::withMessages([
            'email' => 'Incorrect credentials'
        ]);
    }

    public function user()
    {
        return response()->json(Auth::user(), Response::HTTP_OK);
    }

    public function logout()
    {
        Auth::logout();

        return response()->json([
            "message" => "logged out successfully"
        ], Response::HTTP_OK);
    }
}
