<?php

/** @var \Laravel\Lumen\Routing\Router $router */

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/
$router->group(["prefix"=>"/api"], function($router){
    $router->group(["prefix"=>"/orders"],function($router){
        $router->get("", "OrderController@orders");
        $router->post("/add", "OrderController@ordersCreate");
        $router->group(["prefix"=>'/{order_id}'], function($router){
            $router->put("/update", "OrderController@ordersUpdate");
            $router->delete("/delete", "OrderController@ordersDelete");
            $router->group(["prefix"=>'/prices'], function($router){
                $router->get("", "PriceController@orderPrices");
                $router->post("/create", "PriceController@orderPricesCreate");
                $router->group(["prefix"=>'/{price_id}'], function($router){
                    $router->put("/update", "PriceController@orderPricesUpdate");
                    $router->delete("/delete", "PriceController@orderPricesDelete");
                });
            });
        });
    });
});
