@extends('layout.master_layout')
@section('title', 'Profile')
@section('content')
    <div class="profile">
        <h4>Username: {{Auth::user()->username}}</h4>
        User ID: {{Auth::user()->id}}<br>
        Name: {{Auth::user()->firstname . " " . Auth::user()->lastname}} <br>
        Email: {{Auth::user()->email}}<br>
        Admin status: {{Auth::user()->isAdmin()? "admin" : "not admin"}}
    </div>
@stop