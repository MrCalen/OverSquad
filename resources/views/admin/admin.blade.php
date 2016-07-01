@extends('templates/basic_nav')

@section('css')
    @parent
    <link rel="stylesheet" href="{{ URL::asset('css/admin.css') }}"/>
@endsection

@section('body')
    <div ng-app="OverSquad" ng-controller="OverSquadController"  style="color: #1F3D44" ng-cloak>
        <div class="container-fluid">
            <div class="row">
                <h3 class="text-center">Current Rooms</h3>
                <hr color="#1F3D44" class="real-hr"/>
            </div>
            <div class="col-md-3 col-md-offset-1" ng-repeat="room in rooms">
                <div style="width: 100%; background: #ffffff; border: 1px solid black; border-radius: 4px">
                    <div class="container-fluid">
                        <div class="row">
                            <h3 class="text-center">Room @{{ $index }}</h3>
                        </div>
                        <div class="row">
                            <ul>
                                <li style="font-size: 20px" ng-repeat="user in room">
                                    <i ng-bind="user.user.name"></i>
                                    <span style="font-size: 15px" ng-bind="roleToString(user.role)"></span>
                                </li>
                                <li style="font-size: 20px;" ng-repeat="i in emptyPlaces(room)">
                                    Empty
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        var token = '{{ $token }}';
        var websocketUrl = '{{ env('WS_URL') }}';
        var admin = true;
    </script>
    <script src="{{ URL::asset('js/admin.js') }}"></script>
@endsection