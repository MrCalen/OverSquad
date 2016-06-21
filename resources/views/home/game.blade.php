@extends('templates/basic_nav')

@section('css')
    @parent
@endsection

@section('body')
    @parent
    <div ng-app="OverSquad" ng-controller="OverSquadController">
        <div class="row theme">
            <img src="http://samherbert.net/svg-loaders/svg-loaders/rings.svg">
            <i class="white">Searching for <b ng-bind="6 - players.length"></b> other friends</i>
        </div>
        <div class="row">
            <div class="col-md-7">
            </div>
            <div class="col-md-5">
                <div>
                    <p></p>
                    <h4>Currently in game</h4>
                    <ul>
                        <li ng-repeat="player in players" ng-bind="player.user.name"></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    @parent
    <script>
        var token = '{{ $token }}';
    </script>
    <script src="{{ URL::asset('js/game.js') }}"></script>
@endsection
