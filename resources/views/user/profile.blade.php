@extends('templates/basic_nav')

@section('css')
    @parent
    <style>
        #profil-panel {
            margin-top: 15px;
        }

        #profil-edit-icon {
            color: #666;
        }

        #profil-edit-icon:hover {
            color: #333;
        }
    </style>
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
@endsection
