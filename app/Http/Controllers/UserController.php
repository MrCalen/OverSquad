<?php

namespace App\Http\Controllers;

use App\Models\Game;
use App\User;
use Auth;
use Illuminate\Http\Request;
use Log;
use Session;
use Validator;

class UserController extends Controller
{
    /**
     * Get a validator for an incoming profile edition request.
     *
     * @param  array $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return validator()->make($data, [
            'name' => 'required|max:255',
            'password' => 'min:6|confirmed',
            'gametag' => array ('Regex:/([A-Za-z]*)#([0-9]{4})/'),
        ]);
    }

    /**
     * Show the profile for the given user.
     *
     * @param  int $id
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
     * @param  int $id
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
     * @param  int $id
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
        $gametagModified = true;
        if ($fields['gametag'] == $user['gametag']) {
            $gametagModified = false;
        }

        $validator = $this->validator($fields);
        if ($validator->fails()) {
            return redirect()->route('showProfile', ['id' => $id])->withErrors($validator)->withInput();
        }

        $newImage = false;
        if ($request->hasFile('picture')) {
            $newImage = true;
            $picture = $request->file('picture');
            if (!$picture->isValid()) {
                return redirect()->route('showProfile', ['id' => $id])->withErrors($validator)->withInput();
            }

            $randStr = substr(str_shuffle(str_repeat("0123456789abcdefghijklmnopqrstuvwxyz", 8)), 0, 8);
            $randStr .= md5($user->mail);
            $picture->move(public_path('images/profile'), 'img_' . $randStr);
            $fields['picture'] = url('/images/profile', 'img_' . $randStr);
        }

        if ($newImage) {
            $oldImageName = explode('/', $user['picture']);
            if ($oldImageName != 'default_profile.jpg') {
                $oldImageName = $oldImageName[count($oldImageName) - 1];
                $oldImagePath = public_path('images/profile/' . $oldImageName);
                if (file_exists($oldImagePath)) {
                    unlink($oldImagePath);
                }
            }
        }

        $user->update($fields);

        if ($gametagModified) {
            $user->refreshPlayerLevelAndHeroes();
        }

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

        foreach ($games as $game) {
            $game->players[] = User::find($game->p1);
            $game->players[] = User::find($game->p2);
            $game->players[] = User::find($game->p3);
            $game->players[] = User::find($game->p4);
            $game->players[] = User::find($game->p5);
            $game->players[] = User::find($game->p6);
        }
        return $games;
    }
}
