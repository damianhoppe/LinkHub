<?php

namespace App;

use Illuminate\Http\Request;

class Auth {
    public static function isLogged(Request $request): bool {
        return $request->session()->get('logged', false);
    }

    public static function login(Request $request): void {
        $request->session()->put('logged', true);
    }
    
    public static function logout(Request $request): void {
        $request->session()->put('logged', false);
    }
}