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
