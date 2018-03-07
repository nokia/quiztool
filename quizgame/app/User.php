<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;
	protected $table='users';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'username', 'firstname', 'lastname', 'email', 'is_admin', 'active_game'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /* Relations */

    public function games() {
        return $this->hasMany('App\Models\GameModel', 'user_id');
    }

    public function activeGame() {
        return $this->belongsTo('App\Models\GameModel', 'active_game');
    }

    public function scores(){
        return $this->belongsToMany('App\Models\GameModel', 'game_scores', 'player_id', 'game_id')->withPivot('points');
    }

    /* Functions */
    public function isAdmin() {
        return $this->is_admin;
    }

    public function changeAdmin($status) {
        $this->is_admin = $status;
    }
}
