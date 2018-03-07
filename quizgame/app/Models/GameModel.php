<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\User;

class GameModel extends Model
{
    public $timestamps = true;

	protected $table = "games";
    
    public function user(){
        return $this->belongsTo('App\User');
    }

    public function scores(){
        return $this->belongsToMany('App\User', 'game_scores', 'game_id', 'player_id')->withPivot('points')->orderBy('points', 'DESC');
    }

    public function joinedUsers() {
        return $this->hasMany('App\User', 'active_game');
    }

    public function questions(){
        return $this->belongsToMany('App\Models\QuestionModel', 'game_questions', 'game_id', 'question_id');
    }

    protected $fillable = [
        'user_id', 'session_name', 'start_time', 'length', 'hash_token'
    ];

    /*protected $casts = [
        'is_listed' => 'boolean'
    ];*/

    protected static function boot() {
        parent::boot();

        static::deleting(function( $game ){
            $game->questions()->detach();
            $users = User::where( 'active_game', $game->id )->each(function($user, $key){
                $user->activeGame()->dissociate();
                $user->save();
            });
        });
    }
}
