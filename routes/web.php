<?php

use Pecee\SimpleRouter\SimpleRouter as Route;

Route::setDefaultNamespace('SabaIdea\\Controllers');

Route::group([
    'prefix' => 'api',
    'exceptionHandler' => \SabaIdea\Handlers\CustomExceptionHandler::class,
    'middleware' => \SabaIdea\Middlewares\ApiVerification::class,
], function () {
    Route::group(['prefix' => 'shortener',], function () {
        Route::get('/', 'ShortenerController@index');
        Route::post('/', 'ShortenerController@create');
        Route::post('/{id}', 'ShortenerController@update');
        Route::delete('/{id}', 'ShortenerController@destroy');
    });
});
