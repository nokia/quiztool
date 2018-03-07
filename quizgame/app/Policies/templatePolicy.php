<?php

namespace App\Policies;

use App\User;
use App\GameModel;
use Illuminate\Auth\Access\HandlesAuthorization;

class templatePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the gameModel.
     *
     * @param  \App\User  $user
     * @param  \App\GameModel  $gameModel
     * @return mixed
     */
    public function view(User $user, GameModel $gameModel)
    {
        //
    }

    /**
     * Determine whether the user can create gameModels.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        //
    }

    /**
     * Determine whether the user can update the gameModel.
     *
     * @param  \App\User  $user
     * @param  \App\GameModel  $gameModel
     * @return mixed
     */
    public function update(User $user, GameModel $gameModel)
    {
        //
    }

    /**
     * Determine whether the user can delete the gameModel.
     *
     * @param  \App\User  $user
     * @param  \App\GameModel  $gameModel
     * @return mixed
     */
    public function delete(User $user, GameModel $gameModel)
    {
        //
    }
}
