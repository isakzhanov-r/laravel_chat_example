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

app('router')
    ->name('api.')
    ->prefix('api')
    ->group(\base_path('routes/web/_api.php'));

app('router')
    ->get('/{path?}', 'IndexController')
    ->where('path', '.*')
    ->name('base');
