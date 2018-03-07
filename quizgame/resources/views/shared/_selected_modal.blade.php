<div class="modal fade" id="sModal-{{$selected->id}}" >
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title">{{ $selected->text }}</h4>
			</div>
			<div class="modal-body">
				<ul>
					@foreach($selected->answers as $answer)
						<li>{{$answer->text}}</li>
					@endforeach
				</ul>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Ok</button>
			</div>
		</div>
	</div>
</div>