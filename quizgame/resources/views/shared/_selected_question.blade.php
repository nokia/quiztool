<tr class="remove">
	<td><a href="#!" class="fa fa-minus"/></td>
	<td>{{ $selected->id }}</td>
	<td data-toggle="modal" data-target="#sModal-{{$selected->id}}">{{ $selected->text }}</td>
	<td>{{ $selected->group->name }}</td>
	<input type="hidden" name="questions[]" value="{{ $selected->id }}" />
</tr>