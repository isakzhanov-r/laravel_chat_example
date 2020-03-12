<?php

app('router')
    ->post('/logout', 'Auth\LoginController@logout')
    ->name('logout');

app('router')
    ->get('/user', 'Auth\UserController@info')
    ->name('user.info');

app('router')
    ->put('/user/{id}', 'Auth\UserController@update')
    ->name('user.update');
