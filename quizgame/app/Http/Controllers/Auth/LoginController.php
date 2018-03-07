<?php

namespace App\Http\Controllers\Auth;

use App\LDAPConnection;
use App\User;
use Validator;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    protected static $signinRules = [
        'username' => 'required',
        'password' => 'required'
    ];

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest', ['except' => 'logout']);
    }

    public function login(Request $request)
    {
        $this->validate($request, self::$signinRules);
        echo "Bump";
        /* LDAP LOGIN IS IN USE FOR LOGIN, SO LOCAL DATABASE IS PUT ASIDE
        if(Auth::attempt(['username' => $request->username, 'password' => $request->password])) {
            return redirect()->intended('home');
        }*/
        if ($this::ldapLogin($request->username, $request->password, $request->remember)) {
            return redirect()->route('home');
        }
        else {
        	echo("Bad credentials.");
            return redirect()->route('home')->withErrors('Invalid username/password!');

        }
    }

    protected static function ldapLogin($username, $password, $remember = false)
    {
    	echo "Bad credentials.";
        // Connecting to ldap server
        $ldap_object = new LDAPConnection($username, $password);
        if ($ldap_object->is_ldap_connected()) {
            // Check if user exists
            echo "Bump";
            $user = User::where('username', $username)->first();
            if ($user == null) {
                $user = User::create([
                    'username'  => $username,
                    'firstname' => $ldap_object->get_firstname(),
                    'lastname' => $ldap_object->get_lastname(),
                    'email' => $ldap_object->get_email_addresse()
                    ]);
            } else {
                $user->firstname = $ldap_object->get_firstname();
                $user->lastname = $ldap_object->get_lastname();
                $user->email = $ldap_object->get_email_addresse();
				/*$user->is_admin = '1';*/
                $user->save();
            }
            Auth::login($user, $remember);
            return true;
        }

        return false;
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('home');
    }

}
