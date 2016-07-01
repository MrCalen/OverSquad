<html>
<head>
    <title>OverSquad</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css"/>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.3/css/font-awesome.min.css"/>
    @yield('css')
</head>
<body class="full-height">
<div class="col-md-3 col-sm-4 no-pad" id="navbar">
    @yield('nav_content')
</div>
<div class="col-md-9 col-sm-8 content" id="body"
     style="background-image: url('http://www.hdwallpaper.nu/wp-content/uploads/2016/05/overwatch_wallpaper_hd_by_mrnocilla-d9q4d3z.jpg')">
    @yield('body')
</div>
<script src="https://code.jquery.com/jquery-2.2.4.min.js"
        integrity="sha256-BbhdlvQf/xTY9gja0Dq3HiwQF8LaCRTXxZKRutelT44=" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.5.6/angular.min.js"></script>
<script>
    $("#body").height($("#navbar").height() * 1.2);
</script>
@yield('scripts')
</body>
</html>
