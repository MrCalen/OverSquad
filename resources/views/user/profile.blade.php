@extends('templates/basic_nav')

@section('body')
    @parent
    <h1><?php echo $user['name'] ?>'s profile</h1>

    @if($user['id'] == Auth::user()->id)
    <span class="pull-right">
        <a href="{{ URL::route('editProfile', ['id' => $user['id'] ]) }}" class="btn btn-warning">Edit</a>
    </span>
    <div class="clearfix"></div>
    @endif

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
@endsection
