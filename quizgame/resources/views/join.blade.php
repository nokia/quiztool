@extends('layout.master_layout')
@section('title', 'Lobby')
@section('content')

<div class="game-index">
  
  <div class="jointoken">
        <h4>Join by code</h4>
        <form action="{{ route('join.token') }}" method="POST" >
        <div class="input-group">
          <input type="text" class="form-control" name="session_token" placeholder="{{ $errors->first('session_token') }}" ></input>
          <div class="input-group-btn">
            <input type="submit" class="btn btn-primary" name="Join" Value="Join"></input>
          </div>
        </div>
          <input type="hidden" name="_token" value="{{ csrf_token() }}" />
        </form>
  </div>

  <div class="lobby">
    <h4>Active Games</h4>
    @include('.shared._game_list')
  </div>
</div>
<script>
$('body').on('click', ".btn-danger", function(event){

  $.ajax({
    headers: {
      'X-CSRF-TOKEN': $('input[name="_token"]').attr('value')
    },
    type: 'POST',
    dataType: 'JSON',
    url: '/delete/' + $(this).attr('id'),
    data: {fromjoinpage: 'yes' }
    })
      .done(function( msg ){
        $('#gamelist').html(msg.html);
        //reload partial view
      });
});
</script>
@stop
