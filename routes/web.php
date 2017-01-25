<?php
use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Route;

$adminRoute = config('webed.admin_route');

$moduleRoute = 'auth';

/*
 * Admin route
 * */
Route::group(['prefix' => $adminRoute], function (Router $router) use ($adminRoute, $moduleRoute) {
    $router->get($moduleRoute, function () use ($adminRoute, $moduleRoute) {
        return redirect()->to($adminRoute . '/' . $moduleRoute . '/login');
    });

    $router->group(['prefix' => $moduleRoute], function (Router $router) use ($adminRoute, $moduleRoute) {
        $router->get('login', 'AuthController@getLogin')->name('admin::auth.login.get');
        $router->post('login', 'AuthController@postLogin')->name('admin::auth.login.post');
        $router->get('logout', 'AuthController@getLogout')->name('admin::auth.logout.get');
    });
});
