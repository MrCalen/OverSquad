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

            <dl class="dl-horizontal">
                <dt>Name</dt>
                <dd><?php echo $user['name'] ?></dd>
            </dl>
            <dl class="dl-horizontal">
                <dt>Tag</dt>
                <dd><?php echo $user['gametag'] ?></dd>
            </dl>
            <dl class="dl-horizontal">
                <dt>Level</dt>
                <dd><?php echo $user['level'] ?></dd>
            </dl>

        </div>
    </div>
@endsection
