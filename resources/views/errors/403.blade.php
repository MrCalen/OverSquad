@extends('templates/basic_nav')

@section('body')
    <h1 class="overwatch-title text-center">Error</h1>
    <div class="container">
        <div class="col-md-8 col-md-offset-1">
            <h2 style="font-size: 40px; font-family: serif; color: #1F3D44">You cannot access this resource because {{ $error }}</h2>
        </div>
    </div>
@endsection