@if(isset($succesMessage)) 
<div class="alert alert-success">
	{{$succesMessage}}
</div>
@endif
<form action="{{route('question.store')}}" method='post' enctype="multipart/form-data">
<input type="file" name="file"/><br><br>
	
<input type="submit" name="submit" value="Upload"/>

</form>
