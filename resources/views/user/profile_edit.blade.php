@extends('templates/basic_nav')

@section('css')
    @parent
    <style>
        #profil-panel {
            margin-top: 15px;
        }
    </style>
@endsection

@section('body')
    @parent

    <div class="panel panel-default" id="profil-panel">
        <div class="panel-heading">
            <div class="panel-title">Edit your profil</div>
        </div>
        <div class="panel-body">
            <form class="form-horizontal col-md-9" method="POST">
                {{ csrf_field() }}

                <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                    <label for="name" class="col-md-3 control-label">Name</label>

                    <div class="col-md-9">
                        <input id="name" type="text" class="form-control" name="name" value="{{ $user['name'] }}">

                        @if ($errors->has('name'))
                            <span class="help-block">
                                <strong>{{ $errors->first('name') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>

                <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                    <label class="col-sm-3 control-label">Email</label>
                    <div class="col-sm-9">
                        <input type="email" class="form-control" disabled="disabled" name="email" id="email" placeholder="Email" value="{{ $user['email'] }}" />
                        @if ($errors->has('email'))
                            <span class="help-block">
                                <strong>{{ $errors->first('email') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>

                <div class="form-group{{ $errors->has('level') ? ' has-error' : '' }}">
                    <label class="col-sm-3 control-label">Level</label>
                    <div class="col-sm-9">
                        <input type="number" class="form-control" disabled="disabled" value="{{ $user['level'] }}" />
                        @if ($errors->has('level'))
                            <span class="help-block">
                                <strong>{{ $errors->first('level') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>

                <div class="form-group{{ $errors->has('gametag') ? ' has-error' : '' }}">
                    <label class="col-sm-3 control-label">GameTag</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" name="gametag" id="gametag" placeholder="GameTag" value="{{ $user['gametag'] }}" />
                        @if ($errors->has('gametag'))
                            <span class="help-block">
                                <strong>{{ $errors->first('gametag') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>

                <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                    <label class="col-sm-3 control-label">Password</label>
                    <div class="col-sm-9">
                        <input type="password" class="form-control" name="password" id="password" placeholder="Password" value="" />
                        @if ($errors->has('password'))
                            <span class="help-block">
                                <strong>{{ $errors->first('password') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>

                <div class="form-group{{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
                    <label class="col-sm-3 control-label">Password confirmation</label>
                    <div class="col-sm-9">
                        <input type="password" class="form-control" name="password_confirmation" id="password_confirmation" placeholder="Password" value="" />
                        @if ($errors->has('password_confirmation'))
                            <span class="help-block">
                                <strong>{{ $errors->first('password_confirmation') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>

                <input type="submit" class="btn btn-primary pull-right" value="Save" />
                <div class="clearfix"></div>

            </form>
        </div>
    </div>

@endsection
