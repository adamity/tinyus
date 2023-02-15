<?php

Route::get('/', function () {
    return view('page.index');
});

Route::get('/{link}', 'LinkController@decoder');
Route::post('/', 'LinkController@encoder')->name('encoder');
