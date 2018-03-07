<ul class="playerlist">

  @foreach( $game->joinedUsers as $partic )
  <li>
    <i class="fa fa-user-o" aria-hidden="true"></i>
    @can('deleteGame', $game)<a href="#!" class="kickout" id="{{ $partic->id }}">@endcan{{ $partic->username}}</a>
  </li>
  @endforeach

</ul>