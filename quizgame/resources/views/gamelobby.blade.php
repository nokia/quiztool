@extends('layout.master_layout')
@section('title', 'Game Lobby')
@section('content')



<div class="game-lobby container">

  <div class="game-dash row">
    <div class="col-md-10">
      <h3>{{$game->session_name}}</h3>
    </div>
    <div class="gamecontrol col-md-2 ">
      
      @can('deleteGame', $game)
        @if(is_null($game->start_time))
        <a href="{{ route('game.start', $game) }}" class="btn btn-default">Start</a>
        @endif
        <a href="{{ route('game.delete', $game) }}" class="btn btn-danger"><i class="fa fa-trash-o" aria-hidden="true"></i></a>
      @endcan
    </div>
  </div>

  <div class="game-info row">
    <h4>Game Info</h4>
    <ul class="info list-inline">
      <li><span class="attribute"><i class="fa fa-user" aria-hidden="true"></i> Owner </span>{{ $game->user->username }}</li>
      <li><span class="attribute"><i class="fa fa-clock-o" aria-hidden="true"></i> Duration </span>{{$game->length}} minutes</li>
      @can('deleteGame', $game)
      <li id="copy-target" class="pull-right"><span class="attribute"><i class="fa fa-slack" aria-hidden="true"></i> Token </span>{{ $game->hash_token }} <i id="copy" class="fa fa-clipboard" title="Copy to clipboard" data-clipboard-action="copy" data-clipboard-text="{{ $game->hash_token }}" aria-hidden="true"></i></li>
      @endcan
    </ul>
  </div>
  
  <div id="joined" class="row">
    <h4>Joined players</h4>
      @include('.shared._joined_players')
  </div>

@can('deleteGame', $game)
  <div class="row">  
    <div class="quiz-overview col-md-6">
      <h4>Quiz overview</h4>
        <ul class="question-list">
          @foreach( $game->questions as $question )
            <li class="" id="question-{{$question->id}}"><i class="fa fa-commenting-o" aria-hidden="true"></i> {{ $question->text }} </li>
          @endforeach
        </ul>
    </div>
    <div class="resuts col-md-6">
      <h4>Finished players</h4>
        @include('.shared._finished_players')
    </div>
  </div>
@endcan
    

<script>

var clipboard = new Clipboard('#copy');

$('#copy').tooltip();

clipboard.on('success', function(e) {
  //console.log(e);
  $('#copy').attr('title', 'Copied')
      .tooltip('fixTitle')
      .tooltip('show')
      .attr('title', "Copy to Clipboard")
    .tooltip('fixTitle');
});

clipboard.on('error', function(e) {
    console.log(e);
});

$("#questions").click(function(event){
  event.preventDefault();
  $("[id^=question-]").toggle();
});

$('body').on('click', ".kickout", function(event){
  event.preventDefault();
  $.ajax({
  type: 'GET',
  dataType: 'JSON',
  url: '/kickout/' + $(this).attr('id')
  })
    .done(function( msg ){
      console.log(msg.ok);
    });
});
</script>

<script>
  var socketURL = 'http://10.183.21.84:8080'; 
  var socket = io(socketURL);
  //alert("here");
  socket.on('new-player:App\\Events\\Join', function (event) {
      if(event.id != ''){
        $.ajax({
        type: 'GET',
        dataType: 'JSON',
        url: '/playerJoined/' + event.id
        })
          .done(function( msg ){
            $('.playerlist').html(msg.html);
          });
      } else {
        alert('no event id?');
      }
  });
  socket.on('game-finished:App\\Events\\Scored', function (event) {
      if(event.id != ''){
        $.ajax({
        type: 'GET',
        dataType: 'JSON',
        url: '/playerFinished/' + event.id
        })
          .done(function( msg ){
            $('#finished').html(msg.html);
            //reload partial view
          });
      } else {
        alert('no event id?');
      }
  });

</script>
@stop
