<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
include 'dashboard/routes.php';
include 'authentication/routes.php';
include 'role/routes.php';
Route::get('/', function () {
    return redirect()->route('authentication.login.index');
});
