<?php


namespace App\Http\Controllers;

use App\Models\PlayersManager;

class HomeController extends Controller
{
    public function index()
    {
        $playerManager = new PlayersManager();

        $roles = [1, 2];
        $user = new \stdClass();

        $playerManager->userConnected($user, $roles);



        dd($playerManager);
//        return view('home/home');
    }

    private function randomPlayer()
    {
    }

}

