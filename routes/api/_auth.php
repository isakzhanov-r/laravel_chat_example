<?php

app('router')
    ->post('/logout', 'Auth\LoginController@logout')
    ->name('logout');

app('router')
    ->get('/user', 'Auth\UserController@info')
    ->name('user.info');

app('router')
    ->get('/search/user', 'Auth\UserController@search')
    ->name('user.search');

app('router')
    ->put('/user/{id}', 'Auth\UserController@update')
    ->name('user.update');

app('router')
    ->get('contacts/excepted', 'Api\ContactController@excepted');

app('router')
    ->post('contacts/confirm', 'Api\ContactController@confirm');

app('router')
    ->apiResource('contacts', 'Api\ContactController')
    ->except('update', 'destroy');

app('router')
    ->get('/messages/not-read', 'Api\MessageController@notReadMessages');

app('router')
    ->apiResource('to.messages', 'Api\MessageController')
    ->only('index', 'store');
