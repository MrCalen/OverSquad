<?php

namespace App\Http\Controllers;

use Auth;
use JWTAuth;

class GameController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $token = JWTAuth::fromUser($user);
        return view('home/game', [
            'token' => $token,
        ]);
    }
}
