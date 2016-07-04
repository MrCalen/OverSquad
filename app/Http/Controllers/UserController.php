<?php

namespace App\Http\Controllers;

use Log;
use App\Models\Game;
use App\User;
use Illuminate\Http\Request;
use Validator;
use Session;
use Auth;

class UserController extends Controller
{
    /**
     * Get a validator for an incoming profile edition request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return validator()->make($data, [
            'name' => 'required|max:255',
            'password' => 'min:6|confirmed',
            'gametag' => array('Regex:/([A-Za-z]*)#([0-9]{4})/'),
        ]);
    }

    /**
     * Show the profile for the given user.
     *
     * @param  int  $id
     * @return Response
     */
    public function showProfile($id)
    {
        $user = User::findOrFail($id);
        $data = [
            'user' => $user,
            'games' => $this->getLastTenGames($id),
        ];
        return view('user.profile', $data);
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
        $fields = $request->all();

        $user = User::findOrFail($id);

        unset($fields['email']);
        unset($fields['level']); // nope, haxxors

        if (isset($fields['gametag'])) {
            $fields['gametag'] = preg_replace('/([A-Za-z0-9]*)-([0-9]{4})/', '${1}#${2}', $fields['gametag']);
        }

        $validator = $this->validator($fields);
        if ($validator->fails())
            return redirect()->route('editProfile', ['id' => $id])->withErrors($validator)->withInput();

        if ($request->hasFile('picture')) {
            $picture = $request->file('picture');
            if (!$picture->isValid())
                return redirect()->route('editProfile', ['id' => $id])->withErrors($validator)->withInput();

            $picture->move(public_path('images/profile'), $user['name']);
            $fields['picture'] = url('/images/profile', $user['name']);
        }

        $user->update($fields);
        return redirect()->route('showProfile', ['id' => $id]);
    }

    private function getLastTenGames($id)
    {
        $games = Game::where('p1', '=', $id)
                ->orWhere('p2', '=', $id)
                ->orWhere('p3', '=', $id)
                ->orWhere('p4', '=', $id)
                ->orWhere('p5', '=', $id)
                ->orWhere('p6', '=', $id)
                ->orderBy('id', 'desc')
                ->take(10)
                ->get();
        foreach ($games as $game)
        {
            array_push($game->players, User::findOrFail($game->p1));
            array_push($game->players, User::findOrFail($game->p2));
            array_push($game->players, User::findOrFail($game->p3));
            array_push($game->players, User::findOrFail($game->p4));
            array_push($game->players, User::findOrFail($game->p5));
            array_push($game->players, User::findOrFail($game->p6));
        }
        return $games;
    }
}
