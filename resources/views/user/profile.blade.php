@extends('templates/basic_nav')

@section('css')
    @parent
    <link rel="stylesheet" href="{{ URL::asset('css/profile.css') }}"/>
    <link rel="stylesheet" href="{{ URL::asset('css/findplayerLoader.css') }}"/>
@endsection

@section('body')
    @parent
    <div class="text-center overwatch-title col-md-8">
      {{ $user->name }}'s profile
    </div>

    <form class="form-inline" action="{{ URL::route('editProfile', ['id' => Auth::user()->id ]) }}" method="POST" enctype="multipart/form-data" id="edit_info">
      {{ csrf_field() }}
      <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }} container" style="padding-bottom: 5px; width: 100%;">
        <div class="profile-edit-text col-sm-3" for="name" style="padding-right: 20px; text-align: right;" >Name</div>
        <input type="text" class="form-control col-sm-9" name="name" id="name" value="{{ $user['name'] }}" @if($user['id'] !== Auth::user()->id) disabled="disabled" @endif>
          @if ($errors->has('name'))
              <span class="help-block">
                  <strong>{{ $errors->first('name') }}</strong>
              </span>
          @endif
      </div>

      <div class="form-group container"style="padding-bottom: 5px; width: 100%;">
        <div class="profile-edit-text col-sm-3" for="gametag" style="padding-right: 20px; text-align: right;" >BattleTag</div>
        <input type="text" class="form-control col-sm-9" name="gametag" id="gametag" value="{{ $user['gametag'] }}" @if($user['id'] !== Auth::user()->id) disabled="disabled" @endif pattern="([A-Za-z0-9]*)#([0-9]{4})" title="For example: UserName#1234">
          @if ($errors->has('gametag'))
              <span class="help-block">
                  <strong>{{ $errors->first('gametag') }}</strong>
              </span>
          @endif
      </div>

      <div class="form-group container"style="padding-bottom: 5px; width: 100%;">
        <div class="profile-edit-text col-sm-3" for="email" style="padding-right: 20px; text-align: right;" >Email</div>
        <input type="text" class="form-control col-sm-9" name="email" id="email" value="{{ $user['email'] }}" disabled="disabled">
        @if ($errors->has('email'))
            <span class="help-block">
                <strong>{{ $errors->first('email') }}</strong>
            </span>
        @endif
      </div>

      <div class="form-group container"style="padding-bottom: 5px; width: 100%;">
        <div class="profile-edit-text col-sm-3" for="level" style="padding-right: 20px; text-align: right;" >Level</div>
        <input type="text" class="form-control col-sm-9" name="level" id="level" value="{{ $user['level'] }}" disabled="disabled">
        @if ($errors->has('level'))
            <span class="help-block">
                <strong>{{ $errors->first('level') }}</strong>
            </span>
        @endif
      </div>

      @if($user['id'] == Auth::user()->id)
      <div class="form-group container"style="padding-bottom: 5px; width: 100%;">
        <div class="profile-edit-text col-sm-3" for="exampleInputName2" style="padding-right: 20px; text-align: right;" >Image</div>
        <input type="file" class="form-control col-sm-9" name="picture" id="picture">
        @if ($errors->has('picture'))
            <span class="help-block">
                <strong>{{ $errors->first('picture') }}</strong>
            </span>
        @endif
      </div>
      <div style="padding-bottom:20px; padding:15px;">
        <button type="submit" class="btn btn-primary btn-oversquad col-md-offset-3 col-md-3" id="saveEditButton">Save modifications</button>
        <div class="cssload-loader col-md-offset-4 col-sm-offset-12" style="visibility: hidden;" id="loadingEditButton">Searching/Saving your profile</div>
      </div>

      @endif
    </form>

    <div class="row">

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
          <circle id="sd" class="medium" cx="50%" cy="50%" r="45%" fill="rgba(31, 60, 66, 0.9)" stroke="#1F3D44" stroke-width="2.5%"></circle>
          <circle id="sd" class="medium" cx="50%" cy="50%" r="45%" fill="url(#image1)" stroke="white" stroke-width="1%"></circle>
        </svg>
        <div class="text-center overwatch-hero" style="width:150px; margin-top:0px; margin-bottom:0px;">
          {{ $user->getHeroNameWithRank(1) }}
        </div>
        <div class="text-center overwatch-time" style="width:150px; margin-top:0px;">
          {{ $user->getHeroTimeWithRank(1) }}
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
          <circle id="sd" class="medium" cx="50%" cy="50%" r="45%" fill="rgba(31, 60, 66, 0.9)" stroke="#1F3D44" stroke-width="2.5%"></circle>
          <circle id="sd" class="medium" cx="50%" cy="50%" r="45%" fill="url(#image2)" stroke="white" stroke-width="1%"></circle>
        </svg>
        <div class="text-center overwatch-hero" style="width:150px; margin-top:0px; margin-bottom:0px;">
          {{  $user->getHeroNameWithRank(2) }}
        </div>
        <div class="text-center overwatch-time" style="width:150px; margin-top:0px;">
          {{ $user->getHeroTimeWithRank(2) }}
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
          <circle id="sd" class="medium" cx="50%" cy="50%" r="45%" fill="rgba(31, 60, 66, 0.9)" stroke="#1F3D44" stroke-width="2.5%" ></circle>
          <circle id="sd" class="medium" cx="50%" cy="50%" r="45%" fill="url(#image3)" stroke="white" stroke-width="1%" ></circle>
        </svg>
        <div class="text-center overwatch-hero" style="width:150px; margin-top:0px; margin-bottom:0px;">
          {{ $user->getHeroNameWithRank(3) }}
        </div>
        <div class="text-center overwatch-time" style="width:150px; margin-top:0px;">
          {{ $user->getHeroTimeWithRank(3) }}
        </div>
      </div>

    </div>

    <div class="row">
      <hr class="col-md-8">
      <div class="col-md-8">
        @if(count($games) !== 0 && $user['id'] == Auth::user()->id)
          <div class="overwatch-title text-center" style="font-size: 60px; color: white;">Last games</div>
        @endif
      </div>
      <div class="col-md-8">
      @if($user['id'] == Auth::user()->id)
          @forelse($games as $game)
              <div class="container-fluid game panel panel-default">
                  <div class="row">
                  @foreach($game->players as $player)
                      @if ($player)
                      <div class="col-md-2 text-center" style="position: relative;">
                          <img class="img img-responsive user-hover" src="{{ $player->picture }}" id="{{ $player->id }}" />
                      </div>
                      @endif
                  @endforeach
                  </div>
                  <br>
                  <div class="row">
                      @foreach($game->players as $player)
                          @if ($player)
                          <div class="col-md-2 text-center">
                                  <a href="{{ URL::route('showProfile', ['id' => $player->id ]) }}" class="btn @if($user['id'] === $player->id) btn-primary @else btn-warning @endif" style="width: 100%; overflow-x: ellipsis">
                                    <div class="profile-btn">{{ $player->gametag }}</div>
                                  </a>
                          </div>
                          @endif
                      @endforeach
                  </div>
              </div>
              <br>
          @empty
              <div class="overwatch-title text-center" style="font-size: 60px; margin-top:0px;">No games found</div>
          @endforelse
          <div class="row">
      @endif

    </div>
    </div>

@endsection

@section('scripts')
  @parent

  <script>
  $('#edit_info').submit(function() {
    $('#loadingEditButton').css('visibility', 'visible');
    $('#saveEditButton').css('visibility', 'hidden');
    return true;
  });
  </script>
@endsection
