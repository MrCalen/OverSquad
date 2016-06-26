@extends('templates/basic_nav')

@section('body')
    @parent
    <h1><?php echo $user['name'] ?>'s profile</h1>
@endsection
