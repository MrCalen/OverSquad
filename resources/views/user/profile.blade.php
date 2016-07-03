@extends('templates/basic_nav')

@section('css')
    @parent
    <link rel="stylesheet" href="{{ URL::asset('css/profile.css') }}"/>
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

    @if($user['id'] == Auth::user()->id)
        @if(count($games) !== 0)
            <div class="overwatch-title text-center" style="font-size: 60px; color: white;">Last games</div>
        @endif
        @forelse($games as $game)
            <div class="container-fluid game panel panel-default">
                <div class="row">
                @foreach($game->players as $player)
                    <div class="col-md-2 text-center">
                        <img class="img img-responsive" src="{{ $player->picture }}"/>
                    </div>
                @endforeach
                </div>
                <br>
                <div class="row">
                    @foreach($game->players as $player)
                        <div class="col-md-2 text-center">
                            @if($user['id'] === $player->id)
                                <a href="{{ URL::route('showProfile', ['id' => $player->id ]) }}" class="btn btn-primary">
                                    {{ $player->gametag }}
                                </a>
                            @else
                                <a href="{{ URL::route('showProfile', ['id' => $player->id ]) }}" class="btn btn-warning">
                                    {{ $player->gametag }}
                                </a>
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>
            <br>
        @empty
            <div class="overwatch-title text-center" style="font-size: 60px; color: white;">No games found</div>
        @endforelse
        <div class="row">
    @endif

    <row>

      <hr class="col-md-8">
      <div class="text-center overwatch-title" style="width:66%; margin-top:0px;">
        Most Played Heroes
      </div>

      <div class="col-md-3">
        <svg id="graph" width="150px" height="150px">
          <defs>
            <pattern id="image1" x="0%" y="0%" height="100%" width="100%"
                     viewBox="0 0 190 190">
              <image x="20px" y="20px" width="150px" height="150px" xlink:href="{{$user->getHeroIconWithRank(1)}}"></image>
            </pattern>
          </defs>
          <circle id="sd" class="medium" cx="50%" cy="50%" r="45%" fill="rgba(31, 60, 66, 0.9)" stroke="#1F3D44" stroke-width="2.5%" />
          <circle id="sd" class="medium" cx="50%" cy="50%" r="45%" fill="url(#image1)" stroke="#FA961E" stroke-width="1%" />
        </svg>
        <div class="text-center overwatch-hero" style="width:150px; margin-top:0px; margin-bottom:0px;">
          <?php echo $user->getHeroNameWithRank(1) ?>
        </div>
        <div class="text-center overwatch-time" style="width:150px; margin-top:0px;">
          <?php echo $user->getHeroTimeWithRank(1) ?>
        </div>
      </div>

      <div class="col-md-3">
        <svg id="graph" width="150px" height="150px">
          <defs>
            <pattern id="image2" x="0%" y="0%" height="100%" width="100%"
                     viewBox="0 0 190 190">
              <image x="20px" y="20px" width="150px" height="150px" xlink:href="{{$user->getHeroIconWithRank(2)}}"></image>
            </pattern>
          </defs>
          <circle id="sd" class="medium" cx="50%" cy="50%" r="45%" fill="rgba(31, 60, 66, 0.9)" stroke="#1F3D44" stroke-width="2.5%" />
          <circle id="sd" class="medium" cx="50%" cy="50%" r="45%" fill="url(#image2)" stroke="#FA961E" stroke-width="1%" />
        </svg>
        <div class="text-center overwatch-hero" style="width:150px; margin-top:0px; margin-bottom:0px;">
          <?php echo $user->getHeroNameWithRank(2) ?>
        </div>
        <div class="text-center overwatch-time" style="width:150px; margin-top:0px;">
          <?php echo $user->getHeroTimeWithRank(2) ?>
        </div>
      </div>

      <div class="col-md-3">
        <svg id="graph" width="150px" height="150px">
          <defs>
            <pattern id="image3" x="0%" y="0%" height="100%" width="100%"
                     viewBox="0 0 190 190">
              <image x="20px" y="20px" width="150px" height="150px" xlink:href="{{$user->getHeroIconWithRank(3)}}"></image>
            </pattern>
          </defs>
          <circle id="sd" class="medium" cx="50%" cy="50%" r="45%" fill="rgba(31, 60, 66, 0.9)" stroke="#1F3D44" stroke-width="2.5%" />
          <circle id="sd" class="medium" cx="50%" cy="50%" r="45%" fill="url(#image3)" stroke="#FA961E" stroke-width="1%" />
        </svg>
        <div class="text-center overwatch-hero" style="width:150px; margin-top:0px; margin-bottom:0px;">
          <?php echo $user->getHeroNameWithRank(3) ?>
        </div>
        <div class="text-center overwatch-time" style="width:150px; margin-top:0px;">
          <?php echo $user->getHeroTimeWithRank(3) ?>
        </div>
      </div>

    </row>
@endsection
