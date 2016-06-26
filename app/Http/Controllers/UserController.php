<?php

namespace App\Http\Controllers;

use App\User;

class UserController extends Controller
{
    /**
     * Show the profile for the given user.
     *
     * @param  int  $id
     * @return Response
     */
    public function showProfile($id)
    {
        return view('user.profile', ['user' => User::findOrFail($id)]);
    }

    /**
     * Show a form to edit the profile of the given user.
     *
     * @param  int  $id
     * @return Response
     */
    public function editProfile($id)
    {
        return view('user.profile_edit', ['user' => User::findOrFail($id)]);
    }

    /**
     * Edit the profile of the given user.
     *
     * @param  int  $id
     * @return Response
     */
    public function editProfilePost($id)
    {
        return redirect()->route('showProfile', ['id' => $id]);
    }
}