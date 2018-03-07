@extends('layout.master_layout')
@section('title', 'My Games')
@section('content')

<div class="mygames">
  @include('.shared._game_list')
</div>

<script>
$('body').on('click', ".btn-danger", function(event){

  $.ajax({
    headers: {
      'X-CSRF-TOKEN': $('input[name="_token"]').attr('value')
    },
    type: 'GET',
    dataType: 'JSON',
    url: '/delete/' + $(this).attr('id')
    })
      .done(function( msg ){
        $('#gamelist').html(msg.html);
        //reload partial view
      });
});
</script>
@stop
