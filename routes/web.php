<?php


app('router')
    ->get('/{path?}', 'IndexController')
    ->where('path', '.*')
    ->name('base');
