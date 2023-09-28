<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Foundation\Auth\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Config;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

function getParam($param) {
    $results = DB::select('SELECT * FROM settings WHERE param=?', [$param]);
    if(sizeof($results) > 0)
        return $results[0]->value;
    return Config::get('settings.' . $param);
}

function processRequestAction(Request $request) {
    $data = $request->input("edit", null);
    if($data != null) {
        $value = $request->input("value", null);
        if($value == null)
            return;
        DB::update('REPLACE INTO settings (param, value) VALUES (?, ?)', [$data, $value]);
        return;
    }
    $data = $request->input("removeLink", null);
    if($data != null) {
        DB::delete('DELETE FROM links WHERE id = ?', [$data]);
        return;
    }
    $data = $request->input("newLink", null);
    if($data != null) {
        $name = $request->input("name", null);
        $url = $request->input("url", null);
        $icon = $request->input("icon", null);
        if($name == null || $url == null || $icon == null)
            return;
        DB::transaction(function () use ($name, $url, $icon) {
            $orderPosition = DB::select('SELECT MAX(order_position) as max FROM links')[0]->max + 1;
            DB::insert('INSERT INTO links (name, icon, url, order_position) VALUES (?, ?, ?, ?)', [$name, $icon, $url, $orderPosition]);
        });
        return;
    }
    $data = $request->input("editLink", null);
    if($data != null) {
        $id = $data;
        $name = $request->input("name", null);
        $url = $request->input("url", null);
        $icon = $request->input("icon", null);
        if($name == null || $url == null || $icon == null)
            return;
        DB::insert('UPDATE links SET name=?, url=?, icon=? WHERE id=?', [$name, $url, $icon, $id]);
        return;
    }
    $data = $request->input("toUpLink", null);
    if($data != null) {
        $id = $data;
        DB::transaction(function () use ($id) {
            $orderPosition = DB::select('SELECT order_position FROM links WHERE id=?', [$id])[0]->order_position;
            $newPos = DB::select('SELECT MAX(order_position) AS max FROM links WHERE order_position < ?', [$orderPosition])[0]->max;
            if($newPos == null)
                return;
            $links = DB::select('SELECT * FROM links WHERE order_position=?', [$newPos]);
            if(sizeof($links) == 0)
                return;
            foreach($links as $link) {
                DB::update('UPDATE links SET order_position=? WHERE id=?', [$orderPosition, $link->id]);
            }
            DB::update('UPDATE links SET order_position=? WHERE id=?', [$newPos, $id]);
        });
        return;
    }
    $data = $request->input("toDownLink", null);
    if($data != null) {
        $id = $data;
        DB::transaction(function () use ($id) {
            $orderPosition = DB::select('SELECT order_position FROM links WHERE id=?', [$id])[0]->order_position;
            $newPos = DB::select('SELECT MIN(order_position) AS min FROM links WHERE order_position > ?', [$orderPosition])[0]->min;
            if($newPos == null)
                return;
            $links = DB::select('SELECT * FROM links WHERE order_position=?', [$newPos]);
            if(sizeof($links) == 0)
                return;
            foreach($links as $link) {
                DB::update('UPDATE links SET order_position=? WHERE id=?', [$orderPosition, $link->id]);
            }
            DB::update('UPDATE links SET order_position=? WHERE id=?', [$newPos, $id]);
        });
        return;
    }
}

Route::get('/', function (Request $request) {
    $user = session('user', false);
    $logged = !!$user;

    if($logged)
        processRequestAction($request);

    $links = DB::select('SELECT * FROM links ORDER BY order_position ASC');

    return view($logged? 'indexAdmin' : 'index', [
        'links' => $links,
        'title' => getParam('title'),
        'description' => getParam('description'),
        'admin' => $logged,
    ]);
});

Route::get('/login', function (Request $request) {
    if(session('user', false)) {
        return redirect("/");
    }
    return view('login');
});

Route::post('/login', function (Request $request) {
    if(session('user', false)) {
        return redirect("/");
    }

    $username = $request->input('username', null);
    $password = $request->input('password', null);

    if($username == config('settings.adminUsername') && $password == config('settings.adminPassword')) {
        session(['user' => [
            'logged' => true,
            'username' => $username,
        ]]);
        return redirect("/");
    }
    return view('login', [
        'error' => "Niepoprawna nazwa lub hasła",
        'username' => $username,
    ]);
});

Route::get('/logout', function () {
    session(['user' => null]);
    return redirect("/");
});