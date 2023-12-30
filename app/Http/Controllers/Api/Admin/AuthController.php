<?php

namespace App\Http\Controllers\Api\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Exceptions\Api\LoginException;

class AuthController extends Controller
{
    /**
     * Api login function
     *
     * @param Request $request
     * @return void
     */
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'email|required',
            'password' => 'required',
        ]);

        // get infomation from request
        $credentials = request(['email', 'password']);
        if (! Auth::attempt($credentials)) {
            throw new LoginException(500, 'Unauthorized');
        }

        $user = Auth::user();
        $tokenResult = $user->createToken('authToken')->plainTextToken;

        return response()->json([
            'status_code' => 200,
            'access_token' => $tokenResult,
            'token_type' => 'Bearer',
        ]);
    }
}
