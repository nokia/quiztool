<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>Quiz Game - @yield('title')</title>

		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

		<!-- Js files -->
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
		<script src="{{  asset('js/socket.io.js')}}"></script>
		<!--script src="http://localhost:8080/socket.io/socket.io.js"></script-->
		<script src="https://cdn.jsdelivr.net/clipboard.js/1.6.0/clipboard.min.js"></script>
		
		<!-- Styles -->
		<link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
		<link rel="stylesheet" type="text/css" href="{{ asset('fonts/font-awesome/css/font-awesome.min.css') }}">
		<link rel="stylesheet" type="text/css" href="{{ asset('css/style.css') }}">
	</head>
	<body>
		<script>

		var socketURL = 'http://10.183.21.84:8080';
		var socket = io(socketURL);
		socket.on('join-players:App\\Events\\StartGame', function (event) {
		    if(event.id != ''){
		    	$.ajax({
					type: 'GET',
					dataType: 'JSON',
					url: '/pullToGame/' + event.id
				})
		    	  .done(function( user ){
		    	  	if(user.participant){
		    	  		@if(isset(Auth::user()->activeGame))
		    	  			window.location="{{URL::to('GameLobby', Auth::user()->activeGame->id)}}";
		    	  		@endif
		    	  	}
		    	  });
		    } else {
		    	alert('no event id?');
		    }
		});

		</script>
	@include('layout._header')
	<div class="content container">
		@yield('content')
	</div>
	@include('layout._footer')
	</body>
</html>