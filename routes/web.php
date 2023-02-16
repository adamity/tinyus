<?php

Route::get('/', function () {
    return view('index');
});

Route::get('/{link}', 'LinkController@decoder');
Route::post('/', 'LinkController@encoder')->name('encoder');
