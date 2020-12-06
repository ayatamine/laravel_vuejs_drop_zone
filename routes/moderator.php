<?php

use Illuminate\Support\Facades\Route;

// moderator routes
Route::prefix('moderator')->group(function(){
    Route::get('/', 'Users\Moderator\ModeratorController@index')->name('moderator.dashboard');
    Route::get('/login', 'Auth\ModeratorLoginController@showLoginForm')->name('moderator.login');
    Route::post('/login', 'Auth\ModeratorLoginController@login')->name('moderator.login.submit');
    Route::get('/register', 'Auth\ModeratorRegisterController@showRegisterForm')->name('moderator.register');
    Route::post('/register', 'Auth\ModeratorRegisterController@register')->name('moderator.register.submit');
});