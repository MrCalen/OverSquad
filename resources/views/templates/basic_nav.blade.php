@extends('templates/basic_layout')


@section('css')
    @parent
    <link rel="stylesheet" href="{{ URL::asset('css/login.css') }}"/>
    <link rel="stylesheet" href="{{ URL::asset('css/nav.css') }}"/>
@endsection

@section('nav_content')
    <div class="container-fluid full-height">
        <div class="col-md-10 col-md-offset-1">
            <a href="{{ URL::to('/home') }}" style="text-decoration: none;">
                <div class="overwatch-title text-center" style="font-size: 60px; color: white;">OverSquad</div>
            </a>
        </div>
        <ul style="list-style-type: none" class="img-pad">
            <li>
                <img class="img img-responsive" src="{{ Auth::user()->picture }}"/>
            </li>
            <li class="text-center white">
                <h2>{{ Auth::user()->name }}</h2>
            </li>
            <li class="text-center white">
                <h4>"{{ Auth::user()->gametag }}"</h4>
            </li>
            <li class="text-center white">
                <h4>Level {{ Auth::user()->level }}</h4>
            </li>
            <li class="divider">
                <hr/>
            </li>
            <li>
                <a href="{{ URL::route('showProfile', ['id' => Auth::user()->id ]) }}" class="menu-item white"><i
                            class="fa fa-user fa-fw" aria-hidden="true"></i>Profile</a>
            </li>
            <li class="divider">
                <hr/>
            </li>
            <li>
                <a href="{{ URL::to('/game') }}" class="menu-item white"><i class="fa fa-trophy fa-fw"
                                                                            aria-hidden="true"></i>Search a Game</a>
            </li>
            <li class="divider">
                <hr/>
            </li>
            <li>
                <a href="{{ URL::to('/logout') }}" class="white menu-item"><i class="fa fa-sign-out fa-fw"
                                                                              aria-hidden="true"></i>Log out</a>
            </li>
            <li class="divider">
                <hr/>
            </li>
        </ul>
    </div>
@endsection
