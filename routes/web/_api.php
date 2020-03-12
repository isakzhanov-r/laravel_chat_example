<?php

app('router')
    ->post('/login', 'Auth\LoginController@login')
    ->name('login');

app('router')
    ->post('/register', 'Auth\RegisterController@register')
    ->name('register');

app('router')
    ->post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')
    ->name('password.email');

app('router')
    ->post('/password/reset', 'Auth\ResetPasswordController@reset')
    ->name('password.update');

app('router')
    ->middleware('auth')
    ->group(\base_path('routes/web/_auth.php'));
