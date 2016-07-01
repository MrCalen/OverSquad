<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use JWTAuth;

class AdminController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        $token = JWTAuth::fromUser($user);
        return view('admin/admin', [
            'token' => $token,
        ]);
    }
}
