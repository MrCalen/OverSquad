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
        <div class="container-fluid row"
             style="border: 3px solid rgba(35, 34, 32, 0.99); margin: 10px; border-radius: 5px; height: 90%">
            <div class="col-xs-8">
                <ul>
                    <li ng-repeat="message in messages track by $index">
                        <a href="@{{ message.author }}">
                            @{{ message.author_name }}
                        </a>
                        @{{ message.content }}
                    </li>
                </ul>
                <form id="msg" ng-submit="newMessage(currentMessage); currentMessage = ''">
                    <div class="container-fluid">
                        <div class="col-xs-10">
                            <input class="form-control" type="text" ng-model="currentMessage">
                        </div>
                        <div class="col-xs-2">
                            <button class="btn btn-primary">Envoyer</button>
                        </div>
                    </div>
                </form>
            </div>
            <div class="col-xs-4" style="border-left: 1px solid black; height: 100%">
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
        var websocketUrl = '{{ env('WS_URL') }}';
    </script>
    <script src="{{ URL::asset('js/game.js') }}"></script>
@endsection
