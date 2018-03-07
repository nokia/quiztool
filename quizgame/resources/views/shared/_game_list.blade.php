<table id="gamelist" class="table">
  <thead>
    <tr>
      <th>Name</th>
      <th>Creator</th>
      <th class="only-mygames">Started</th>
      <th class="text-right">Actions</th>
    </tr>
  </thead>
  <tbody>
    @forelse($games as $game)
    <tr>
      <td>{{ $game->session_name }}</td>
      <td>{{ $game->user->username }}</td>
      <td class="only-mygames">{{ is_null($game->start_time) ? 'no' : $game->start_time }}</td>
      <td class="text-right">
      @if(is_null($game->start_time))
        <a href="{{ route('game.join', $game ) }}" class="btn btn-default">Join</a>
      @endif
      @can('deleteGame', $game)
        <a href="{{ route('game.lobby', $game->id) }}" class="btn btn-default">Dash</a>
        <a href="#!" class="btn btn-danger" id="{{$game->id}}">Delete</a>
      @endcan
      </td>
    </tr>
      @empty
        <tr><td>No active games.</td></tr>
      @endforelse
  </tbody>
</table>