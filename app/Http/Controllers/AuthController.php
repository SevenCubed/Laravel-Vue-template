<?php

//https://hasura.io/blog/best-practices-of-using-jwt-with-graphql/#login

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Resources\UserResource;


class AuthController extends Controller
{
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login', 'refresh']]);
    }

    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login()
    {
        $credentials = request(['email', 'password']);

        if (! $token = $this->guard()->attempt($credentials)) {
            return response()->json(['error' => 'Unauthorized, invalid credentials'], 401);
        }
        $user = response()->json( $this->guard()->user());
        $JWT = $this->respondWithToken($token);
        return [$JWT, $user];
    }

    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function me()
    {
        $user = new UserResource($this->guard()->user());
        return response()->json($user);
    }
    
    public function notifications()
    {
        $notifications = auth()->user()->unreadNotifications;
        return response()->json($notifications);
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        Auth::logout();

        return response()->json(['message' => 'Successfully logged out']);
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        // dd("?");
        return $this->respondWithToken( $this->guard()->refresh());
    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => Auth::factory()->getTTL()*60
        ]);
    }
    
    /** From Progress Insight repo
     * Get the guard to be used during authentication.
     *
     * @return \Illuminate\Contracts\Auth\Guard
     */
    public function guard()
    {
        return Auth::guard('api');
    }

}
