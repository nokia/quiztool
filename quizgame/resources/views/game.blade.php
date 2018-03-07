@extends('layout.master_layout')
@section('title', 'Game')
@section('content')
<style type="text/css" media="screen">

.question:not(:first-child),
#prev,
#submit {
    display: none;
}
</style>
<div class="game-mode">
  

<div id="timer" value="{{$remain}}"></div>

<form id="quiz_form" class="container" action="{{ route('score') }}" method="post">
    <div class="">
        @forelse($questions as $question)
        <div class="question">
          <div class="question-header container">
              <div class="col-md-10">
                <p class="title">{{ $question->text }}</p>
              </div>
              <div class="col-md-2 text-right">{{ $loop->index + 1 }}/{{ $questions->count()}}</div>
          </div>
          <div class="question-body funkyradio">
            <input type="radio" name="quiz[{{ $question->id }}]" value="0" checked />
            @foreach($question->answersq as $answer)
            <div>
                <input type="radio" name="quiz[{{ $question->id }}]" value="{{ $answer->id }}" id="answer-{{ $answer->id }}"/>
                <label for="answer-{{ $answer->id }}">{{ $answer->text }}</label>
            </div>
            @endforeach
          </div>
        </div>
        @empty
        	<p>No questions to be displayed.</p>
        @endforelse
        <div class="nav-controls">
          <a href="#!" class="btn btn-default" id="prev">Previous</a>
          <a href="#" class="btn btn-default pull-right" id="next">Next</a>
          <button type="submit" class="btn btn-primary pull-right" id="submit">Submit</button>
        </div>
    </div>
    <input type="hidden" name="_game" value="{{ $game->id }}" />
    <input type="hidden" name="_user" value="{{Auth::user()->id}}"/>
    <input type="hidden" name="_token" value="{{ csrf_token() }}" />
</form>
</div>
<script>

function incTimer() {
        var currentHours = Math.floor(totalSecs / 3600)
        var currentMinutes = Math.floor(totalSecs / 60);
        var currentSeconds = totalSecs % 60;
        if(currentSeconds <= 9) currentSeconds = "0" + currentSeconds;
        if(currentMinutes <= 9) currentMinutes = "0" + currentMinutes;
        if(currentHours <= 9) currentHours = "0" + currentHours;
        totalSecs--;
        if(currentHours > 0 || currentMinutes > 0 || currentSeconds > 0){
          $("#timer").text(currentHours + ":" + currentMinutes + ":" + currentSeconds);
          setTimeout('incTimer()', 1000);
        } else {
          $('#timer').text("Time's up");
        }
    }

    totalSecs = $('#timer').attr('value');

    $(document).ready(function() {
        incTimer();
    });
	
	
$(document).ready(function(){
  if( $(".question:visible").is('.question:last') ){
    $("#prev").hide();
    $("#next").hide();
    $("#submit").show();
  }
});

$('body').on('click', 'input[name=_game]', function(event){
  event.preventDefault();
  $.ajax({
    headers: {
        'X-CSRF-TOKEN': $('input[name="_token"]').attr('value')
      },
    method: "POST",
    url: "/gameEnded",
    data: { gameid : $('input[name=_game]').attr('value') }
  })
    .done(function( game ) {
      if(game.ended){
        $('#submit').trigger('click');
      }
    });
});

$("#next").click(function(){
    $('input[name=_game]').trigger('click');

    if ($(".question:visible").next(".question").length != 0)
        $(".question:visible").next().show().prev().hide();
    else {
        $(".question:visible").hide();
    }

    if( !$(".question:visible").is('.question:first') )
        $("#prev").show();
    if( $(".question:visible").is('.question:last') ){
        $("#next").hide();
        $("#submit").show();
    }
    return false;
});

$("#prev").click(function(){
  $('input[name=_game]').trigger('click');

    if ($(".question:visible").prev(".question").length != 0)
        $(".question:visible").prev().show().next().hide();
    else {
        $(".question:visible").hide();
    }

    if( !$(".question:visible").is('.question:last') ){
        $("#next").show();
        $("#submit").hide();
    }
    if( $(".question:visible").is('.question:first') )
        $("#prev").hide();
    return false;
});
</script>
@stop
