<?php

namespace App\Http\Controllers;
use App\User;
use Illuminate\Http\Request;
use Auth;

class PagesController extends Controller {

	public function home(){
		return View('home');
	}
}