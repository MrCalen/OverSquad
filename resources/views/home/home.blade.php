@extends('basic_layout')

@section('body')
    <h3>Welcome to OverSquad</h3>
@endsection


@section('scripts')
    <script>

        var ws = new WebSocket("ws://oversquad.mr-calen.eu/ws");
        ws.onopen = function () {
            ws.send("coucou les copains");
        };

    </script>
@endsection
