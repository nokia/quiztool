@extends('layout.master_layout')
@section('title', 'Question edit')
@section('content')

<form class="editquestion" action="{{ route('question.update', $question->id) }}" method="post">
  <h4>You can edit or delete the question here</h4>
    <div class="form-group col-md-6">
        <label for="group">Add a new question group</label>
        <input type="text" class="form-control" name="group" value="{{ $default_group }}">{{ $default_group }}
    </div>
    <div class="form-group col-md-6">
        <label for="group2">Choose an existing question group</label>
          <select class="form-control" name="group2">
          <option value=""></option>
          
          @foreach($question_groups as $group)
          <option value="{{ $group->name }}">{{ $group->name }}</option>
          @endforeach
        </select>
    </div>

    <div class="form-group">
      <input type="text" class="form-control" name="quest" value="{{ is_null(old('quest')) ? $question->text : old('quest')}}">{{ $errors->first('quest') }}
    </div>
    @foreach($question->answers as $answer)
      <div class="form-group">
      <label for="{{ $answer->id }}">{{$answer->is_right ? "correct answer" : "wrong answer"}}</label>
        <input type="text" class="form-control" name="ans[{{ $answer->id }}]" value="{{ is_null(old('ans.' .$answer->id)) ? $answer->text : old('ans.' .$answer->id)}}">{{ $errors->first('ans.' .$answer->id) }}
      </div>
    @endforeach
    
    <div class="form-group">
      <a href="{{ route('question.delete', $question->id) }}" class="btn btn-danger">Delete</a>
      <button type="submit" class="btn btn-primary">Update</button>
      <input type="hidden" name="_token" value="{{ csrf_token() }}" />
    </div>
</form>

@stop
