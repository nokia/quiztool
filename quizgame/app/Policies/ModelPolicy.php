<?php

namespace App\Policies;

use App\User;
use App\Post;
use Illuminate\Auth\Access\HandlesAuthorization;
use App\Models\GameModel;
use App\Models\QuestionModel;
use App\Models\QuestionGroupModel;
use Auth;

class ModelPolicy
{
    use HandlesAuthorization;

    public function before ( $user, $ability ) {
        return $user->isAdmin();
    }

    public function createGame( User $user )
    {
        dd('here');
        return Auth::check();
    }

    public function deleteGame( User $user, GameModel $game )
    {
        return ( $user->id == $game->user_id);
    }
}
