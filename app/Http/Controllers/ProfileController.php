<?php

namespace App\Http\Controllers;

use App\Http\Middleware\Api;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\User;

class ProfileController extends Controller
{
    public function apiProfile(Request $request)
    {
        if (!$request->has('user_id')) {
            return Api::throwError("UserId not provided", 403);
        }

        $userId = $request->get('user_id');
        $user = User::where('id', '=', $userId)->first();

        if (!$user) {
            return Api::throwError("UserId not provided", 404);
        }

        return Response::json($user);
    }
}
