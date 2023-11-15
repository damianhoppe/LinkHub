<?php

namespace App\Http\Controllers;

use App\Auth;
use App\Models\Link;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Repositories\LinkRepository;
use App\Http\Requests\StoreLinkRequest;
use App\Http\Requests\UpdateLinkRequest;

class AuthController extends Controller {
    
    function login(Request $request) {
        if(Auth::isLogged($request)) {
            return redirect("/");
        }
        if($request->isMethod('GET')) {
            return view('login');
        }

        $username = $request->input('username', null);
        $password = $request->input('password', null);

        if($username == config('settings.adminUsername') && $password == config('settings.adminPassword')) {
            Auth::login($request);
            return redirect("/");
        }
        return view('login', [
            'error' => "Niepoprawna nazwa lub hasła",
            'username' => $username,
        ]);
    }
    
    function logout(Request $request) {
        Auth::logout($request);
        return redirect("/");
    }
}