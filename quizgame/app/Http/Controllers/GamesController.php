<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\GameModel;
use App\Models\QuestionModel;
use App\Models\QuestionGroupModel;
//use App\Models\GameScoreModel;
use App\Http\Requests\GameCreationRequest;
use App\Http\Requests\JoinByTokenRequest;
use App\User;
use Auth;
use Hash;
use App\Events\StartGame;
use App\Events\Join;
use App\Events\Scored;
use Carbon\Carbon;

class GamesController extends Controller
{

	public function createPage(){
		//$this->authorize('createGame', GameModel::class);
		$questions = QuestionModel::with('answers')->get();
		$question_groups = QuestionGroupModel::all();
		return View('create')->with(compact('questions','question_groups'));
	}


    public function createGame(GameCreationRequest $request){
		//$this->authorize('createGame', GameModel::class);
		$questions = QuestionModel::whereIn('id', $request->questions)->get();
		$game = new GameModel();

		$game->session_name = $request->session_name;
		$game->user()->associate( Auth::user() );
		//$game->is_listed = $request->has('create');
		$game->start_time = $request->has('practice') ? Carbon::now()->toDateTimeString() : null;
		$game->length = $request->length;
		$game->hash_token = Hash::make($game->session_name);

		$game->save();
		
		$game->questions()->attach($questions->pluck('id')->toArray());
		$game = GameModel::where('id', $game->id)->with('questions.answers')->first();
		

		return $request->has('practice') ? redirect()->route('game.join', $game) : redirect()->route('game.lobby', $game);
	}

	public function joinPage(){
		$games = GameModel::where('start_time', null)->get();
		return View('join')->with(compact('games'));
	}

	public function joinByToken (JoinByTokenRequest $request){
		$game = GameModel::where('hash_token', $request->session_token)->first();
		Auth::user()->activeGame()->associate($game);
		Auth::user()->save();
		$game = GameModel::where('id', $game->id)->with('questions.answers', 'joinedUsers')->first();
		\Event::fire(new Join($game->id));
		return redirect()->route('game.lobby', $game);
	}

	public function joinGame( $game_id ) {
		//$this->authorize('createGame', GameModel::class);
		$game = GameModel::where('id', $game_id)->first();
		Auth::user()->activeGame()->associate($game);
		Auth::user()->save();
		$game = GameModel::where('id', $game->id)->with('questions.answers', 'joinedUsers')->first();
		\Event::fire(new Join($game->id));
		return redirect()->route('game.lobby', $game);
	}

	public function gameLobby( $game_id ){
		//$this->authorize('createGame', GameModel::class);
		$game = GameModel::where('id', $game_id)->with('questions.answers', 'joinedUsers')->first();
		
		if( !isset( Auth::user()->activeGame ) ){
			$sendToGame = false;
		} else if ( !is_null( $game->start_time ) && Auth::user()->activeGame->id == $game->id ){
			$sendToGame = true;
		} else {
			$sendToGame = false;
		}

		if ( $sendToGame ) {
			return redirect()->route('game', $game);
		} else {
			return View('gamelobby')->with(compact('game'));
		}	
	}

	public function playerJoined( $game_id ){
		$game = GameModel::where('id', $game_id)->with('joinedUsers')->first();
		$playersView = view()
		->make('shared._joined_players', ['game' => $game])
		->render();

        return response()->json([
            "ok" => 1,
            "html" => $playersView
        ], 200);
	}

	public function startGame( $game_id ){
		$game = GameModel::find($game_id);
		$game->start_time = Carbon::now()->toDateTimeString();
		//$game->is_listed = false;
		$game->save();
		$game = GameModel::where('id', $game->id)->with('questions.answers')->first();
		\Event::fire(new StartGame($game_id));
		return redirect()->route('game.lobby', $game);
	}

	public function pullToGame( $id ){

		//dd(Auth::user()->activeGame);
			if(Auth::user()->activeGame->id == $id){
				return response()->json([
					'participant'	=> 1
				], 200);
			} else {
				return response()->json([
					'participant'	=> 0
				], 200);
			}
        //}
		
	}	
	
	public function goToGame( $game_id ){
		if (!isset(Auth::user()->activeGame) || Auth::user()->activeGame->id!=$game_id) {
			return redirect()->route('home');
		}
		$game = GameModel::where('id', $game_id)->with('questions.answers')->first();
		$questions = $game->questions;
		foreach ($questions as $question) {
			$answers = $question->answers->sortByDesc('is_right');
			$good = $answers->first();
			$wrong = $answers->slice(1,3)->shuffle();
			$question->answersq = $wrong->push($good)->shuffle();
		}
		$questions = $questions->shuffle();
		//$remain = Carbon::now()->diffInSeconds(Carbon::parse($game->start_time)->addMinutes($game->length), false);
		$remain = Carbon::now()->diffInSeconds(Carbon::parse($game->start_time)->addMinutes($game->length), false);
		return View('game')->with(compact('game', 'questions', 'remain'));
	}

	public function remainingTime(Request $request){
		$game = GameModel::find($request->gameid);
		//$remainTime = Carbon::now()->diffInSeconds(Carbon::parse($game->start_time)->addMinutes($game->length), false);
		$remainTime = Carbon::now()->diffInSeconds(Carbon::parse($game->start_time)->addMinutes($game->length), false);
		if($request->ajax()){
			if($remainTime <= 0){
				return response()->json([
	                "ended" => 1
	            ], 200);
			} else {
				return response()->json([
	                "ended" => 0
	            ], 200);
			}
		}
	}

	public function score(Request $request){
		$user_id = Auth::user()->id;
		$game = GameModel::where('id', $request->_game)->with('questions.answers')->first();
		$points = 0;
		if(!empty($request->quiz)){
			foreach($request->quiz as $question => $given_answer) {
				if ($given_answer == $game->questions->where('id', $question)->first()->answers->where('is_right', true)->first()->id) {
					$points++;
				}
			}
			if (!is_null($game->joinedUsers()->find($user_id))) {
				$game->scores()->save(Auth::user(), ['points' => $points]);
				$user = Auth::user();
				$user->activeGame()->dissociate();
				$user->save();
				\Event::fire(new Join($game->id));
				\Event::fire(new Scored($game->id));
				$quiz = $request->quiz;
				return View('scores')->with(compact('quiz', 'game', 'points'));
			} else {
				return redirect()->route('home');
			}
		}
	}

	public function playerFinished( $game_id ){
		$game = GameModel::where('id', $game_id)->with('scores')->first();
		$playersView = view()
		->make('shared._finished_players', ['game' => $game])
		->render();

        return response()->json([
            "ok" => 1,
            "html" => $playersView
        ], 200);
	}

	public function myGames(){
		$games = GameModel::where('user_id', Auth::user()->id )->orderBy('start_time', 'DESC')->get();
		return View('mygames')->with(compact('games'));
	}

	public function myScores(){
		return View('myscores');
	}

	public function deleteGame( Request $request, GameModel $game ){

		//$this->authorize('deleteGame', $game);
		$game->delete();
		if($request->ajax()) {
			if($request->has('fromjoinpage')) {
				$games = GameModel::where('start_time', null)->get();
				//$games = GameModel::where('is_listed', true)->get();
			} else {
				$games = GameModel::where('user_id', Auth::user()->id )->orderBy('start_time', 'DESC')->get();
			}

			$gamesView = view()
			->make('shared._game_list' , ['games' => $games])
			->render();

			return response()->json([
	            "ok" => 1,
	            "html" => $gamesView
        	], 200);
		}

		return redirect()->route('home');
	}

	public function kickOutUser (Request $request, $user_id ){
		$user=User::find($user_id);
		$game_id = $user->activeGame->id;
		$user->activeGame()->dissociate();
		$user->save();
		\Event::fire(new Join($game_id));
		if($request->ajax()){
			return response()->json([
	            "ok" => 1
	        ], 200);
	    } else {
	    	return redirect()->route('home');
	    }
	}
}
