<header id="header">
	<nav class="navbar navbar-default">
		<div class="container-fluid">
			<div class="navbar-header">
				<a class="navbar-brand" href="{{ route('home') }}">Quiz Game</a>
			</div>
			@if (Auth::check())
			<ul class="nav navbar-nav">
				<li><a href="{{ route('create') }}">Create</a></li>
				<li><a href="{{ route('lobby') }}">Join</a></li>
				
				@if( !is_null( Auth::user()->activeGame ))
					<li id="backToGame"><a href="{{ route('game.lobby', Auth::user()->activeGame->id) }}">Back to game</a></li>
				@endif
			</ul>
			@if( isset($remain))
				<div id="timer" value="{{$remain}}"></div>
			@endif
			<ul class="nav navbar-nav navbar-right">
	            <li class="dropdown usermenu">
	                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false" name="profile"><span class="glyphicon glyphicon-user"></span> <span class="caret"></span></a>
	                <ul class="dropdown-menu">
	                    <li style="text-align: center; color: #777;">{{ Auth::user()->username }}</li>
	                    <li role="separator" class="divider"></li>
	                    <li>
	                        <a href="{{ route('profile') }}">
	                            <span class="fa fa-user fa-fw" aria-hidden="true"></span>
	                            Profile
	                        </a>
	                    </li>
	                    <li>
	                        <a href="{{ route('mygames') }}">
	                            <span class="fa fa-th fa-fw" aria-hidden="true"></span>
	                            MyGames
	                        </a>
	                    </li>
	                   @if (Auth::user()->isAdmin()) 
	                    <li>
	                        <a href="{{ route('user.show') }}">
	                            <span class="fa fa-lock fa-fw" aria-hidden="true"></span>
	                            Members
	                        </a>
	                    </li>
	                    <li>
	                        <a href="{{ route('question.create') }}">
	                            <span class="fa fa-lock fa-fw" aria-hidden="true"></span>
	                            Add new question
	                        </a>
	                    </li>
						<li>
	                        <a href="{{ route('question.upload') }}">
	                            <span class="fa fa-lock fa-fw" aria-hidden="true"></span>
	                            Upload questions
	                        </a>
	                    </li>
	                    @endif
						<li role="separator" class="divider"></li>
	                    <li>
	                        <a href="{{ route('logout') }}">
	                            <span class="fa fa-sign-out fa-fw" aria-hidden="true"></span>
	                            Logout
	                        </a>
	                    </li>
	                </ul>
	            </li>
        	</ul>
			@else
			<form class="navbar-form login-form navbar-right form-inline" action="{{ route('login') }}" method="post" accept-charset="utf-8">
				<div class="form-group">
	                <div class="input-group {{ count($errors) != 0 ? ' has-error' : '' }}">
	                    <div class="input-group-addon"><i class="fa fa-user" aria-hidden="true"></i></div>
	                    <input class="form-control"  name="username" type="text" placeholder="Username">
	                </div>
	                <div class="input-group {{ count($errors) != 0 ? ' has-error' : '' }}">
	                    <div class="input-group-addon"><i class="fa fa-key" aria-hidden="true"></i></div>
	                    <input class="form-control" name="password" type="password" placeholder="Password">
	                </div>
	                <button class="btn" type="submit">Login</button>
	               <input type="hidden" name="_token" value="{{!! csrf_token() !!}}">
	            </div>
		<!--<pre>{{ dd($errors) }}</pre>-->
            </form>
			@endif
		</div>
	</nav>
</header>