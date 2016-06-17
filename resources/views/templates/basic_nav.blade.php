@extends('templates/basic_layout')


@section('css')
    @parent
    <link rel="stylesheet" href="{{ URL::asset('css/nav.css') }}" />
@endsection

@section('nav_content')
    <nav class="navbar navbar-default" role="navigation">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="#">Brand</a>
        </div>

        <div class="collapse navbar-collapse navbar-ex1-collapse">
            <ul class="nav navbar-nav">
                <li class="active"><a href="#">Link</a></li>
                <li><a href="{{ URL::to('/game') }}">Search Game</a></li>
            </ul>
        </div>
    </nav>

@endsection
