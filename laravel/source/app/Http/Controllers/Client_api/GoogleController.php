<?php

namespace App\Http\Controllers\Client_api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class GoogleController extends Controller
{
    public function getGoogleSignInUrl()
    {
        try {
            $url = Socialite::driver('google')->stateless()
                ->redirect()->getTargetUrl();
            return response()->json([
                'url' => $url,
            ])->setStatusCode(Response::HTTP_OK);
        } catch (\Exception $exception) {
            return $exception;
        }
    }

    public function loginCallback(Request $request)
    {
        try {
            $state = $request->input('state');

            parse_str($state, $result);
            $googleUser = Socialite::driver('google')->stateless()->user();

            $user = User::where('email', $googleUser->email)->first();
            if ($user) {
                // throw new \Exception(__('google sign in email existed'));
                $token = $user->createToken('myapptoken')->plainTextToken;
                return response()->json([
                    'status' => __('google sign in successful'),
                    'data' => $user,
                    'token' => $token
                ], Response::HTTP_CREATED);
            } else {
                $user = User::create(
                    [
                        'email' => $googleUser->email,
                        'name' => $googleUser->name,
                        'google_id' => $googleUser->id,
                        'password' => bcrypt('123'),
                    ]
                );
            }

            $token = $user->createToken('myapptoken')->plainTextToken;

            return response()->json([
                'status' => __('google sign in successful'),
                'data' => $user,
                'token' => $token
            ], Response::HTTP_CREATED);

        } catch (\Exception $exception) {
            return response()->json([
                'status' => __('google sign in failed'),
                'error' => $exception,
                'message' => $exception->getMessage()
            ], Response::HTTP_BAD_REQUEST);
        }
    }
}
