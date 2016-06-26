@extends('templates/basic_nav')

@section('body')
    @parent
    <h1><?php echo $user['name'] ?>'s profile <small>(edit.)</small></h1>

    <span class="pull-right">
        <a href="{{ URL::route('editProfile', ['id' => $user['id'] ]) }}" class="btn btn-warning">Edit</a>
    </span>
    <div class="clearfix"></div>

    <form class="form-horizontal col-md-9" method="POST">
        {{ csrf_field() }}
        <div class="form-group">
            <label class="col-sm-3 control-label">Name</label>
            <div class="col-sm-9">
                <input type="text" class="form-control" name="name" id="name" placeholder="Name" value="{{ $user['name'] }}" />
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-3 control-label">Gametag</label>
            <div class="col-sm-9">
                <input type="text" class="form-control" name="gametag" id="gametag" placeholder="Gametag" value="{{ $user['gametag'] }}" />
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-3 control-label">Level</label>
            <div class="col-sm-9">
                <input type="number" class="form-control" disabled="disabled" value="{{ $user['level'] }}" />
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-3 control-label">Email</label>
            <div class="col-sm-9">
                <input type="email" class="form-control" name="email" id="email" placeholder="Email" value="{{ $user['email'] }}" />
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-3 control-label">Password</label>
            <div class="col-sm-9">
                <input type="password" class="form-control" name="password" id="password" placeholder="Password" value="" />
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-3 control-label">Password confirmation</label>
            <div class="col-sm-9">
                <input type="password" class="form-control" name="password_confirmation" id="password_confirmation" placeholder="Password" value="" />
            </div>
        </div>
        <input type="submit" class="btn btn-primary pull-right" value="Save" />
        <div class="clearfix"></div>
    </form>

@endsection
