@extends('templates/basic_login_layout')

@section('css')
    @parent
    <link rel="stylesheet" href="{{ URL::asset('css/login.css') }}"/>
    <link rel="stylesheet" href="{{ URL::asset('css/findplayerLoader.css') }}"/>
@endsection

@section('body')
    <div class="container">
        <div class="overwatch-title">OverSquad</div>
        <div class="row">
            <div class="col-md-6" style="margin-top : 60px;">

                <div class="panel panel-login">
                    <div class="panel-heading">
                        <div class="row">
                            <div class="col-xs-6">
                                <a href="#" class="active" id="login-form-link">Login</a></div>
                            <div class="col-xs-6">
                                <a href="#" id="register-form-link">Register</a>
                            </div>
                        </div>
                        <hr>
                    </div>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-lg-12">

                                <form id="login-form" action="{{ url('/login') }}" method="POST" role="form"
                                      style="display: block;">
                                    {{ csrf_field() }}
                                    <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                                        <input id="email" type="email" required class="form-control" name="email"
                                               placeholder="Email" value="{{ old('email') }}" tabindex="1">
                                        @if ($errors->has('email'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('email') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                    <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                                        <input type="password" name="password" required id="password" tabindex="2"
                                               pattern="(.{6,})" title="At least 6 characters"
                                               class="form-control" placeholder="Password">
                                        @if ($errors->has('password'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('password') }}</strong>
                                            </span>
                                        @endif
                                    </div>

                                    <div class="form-group">
                                        <div class="col-sm-6 col-sm-offset-3">
                                            <input type="submit" name="login-submit" required id="login-submit"
                                                   tabindex="3" class="form-control btn btn-login" value="Log In">
                                        </div>
                                    </div>

                                </form>

                                <form id="register-form" action="{{ url('/register') }}" method="POST" role="form"
                                      style="display: none;">
                                    {{ csrf_field() }}

                                    <div class="form-group{{ $errors->has('name-register') ? ' has-error' : '' }}">
                                        <input type="text" name="name-register" required id="name" tabindex="1"
                                               class="form-control" placeholder="Username" value="{{ old('name') }}">
                                        @if ($errors->has('name-register'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('name-register') }}</strong>
                                            </span>
                                        @endif
                                    </div>

                                    <div class="form-group{{ $errors->has('gametag') ? ' has-error' : '' }}">
                                        <input type="text" name="gametag" required id="gametag" tabindex="1"
                                               class="form-control" placeholder="Battletag" value="{{ old('gametag') }}"
                                               pattern="([A-Za-z0-9]*)#([0-9]{4})" title="For example: UserName#1234">
                                        @if ($errors->has('gametag'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('gametag') }}</strong>
                                            </span>
                                        @endif
                                    </div>

                                    <div class="form-group">
                                        <input type="email" name="email" required id="email" tabindex="1"
                                               class="form-control" placeholder="Email Address"
                                               value="{{ old('email') }}">
                                    </div>

                                    <div class="form-group{{ $errors->has('password-register') ? ' has-error' : '' }}">
                                        <input type="password" name="password-register" required id="password"
                                               pattern="(.{6,})" title="At least 6 characters"
                                               tabindex="2" class="form-control" placeholder="Password">
                                        @if ($errors->has('password-register'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('password-register') }}</strong>
                                            </span>
                                        @endif
                                    </div>

                                    <div class="form-group{{ $errors->has('password-register_confirmation') ? ' has-error' : '' }}">
                                        <input type="password" name="password-register_confirmation" required
                                               id="password-register_confirmation" tabindex="2" class="form-control"
                                               pattern="(.{6,})" title="At least 6 characters"
                                               placeholder="Confirm Password">
                                        @if ($errors->has('password-register_confirmation'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('password-register_confirmation') }}</strong>
                                            </span>
                                        @endif
                                    </div>

                                    <div class="form-group">
                                        <div class="col-sm-6 col-sm-offset-3">
                                          <div class="cssload-loader col-md-12 text-center col-sm-offset-6" style="visibility: hidden; margin-top:25px; margin-left:120px" id="loadingRegisterButton">Creation...</div>
                                            <input type="submit" name="register-submit" id="register-submit"
                                                   tabindex="4" class="form-control btn btn-signup"
                                                   value="Register Now">
                                        </div>
                                    </div>
                                </form>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    @parent
    <script>
        $(function () {

            $('#login-form-link').click(function (e) {
                $("#login-form").delay(100).fadeIn(100);
                $("#register-form").fadeOut(100);
                $('#register-form-link').removeClass('active');
                $(this).addClass('active');
                e.preventDefault();
            });

            $('#register-form-link').click(function (e) {
                $("#register-form").delay(100).fadeIn(100);
                $("#login-form").fadeOut(100);
                $('#login-form-link').removeClass('active');
                $(this).addClass('active');
                e.preventDefault();
            });

            $('#register-submit').submit(function() {
              $('#loadingRegisterButton').css('visibility', 'visible');
              $('#register-submit').css('visibility', 'hidden');
              return true;
            });

        });
    </script>
@endsection
