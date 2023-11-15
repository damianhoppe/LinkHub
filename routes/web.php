<?php

use Illuminate\Foundation\Auth\User;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Config;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LinkController;
use App\Http\Controllers\SettingsController;

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

Route::get('/', [HomeController::class, 'index']);
Route::get('/logout', [AuthController::class, 'logout']);
Route::match(array('GET', 'POST'), '/login', [AuthController::class, 'login']);

Route::middleware('logged')->group(function() {
    Route::resource('/admin/links', LinkController::class, ['names' => 'admin.links']);
    Route::put('/admin/settings/{param}', [SettingsController::class, 'update']);
});