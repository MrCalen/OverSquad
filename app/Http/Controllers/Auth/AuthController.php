<?php

namespace App\Http\Controllers\Auth;

use App\User;
use Validator;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;

class AuthController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Registration & Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users, as well as the
    | authentication of existing users. By default, this controller uses
    | a simple trait to add these behaviors. Why don't you explore it?
    |
    */

    use AuthenticatesAndRegistersUsers, ThrottlesLogins;

    /**
     * Where to redirect users after login / registration.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new authentication controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware($this->guestMiddleware(), ['except' => 'logout']);
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name-register' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users',
            'password-register' => 'required|min:6|confirmed',
            'gametag' => array('Regex:/([A-Za-z]*)#([0-9]{4})/'),
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name-register'],
            'email' => $data['email'],
            'password' => bcrypt($data['password-register']),
            'gametag' => $data['gametag'],
            'level' => User::getLevelFromGametag($data['gametag']),
            'picture' => url('images/default_profile.jpg'),
            'hero1' => User::getHeroWithRankFromGametag(0, $data['gametag']),
            'hero2' => User::getHeroWithRankFromGametag(1, $data['gametag']),
            'hero3' => User::getHeroWithRankFromGametag(2, $data['gametag']),
        ]);
    }
}
