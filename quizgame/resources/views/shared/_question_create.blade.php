<form class="addquestion" action="{{ route('addquestion') }}" method="post">
  <h4>Add a question, a group for it and 4 possible answers</h4>
    <div class="form-group col-md-6">
        <label for="group">Add a question group</label>
        <input type="text" class="form-control" name="group" value={{ old('group') }}>{{ $errors->first('group') }}
    </div>
    <div class="form-group col-md-6">
        <label for="group2">Choose a question group</label>
          <select class="form-control" name="group2">
          <option value=""></option>
          
          @foreach($question_groups as $group)
          <option value="{{ $group->name }}">{{ $group->name }}</option>
          @endforeach
        </select>
    </div>

    <div class="form-group {{ count($errors) != 0 ? ' has-error' : '' }}">
      <input type="text" class="form-control" name="quest" placeholder="Question" value={{ old('quest') }}>{{ $errors->first('quest') }}
    </div>
    @for($i = 0; $i < 4; $i++)
      <div class="form-group {{ count($errors) != 0 ? ' has-error' : '' }}">
        <input type="text" class="form-control" name="ans[{{ $i }}]" placeholder="{{ $i<1 ? "Rigth answer" : "Wrong answer" }}" value={{ old('ans.' .$i) }}>{{ $errors->first('ans.' .$i) }}
      </div>
    @endfor
    
    <div class="form-group">
      <button type="submit" class="btn btn-default">Upload</button>
      <input type="hidden" name="_token" value="{{ csrf_token() }}" />
    </div>
</form>