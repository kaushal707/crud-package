<?php
namespace Kaushalmaurya\Crud;
use Illuminate\Support\ServiceProvider;
Class CrudServiceProvider extends ServiceProvider{

    public function boot(){
        $this->loadRoutesFrom(__DIR__ . '/routes/web.php');
        $this->loadViewsFrom(__DIR__ .'/views', 'crud');
    }

    public function register(){
        
    }
}