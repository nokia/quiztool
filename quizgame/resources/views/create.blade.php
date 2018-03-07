@extends('layout.master_layout')
@section('title', 'Create')
@section('content')
<style type="text/css" media="screen">
#questionFilter,
.addquestion{
	display: none;
}
</style>
<div class="game game-creation">
		<h3>Create a game</h3>
	<form id="questionFilter" class="container" action="" method="post">

			<h4>Filter</h4>
			<div class="form-group col-md-6">
				<input type="text" class="form-control" name="question_id" id="id_filter" placeholder="Question id"></input>
			</div>
			<div class="form-group col-md-6">
				<input type="text" class="form-control" name="question_text" id="text_filter" placeholder="Question text"></input>
			</div>
			<div class="form-group col-md-6">
        		<label class="sr-only" for="group_filter">Choose a question group</label>
          		<select class="form-control" name="question_group">
		          <option value="">Question group</option>
		          option
		          @foreach($question_groups as $group)
		          <option value="{{ $group->id }}">{{ $group->name }}</option>
		          @endforeach
				</select>
		    </div>
			<div class="form-group col-md-6">
				<input type="text" class="form-control" name="question_training" id="training_filter" placeholder="Training group (not functional yet)"></input>
			</div>
			<div class="form-group">
				<!--input type="submit" class="btn btn-default" name="filter" value="Filter"-->
			</div>
		<input type="hidden" name="_token" value="{{ csrf_token() }}" />
	</form>

	@include('.shared._game_create')

	@can('addQuestion', App\Models\QuestionModel::class)
		<!-- <a href="#!" class="fa fa-filter" id="add-question">Add custom questions</a> -->
		<a> <button id="add-question" type="button">Add a custom question</button> </a>
		@include('shared._question_create')
	@endcan

	<form class="summary" action="{{ route('create') }}" method="post">
		
		<h4>Chosen questions for the quiz</h4>
		<div class="form-group col-md-8">
			<input type="text" class="form-control" name="session_name" placeholder="Add a name" value={{ old('session_name') }}>{{ $errors->first('session_name') }}</input>
		</div>
		<div class="form-group col-md-2">
			<select class="form-control" name="length">
				  <option value=1 >1 min</option>
		          <option value=5 >5 min</option>
		          <option value=10 >10 min</option>
		          <option value=15 >15 min</option>
		          <option value=20 >20 min</option>
		          <option value=25 >25 min</option>
		          <option value=30 >30 min</option>
			</select>
		</div>
		<div class="form-group col-md-2">
		<div class="btn-group pull-right">
			
	  		<input type="submit" class="btn btn-default" name="practice" Value="Practice"></input>
	  		<input type="submit" class="btn btn-primary" name="create" Value="Create"></input>
		</div>
		</div>
		{{ $errors->first('questions') }}
		<table class="table">
			<thead>
				<tr>
					<th><a href="#!" class="delete-all"/>Delete All</th>
					<th>Question id</th>
					<th>Question text</th>
					<th>Question group (area)</th>
				</tr>
			</thead>
			<tbody class="selected-questions">
				
			</tbody>
		</table>
		<input type="hidden" name="_token" value="{{ csrf_token() }}" />
	</form>

</div>

<script>

$('body').on('click', "#filter-toggle", function(event){
	event.preventDefault();
	$("#questionFilter").toggle();
});

$("#add-question").click(function(event){
	event.preventDefault();
	$(".addquestion").toggle();
});

$('body').on('keyup', '#questionFilter', function(event){
	event.preventDefault();
	$.ajax({
		headers: {
        'X-CSRF-TOKEN': $('input[name="_token"]').attr('value')
    	},
		method: "POST",
		url: "question/filter",
		data: $('#questionFilter').serialize() + $('.summary').serialize()
	})
	  .done(function( msg ) {
	    $('.questionTable').html(msg.html);
	  });
});

$('body').on('change', '#questionFilter', function(){
	$(this).trigger('keyup');
});

$('body').on('click', '.select-all', function(event){
	event.preventDefault();
	$("tbody .fa-plus").each(function(){
		$(this).trigger('click');
	});
});

$('body').on('click', "tbody .fa-plus", function(event){
	event.preventDefault();
	var quid= $(this).data("quid");
	$(this).closest("tr").remove();
	$.ajax({
		type: 'GET',
		dataType: 'JSON',
		url: "question/" + quid
	})
	  .done(function( data ) {
	  	$(".summary").append(data.modal);
		$(".selected-questions").append(data.row);
	  });
});

$('body').on('click', "tbody .fa-minus", function(event){
	event.preventDefault();
	$($(this).closest('tr').find('td:nth-child(3)').data('target')).remove();
	$(this).closest('tr').remove();
	$('#questionFilter').trigger('keyup');
});

$(".delete-all").click(function(event){
	event.preventDefault();
	$(".summary tbody > tr").remove();
	$('#questionFilter').trigger('keyup');
});
</script>
@stop