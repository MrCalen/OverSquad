@extends('templates/basic_nav')

@section('css')
    @parent
@endsection

@section('body')
    @parent
    <div ng-app="OverSquad" ng-controller="OverSquadController">
        <div class="row theme">
            <div ng-if="!roomStatus">
                <img src="http://samherbert.net/svg-loaders/svg-loaders/rings.svg">
                <i class="white">Searching for <b ng-bind="6 - players.length"></b> other friends</i>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-7">
                <ul>
                    <li ng-repeat="message in messages track by $index" ng-bind="message"></li>
                </ul>
                <form id="msg" ng-submit="newMessage(currentMessage); currentMessage = ''">
                    <input type="text" ng-model="currentMessage">
                </form>
            </div>
            <div class="col-xs-5">
                <div>
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
