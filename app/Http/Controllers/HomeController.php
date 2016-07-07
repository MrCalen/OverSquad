<?php


namespace App\Http\Controllers;

use App\User;
use App\Ws\Connection;
use Auth;
use Illuminate\Support\Facades\Redirect;
use Session;

/**
 * Class HomeController
 * @package App\Http\Controllers
 * HomeController handling logout and home page
 */
class HomeController extends Controller
{
    public function index()
    {
        return Redirect::to('/login');
    }

    public function home()
    {
        if (Auth::check()) {
            return Redirect::to('/user/' . Auth::user()->id);
        } else {
            return Redirect::to('/login');
        }
    }

    public function logout()
    {
        Auth::logout();
        Session::flush();
        return redirect('/');
    }
}
