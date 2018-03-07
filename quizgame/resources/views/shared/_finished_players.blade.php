<table class="table" id="finished">
<thead>
	<tr>
		<th>rank</th>
		<th>name</th>
		<th>score</th>
	</tr>
</thead>
<tbody>
  
    @forelse( $game->scores as $score )
      <tr>
      	<td><i class="fa fa-hashtag" aria-hidden="true"></i> {{ $loop->index + 1 }}</td>
      	<td><i class="fa fa-user-o" aria-hidden="true"></i> {{ $score->username }}</td>
      	<td>{{ $score->pivot->points }}</td>
      </tr>
    @empty
    @endforelse
</tbody>
</table>