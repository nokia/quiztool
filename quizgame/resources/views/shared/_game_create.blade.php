<div class="questionTable">
	<table class="table">
		<h4>Choose questions for the quiz</h4>
		<thead>
			<tr>
				<th><a href="#!" class="select-all">Select all</a></th>
				<th>Question id</th>
				<th>Question text</th>
				<th>Question group (area)</th>
				<th><a href="#!" class="fa fa-filter" id="filter-toggle"></a></th>
			</tr>
		</thead>
		<tbody>

		@foreach($questions as $question)
			<tr>
				<td><a href="#!" class="fa fa-plus" name="selector" data-quid="{{ $question->id}}" /></td>
				<td>{{ $question->id }}</td>
				<td data-toggle="modal" data-target="#modal-{{$question->id}}">{{ $question->text }}</td>
				<td>{{ $question->group->name }}</td>
			</tr>
			<div class="modal fade" id="modal-{{$question->id}}" >
				<div class="modal-dialog">
					<div class="modal-content">
						<div class="modal-header">
							<h4 class="modal-title">{{ $question->text }}</h4>
						</div>
						<div class="modal-body">
							<ul>
								@foreach($question->answers as $answer)
									<li>{{$answer->text}}</li>
								@endforeach
							</ul>
						</div>
						<div class="modal-footer">
							<a href="{{ route('question.edit', $question->id) }} " class="btn btn-info">Edit</a>
							<button type="button" class="btn btn-default" data-dismiss="modal">Ok</button>
						</div>
					</div>
				</div>
				
			</div>
		@endforeach

		</tbody>
	</table>
</div>