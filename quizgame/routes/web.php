<?php

Route::group(['middleware' => 'App\Http\Middleware\AdminMiddleware'], function(){

	Route::post('/addQuestion', 'QuestionsController@addQuestion')->name('addquestion');

	Route::get('/questionCreate', 'QuestionsController@create')->name('question.create');
	
	Route::get('/questionUpload', 'QuestionsUploader@create')->name('question.upload');
	
	Route::post('/questionUpload', 'QuestionsUploader@store')->name('question.store');	

	Route::get('/editQuestion/{id}', 'QuestionsController@edit')->name('question.edit');

	Route::post('/updateQuestion/{id}', 'QuestionsController@update')->name('question.update');

	Route::get('/deleteQuestion/{id}', 'QuestionsController@destroy')->name('question.delete');

	Route::get('/members', 'UserController@listUsers')->name('user.show');

	Route::get('/makeAdmin/{id}', 'UserController@levelUp')->name('user.upgrade');

	Route::get('/makeUser/{id}', 'UserController@levelDown')->name('user.downgrade');
});

Route::group(['middleware' => 'App\Http\Middleware\AuthMiddleware'], function(){

	Route::post('/', function(){
		return View('home');
	})->name('home');

	Route::get('/create', 'GamesController@createPage')->name('create');

	Route::post('/create', 'GamesController@createGame')->name('create');

	Route::get('/lobby', 'GamesController@joinPage')->name('lobby');

	Route::post('/join', 'GamesController@joinByToken')->name('join.token');
		
	Route::get('/join/{id}', 'GamesController@joinGame')->name('game.join');

	Route::get('/playerJoined/{id}', 'GamesController@playerJoined');

	Route::get('/GameLobby/{id}', 'GamesController@gameLobby')->name('game.lobby');

	Route::get('/game/{id}', 'GamesController@goToGame')->name('game');

	Route::get('/start/{id}', 'GamesController@startGame')->name('game.start');

	Route::get('/pullToGame/{id}', 'GamesController@pullToGame');

	Route::post('/gameEnded', 'GamesController@remainingTime');

	Route::post('/score', 'GamesController@score')->name('score');

	Route::get('/myScores', 'GamesController@myScores')->name('ranking');

	Route::get('/playerFinished/{id}', 'GamesController@playerFinished');

	Route::post('/statistics', 'GamesController@statistics')->name('game.stats');

	Route::get('/MyGames', 'GamesController@myGames')->name('mygames');

	Route::get('/kickout/{id}', 'GamesController@kickOutUser')->name('user.kickout');

	Route::get('/delete/{game}','GamesController@deleteGame')->name('game.delete');

	Route::post('/delete/{game}','GamesController@deleteGame')->name('game.delete');

	Route::get('/question/{id}', 'QuestionsController@show');

	Route::post('/question/filter', 'QuestionsController@filterQuestions');

	Route::get('/profile', function(){
		return View('profile');
	})->name('profile');

});

Route::get('/', function(){
	return View('home');
})->name('home');

Route::get('/logout', 'Auth\LoginController@logout')->name('logout');

Route::post('/login', 'Auth\LoginController@login')->name('login');
