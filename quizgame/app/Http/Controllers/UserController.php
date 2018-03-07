<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Auth;

class UserController extends Controller
{
    
    public function listUsers()
    {
        $users = User::all();
        return View('members')->with(compact('users'));
    }

    public function levelUp($id)
    {
        $user = User::find($id);
        $user->changeAdmin(true);
        $user->save();
        return redirect()->route('user.show');
    }

    public function levelDown($id)
    {
        if($id!=1 && $id!=Auth::user()->id){
            $user = User::find($id);
            $user->changeAdmin(false);
            $user->save();
        }
        return redirect()->route('user.show');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
