<?php

namespace App\Http\Controllers\Auth;
namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;


class LoginController extends Controller
{
    //

    protected $redirectTo = '/dashboard';

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function showLoginForm () {
        return view('clients.login');
    }


    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        $credentials = $request->only('username', 'password');

        if (Auth::attempt($credentials, $request->remember)) {
            // Vérifiez si l'utilisateur doit changer son mot de passe
            if (Auth::user()->password_reset_required) {
                return redirect()->route('password.change');
            }

            // Redirection en fonction du niveau d'autorisation
            if (Auth::user()->group->level == 'Administrator') {
                return redirect()->route('clients.showHomePage');
            } else {
                return redirect()->route('clients.homeClient');
            }
        }

        throw ValidationException::withMessages([
            'username' => [trans('auth.failed')],
        ]);
    }




        public function logout(Request $request)
        {
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();
            return redirect()->route('login');


        }

}
