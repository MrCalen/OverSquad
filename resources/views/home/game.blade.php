@extends('templates/basic_nav')

@section('css')
    @parent
    <link rel="stylesheet" href="{{ URL::asset('css/game.css') }}"/>
@endsection

@section('body')
    @parent
    <div ng-app="OverSquad" ng-controller="OverSquadController" ng-cloak>
        <div ng-show="step == 0">
            <h1 class="overwatch-title text-center">Select your role</h1>
            <hr color="#1F3D44" width="50%" class="real-hr"/>

            <div class="role-selection">
                <ul class="list-inline">
                    <li class="role text-center" ng-click="addRole(1)">
                        <svg viewBox="0 0 32 32" role="presentation" class="icon">
                            <title>Attack</title>
                            <svg viewBox="0 0 32 32" role="presentation" class="icon">
                                <title>Offense</title>
                                <g>
                                    <rect x="2.1" y="28.1" width="7.1" height="3.9"></rect>
                                    <path d="M9.1,7c0,0,0-0.5,0-0.7C8.6,1.5,5.6,0,5.6,0s-3,1.5-3.5,6.3c0,0.2,0,0.7,0,0.7v18.4h3.5h3.5V7z"></path>
                                </g>
                                <g>
                                    <rect x="12.5" y="28.1" width="7.1" height="3.9"></rect>
                                    <path d="M19.5,7c0,0,0-0.5,0-0.7C19,1.5,16,0,16,0s-3,1.5-3.5,6.3c0,0.2,0,0.7,0,0.7v18.4H16h3.5V7z"></path>
                                </g>
                                <g>
                                    <rect x="22.9" y="28.1" width="7.1" height="3.9"></rect>
                                    <path d="M29.9,7c0,0,0-0.5,0-0.7C29.4,1.5,26.4,0,26.4,0s-3,1.5-3.5,6.3c0,0.2,0,0.7,0,0.7v18.4h3.5h3.5V7z"></path>
                                </g>
                            </svg>
                        </svg>
                        <span class="overwatch-title futura">Attack</span>
                    </li>
                    <li class="role text-center" ng-click="addRole(2)">
                        <svg viewBox="0 0 32 32" role="presentation" class="icon">
                            <title>Tank</title>
                            <path d="M29,10.7c0,2.1,0,4.1,0,6.2c0,0.6-0.1,1.1-0.4,1.6c-2.9,5.3-6.8,9.7-11.8,13.2c-0.6,0.4-1,0.4-1.6,0c-4.9-3.4-8.8-7.8-11.7-13c-0.3-0.6-0.4-1.2-0.4-1.8c0-3.9,0.1-7.8,0-11.7C3,2.3,5.2,1.9,7.1,1.4C10.4,0.6,13.3,0,16.6,0c3.1,0,7.7,1.1,9.4,1.6c1.3,0.4,2.7,0.9,2.9,2.2C29,4.9,28.9,6,29,7.1C29,8.3,29,9.5,29,10.7C29,10.7,29,10.7,29,10.7z"></path>
                        </svg>
                        <span class="overwatch-title futura">Tank</span>
                    </li>
                    <li class="role text-center" ng-click="addRole(3)">
                        <span>
                            <svg viewBox="0 0 32 32" role="presentation" class="icon">
                                <title>Support</title>
                                <path fill-rule="evenodd"
                                      d="M29.3,10.2h-7.5V2.7c0-1.5-1.2-2.7-2.7-2.7h-6.3c-1.5,0-2.7,1.2-2.7,2.7v7.5H2.7c-1.5,0-2.7,1.2-2.7,2.7v6.3c0,1.5,1.2,2.7,2.7,2.7h7.5v7.5c0,1.5,1.2,2.7,2.7,2.7h6.3c1.5,0,2.7-1.2,2.7-2.7v-7.5h7.5c1.5,0,2.7-1.2,2.7-2.7v-6.3C32,11.4,30.8,10.2,29.3,10.2z"></path>
                            </svg>
                        </span>
                        <span class="overwatch-title futura">Support</span>
                    </li>
                    <li class="role text-center" ng-click="addRole(4)">
                        <svg viewBox="0 0 32 32" role="presentation" class="icon">
                            <title>Defense</title>
                            <path d="M16,10.8c-2,0-4,0-6.1,0c-1.7,0-3.1-1.4-3.1-3.1c0-2,0-3.9,0-5.9c0-1,0.8-1.8,1.7-1.8c0.3,0-0.1,0,0.2,0C10,0,9.9,1.3,9.9,1.6c0,0.7,0,0.3,0,1c0,0.3,0.1,0.4,0.4,0.4c0.7,0,1.5,0,2.2,0c0.2,0,0.4-0.2,0.4-0.4c0-0.4,0-0.8,0-1.2c0-0.8,0.7-1.4,1.4-1.4c1.4,0,2,0,3.4,0c1.1,0,1.4,1.2,1.3,1.5c0,0.7,0,0.4,0,1.1c0,0.3,0.1,0.5,0.5,0.5c0.7,0,1.4,0,2.1,0c0.4,0,0.5-0.1,0.5-0.5c0-0.7,0-0.7,0-1.4c0-0.3,0.1-1.2,1.3-1.2c0.4,0-0.1,0,0.4,0c0.8,0,1.4,0.7,1.4,1.5c0,2.1,0,4.3,0,6.4c0,1.5-1.4,2.8-2.9,2.8C20.2,10.8,18.1,10.8,16,10.8z"></path>
                            <path d="M28.2,27.4c0-1-0.6-1.6-1.6-1.6c-0.5,0-1.7-0.1-2.1-0.6c-1.3-1.6-1.8-3.2-2.1-5.2c-0.4-2.4-0.3-3.8-0.4-6.2c0-0.6,0-0.6-0.6-0.6c-3.7,0-7.3,0-11,0c-0.7,0-0.7,0-0.7,0.7c0,2.4,0,3.7-0.4,6.1c-0.3,1.9-0.8,3.8-2.2,5.3c-0.3,0.3-1.4,0.5-2,0.5c-1,0-1.6,0.6-1.6,1.6c0,0.9,0,1.8,0,2.8c0,1.2,0.6,1.8,1.8,1.8c3.5,0,7,0,10.4,0c3.5,0,7,0,10.5,0c1.1,0,1.7-0.6,1.7-1.7C28.2,29.3,28.3,28.4,28.2,27.4z"></path>
                        </svg>
                        <span class="overwatch-title futura">Defense</span>
                    </li>
                </ul>
            </div>
            <hr>
            <ul class="role-choices" choice-list="roles">
                <li ng-repeat="item in roles track by $index" ng-switch="item.value" class="role-choice">
                    <div ng-switch-when="1">
                        <span class="left remove-icon" ng-click="removeRole($index)"><i class="fa fa-remove fa-fw"></i></span>
                        <svg viewBox="0 0 32 32" role="presentation" class="icon">
                            <title>Attack</title>
                            <svg viewBox="0 0 32 32" role="presentation" class="icon">
                                <title>Offense</title>
                                <g>
                                    <rect x="2.1" y="28.1" width="7.1" height="3.9"></rect>
                                    <path d="M9.1,7c0,0,0-0.5,0-0.7C8.6,1.5,5.6,0,5.6,0s-3,1.5-3.5,6.3c0,0.2,0,0.7,0,0.7v18.4h3.5h3.5V7z"></path>
                                </g>
                                <g>
                                    <rect x="12.5" y="28.1" width="7.1" height="3.9"></rect>
                                    <path d="M19.5,7c0,0,0-0.5,0-0.7C19,1.5,16,0,16,0s-3,1.5-3.5,6.3c0,0.2,0,0.7,0,0.7v18.4H16h3.5V7z"></path>
                                </g>
                                <g>
                                    <rect x="22.9" y="28.1" width="7.1" height="3.9"></rect>
                                    <path d="M29.9,7c0,0,0-0.5,0-0.7C29.4,1.5,26.4,0,26.4,0s-3,1.5-3.5,6.3c0,0.2,0,0.7,0,0.7v18.4h3.5h3.5V7z"></path>
                                </g>
                            </svg>
                        </svg>
                        <span class="overwatch-title futura">Attack</span>
                    </div>
                    <div ng-switch-when="2">
                        <span class="left remove-icon" ng-click="removeRole($index)"><i class="fa fa-remove fa-fw"></i></span>
                        <svg viewBox="0 0 32 32" role="presentation" class="icon">
                            <title>Tank</title>
                            <path d="M29,10.7c0,2.1,0,4.1,0,6.2c0,0.6-0.1,1.1-0.4,1.6c-2.9,5.3-6.8,9.7-11.8,13.2c-0.6,0.4-1,0.4-1.6,0c-4.9-3.4-8.8-7.8-11.7-13c-0.3-0.6-0.4-1.2-0.4-1.8c0-3.9,0.1-7.8,0-11.7C3,2.3,5.2,1.9,7.1,1.4C10.4,0.6,13.3,0,16.6,0c3.1,0,7.7,1.1,9.4,1.6c1.3,0.4,2.7,0.9,2.9,2.2C29,4.9,28.9,6,29,7.1C29,8.3,29,9.5,29,10.7C29,10.7,29,10.7,29,10.7z"></path>
                        </svg>
                        <span class="overwatch-title futura">Tank</span>
                    </div>
                    <div ng-switch-when="3">
                        <span class="left remove-icon" ng-click="removeRole($index)"><i class="fa fa-remove fa-fw"></i></span>
                        <svg viewBox="0 0 32 32" role="presentation" class="icon">
                            <title>Support</title>
                            <path fill-rule="evenodd"
                                  d="M29.3,10.2h-7.5V2.7c0-1.5-1.2-2.7-2.7-2.7h-6.3c-1.5,0-2.7,1.2-2.7,2.7v7.5H2.7c-1.5,0-2.7,1.2-2.7,2.7v6.3c0,1.5,1.2,2.7,2.7,2.7h7.5v7.5c0,1.5,1.2,2.7,2.7,2.7h6.3c1.5,0,2.7-1.2,2.7-2.7v-7.5h7.5c1.5,0,2.7-1.2,2.7-2.7v-6.3C32,11.4,30.8,10.2,29.3,10.2z"></path>
                        </svg>
                        <span class="overwatch-title futura">Support</span>
                    </div>
                    <div ng-switch-when="4">
                        <span class="left remove-icon" ng-click="removeRole($index)"><i class="fa fa-remove fa-fw"></i></span>
                        <svg viewBox="0 0 32 32" role="presentation" class="icon">
                            <title>Defense</title>
                            <path d="M16,10.8c-2,0-4,0-6.1,0c-1.7,0-3.1-1.4-3.1-3.1c0-2,0-3.9,0-5.9c0-1,0.8-1.8,1.7-1.8c0.3,0-0.1,0,0.2,0C10,0,9.9,1.3,9.9,1.6c0,0.7,0,0.3,0,1c0,0.3,0.1,0.4,0.4,0.4c0.7,0,1.5,0,2.2,0c0.2,0,0.4-0.2,0.4-0.4c0-0.4,0-0.8,0-1.2c0-0.8,0.7-1.4,1.4-1.4c1.4,0,2,0,3.4,0c1.1,0,1.4,1.2,1.3,1.5c0,0.7,0,0.4,0,1.1c0,0.3,0.1,0.5,0.5,0.5c0.7,0,1.4,0,2.1,0c0.4,0,0.5-0.1,0.5-0.5c0-0.7,0-0.7,0-1.4c0-0.3,0.1-1.2,1.3-1.2c0.4,0-0.1,0,0.4,0c0.8,0,1.4,0.7,1.4,1.5c0,2.1,0,4.3,0,6.4c0,1.5-1.4,2.8-2.9,2.8C20.2,10.8,18.1,10.8,16,10.8z"></path>
                            <path d="M28.2,27.4c0-1-0.6-1.6-1.6-1.6c-0.5,0-1.7-0.1-2.1-0.6c-1.3-1.6-1.8-3.2-2.1-5.2c-0.4-2.4-0.3-3.8-0.4-6.2c0-0.6,0-0.6-0.6-0.6c-3.7,0-7.3,0-11,0c-0.7,0-0.7,0-0.7,0.7c0,2.4,0,3.7-0.4,6.1c-0.3,1.9-0.8,3.8-2.2,5.3c-0.3,0.3-1.4,0.5-2,0.5c-1,0-1.6,0.6-1.6,1.6c0,0.9,0,1.8,0,2.8c0,1.2,0.6,1.8,1.8,1.8c3.5,0,7,0,10.4,0c3.5,0,7,0,10.5,0c1.1,0,1.7-0.6,1.7-1.7C28.2,29.3,28.3,28.4,28.2,27.4z"></path>
                        </svg>
                        <span class="overwatch-title futura">Defense</span>
                    </div>
                </li>
            </ul>
            <ul class="role-choices">
                <li ng-show="roles.length === 3" class="role-choice li-oversquad validate-button" ng-click="start()">
                    <div class="futura padded">Valider</div>
                </li>
            </ul>
        </div>
        <div ng-show="step == 1" class="animate-if">
            <div class="row theme">
                <div ng-if="!roomStatus">
                    <img src="http://samherbert.net/svg-loaders/svg-loaders/rings.svg">
                    <i class="white">Searching for <b ng-bind="6 - players.length"></b> other friends</i>
                </div>
            </div>
            <div class="container-fluid row chat-box">
                <div class="col-xs-8">
                    <ul class="chat-list">
                        <li ng-repeat="message in messages track by $index">
                            <i>@{{ message.author_name }}</i>
                            @{{ message.content }}
                        </li>
                    </ul>
                    <form id="msg" ng-submit="newMessage(currentMessage); currentMessage = ''"
                          class="create-message">
                        <div class="container-fluid">
                            <div class="col-xs-10">
                                <input class="form-control input-chat" type="text" ng-model="currentMessage">
                            </div>
                            <div class="col-xs-2">
                                <button class="btn btn-primary btn-oversquad">Envoyer</button>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="col-xs-4 user-list">
                    <div>
                        <h4>Currently in game</h4>
                        <ul class="list-group">
                            <li class="user-hover list-group-item list-group-item-warning" ng-repeat="player in players" id="@{{ player.user.id }}">
                                <i>@{{ player.user.name }}</i>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    @parent
    <script src="https://cdnjs.cloudflare.com/ajax/libs/angular-ui-bootstrap/1.3.3/ui-bootstrap.min.js"></script>
    <script src="https://code.jquery.com/ui/1.10.4/jquery-ui.min.js"
            integrity="sha256-oTyWrNiP6Qftu4vs2g0RPCKr3g1a6QTlITNgoebxRc4=" crossorigin="anonymous"></script>
    <script>
        var token = '{{ $token }}';
        var websocketUrl = '{{ env('WS_URL') }}';
    </script>
    <script src="{{ URL::asset('js/game.js') }}"></script>
@endsection
