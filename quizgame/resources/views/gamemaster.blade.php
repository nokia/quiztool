@extends('layout.master_layout')
@section('title', 'Create')
@section('content')

    <div class="col-md-6">

        <h3>{{ $game->session_name }}</h3>
        <ul class="list-group">
        	<li class="list-group-item list-group-item-info">Creator: {{ $game->user->username }}</li>
          <li class="list-group-item list-group-item-info">Questions:</li>
          @foreach( $game->questions as $question )
            <li class="list-group-item text-center"> {{ $question->text }} </li>
          @endforeach
          <a href="{{ route('game.join', $game) }}" class="btn btn-default">Start</a>
          @can('deleteGame', $game)
          <a href="{{ route('game.delete', $game) }}" class="btn btn-default">Delete</a>
          @endcan
        </ul>
    </div>


@stop
