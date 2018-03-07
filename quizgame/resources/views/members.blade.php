@extends('layout.master_layout')
@section('title', 'Profile')
@section('content')

    <div class="members">

        <h4>Members</h4>
        <table id="memberlist" class="table">
		  <thead>
		    <tr>
		      <th>Username</th>
		      <th>ID</th>
		      <th>Name</th>
		      <th>Email</th>
		      <th>Admin status</th>		      
		      <th class="text-right">Actions</th>
		    </tr>
		  </thead>
		  <tbody>
		    @foreach($users as $user)
		    <tr>
		      <td>{{ $user->username }}</td>
		      <td>{{ $user->id }}</td>
		      <td>{{ $user->firstname . " " . $user->lastname }}</td>
		      <td>{{ $user->email }}</td>		      
		      <td>{{ $user->isAdmin() ? "admin" : "not admin"}}</td>
		      <td class="text-right">
		      @if(!$user->isAdmin())
		        <a href="{{ route('user.upgrade', $user->id) }}" class="btn btn-success">Make Admin</a>
		      @endif
		      @if($user->isAdmin() && $user->id!=1 && $user->id!=Auth::user()->id)
		      	<a href="{{ route('user.downgrade', $user->id) }}" class="btn btn-danger">Make Not Admin</a>
		      @endif		      
		      </td>
		    </tr>
		      @endforeach
		  </tbody>
		</table>
    </div>
@stop