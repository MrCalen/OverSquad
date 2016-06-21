<?php


namespace App\Http\Controllers;

use App\User;
use App\Ws\Connection;
use Auth;
use Illuminate\Support\Facades\Redirect;
use Session;

class HomeController extends Controller
{
    public function index()
    {
//        $playerManager = new PlayersManager();
//        $id = 0;
//        $leaver = $this->randomPlayer($id++);
//        $playerManager->userConnected($leaver, [1]);
//        $playerManager->userConnected($this->randomPlayer($id++), [2]);
//        $playerManager->userConnected($this->randomPlayer($id++), [2]);
//        $playerManager->userConnected($this->randomPlayer($id++), [1]);
//        $playerManager->userConnected($this->randomPlayer($id++), [4]);
//        $playerManager->userConnected($this->randomPlayer($id++), [3]);
//        $playerManager->userConnected($this->randomPlayer($id++), [1]);
//
//        $playerManager->userLeave($leaver);
//        $playerManager->userConnected($leaver, [1]);

        return view('home/home');
    }

    public function home()
    {
        if (Auth::check()) {
            return Redirect::to('/home');
        } else {
            return Redirect::to('/login');
        }
    }

    private function randomPlayer($id)
    {
        $user = new User();
        $user->id = $id;

        $connection = new Connection(null);
        $connection->setUser($user);
        return $connection;
    }

    public function logout()
    {
        Auth::logout();
        Session::flush();
        return redirect('/');
    }
}
