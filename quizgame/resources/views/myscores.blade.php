@extends('layout.master_layout')
@section('title', 'My Games')
@section('content')

<div class="myscores">
  <table id="gamelist" class="table">
  <thead>
    <tr>
      <th>Name</th>
      <th>Creator</th>
      <th>Started</th>
      <th>Points</th>
    </tr>
  </thead>
  <tbody>
    @forelse(Auth::user()->scores as $score)
    <tr>
      <td>{{ $score->session_name }}</td>
      <td>{{ $score->user->username }}</td>
      <td class="only-mygames">{{ is_null($score->start_time) ? 'no' : $score->start_time }}</td>
      <td>{{ $score->pivot->points }}</td>
    </tr>
      @empty
        <tr><td>No scores so far.</td></tr>
      @endforelse
  </tbody>
</table>
</div>

@stop