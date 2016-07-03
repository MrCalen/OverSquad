@extends('templates/basic_nav')

@section('css')
    @parent
    <link rel="stylesheet" href="{{ URL::asset('css/profile.css') }}"/>
@endsection

@section('body')
    @parent
    <div class="panel panel-default" id="profil-panel">
        <div class="panel-heading">
            <div class="panel-title">

                <strong>{{ $user->name }}</strong>'s profile

                @if($user['id'] == Auth::user()->id)
                <a class="pull-right" href="{{ URL::route('editProfile', ['id' => $user['id'] ]) }}">
                    <div class="glyphicon glyphicon-edit" id="profil-edit-icon"></div>
                </a>
                <div class="clearfix"></div>
                @endif

            </div>
        </div>
        <div class="panel-body">

            <div class="media">
                <div class="media-left media-middle">
                    <img class="media-object" width="64" height="64" src="{{ $user['picture'] }}" alt="{{ $user['name'] }}" />
                </div>
                <div class="media-body">

                    <strong>Name</strong>: {{ $user['name'] }}<br />
                    <strong>Tag</strong>: {{ $user['gametag'] }}<br />
                    <strong>Level</strong>: {{ $user['level'] }}<br />

                </div>
            </div>

        </div>
    </div>

    @if($user['id'] == Auth::user()->id)
        @if(count($games) !== 0)
            <div class="overwatch-title text-center" style="font-size: 60px; color: white;">Last games</div>
        @endif
        @forelse($games as $game)
            <div class="container-fluid game panel panel-default">
                <div class="row">
                @foreach($game->players as $player)
                    <div class="col-md-2 text-center">
                        <img class="img img-responsive" src="{{ $player->picture }}"/>
                    </div>
                @endforeach
                </div>
                <br>
                <div class="row">
                    @foreach($game->players as $player)
                        <div class="col-md-2 text-center">
                            @if($user['id'] === $player->id)
                                <a href="{{ URL::route('showProfile', ['id' => $player->id ]) }}" class="btn btn-primary">
                                    {{ $player->gametag }}
                                </a>
                            @else
                                <a href="{{ URL::route('showProfile', ['id' => $player->id ]) }}" class="btn btn-warning">
                                    {{ $player->gametag }}
                                </a>
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>
            <br>
        @empty
            <div class="overwatch-title text-center" style="font-size: 60px; color: white;">No games found</div>
        @endforelse
        <div class="row">
    @endif
@endsection
