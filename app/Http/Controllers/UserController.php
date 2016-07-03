<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

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
     * @param  Request $request
     * @param  int  $id
     * @return Response
     */
    public function editProfilePost(Request $request, $id)
    {
        $updated = $request->all();

        unset($updated['email']);
        unset($updated['level']); // nope, haxxors

        User::findOrFail($id)->update($updated);
        return redirect()->route('showProfile', ['id' => $id]);
    }
}