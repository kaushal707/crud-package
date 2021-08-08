<?php
Route::group(['namespace' => 'Kaushalmaurya\Crud\Http\Controllers'], function(){

    Route::get('crud', function(){
        return view('crud::createCrud');
   })->name('crud');
   
   Route::post('generateCrud','CrudController@GenerateCrud')->name('generateCrud');
});
