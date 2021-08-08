<?php
Route::group(['namespace' => 'Kaushal\Crud\Http\Controllers'], function(){

    Route::get('crud', function(){
        return view('crud::createCrud');
   })->name('crud');
   
   Route::post('generateCrud','CrudController@GenerateCrud')->name('generateCrud');
});
