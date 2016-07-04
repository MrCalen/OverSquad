<?php

namespace App\Http\Controllers;

use Auth;
use JWTAuth;
use Redirect;

class GameController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        if ($user && $user->level === 0) {
            return response()->view('errors.403', [
                'error' => 'your gametag is invalid',
            ], 403);
        }
        $token = JWTAuth::fromUser($user);
        return view('home/game', [
            'token' => $token,
        ]);
    }
}
