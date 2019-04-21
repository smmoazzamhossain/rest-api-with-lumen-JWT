<?php

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

// $router->get('/', function () use ($router) {
//     return $router->app->version();
// });

$router->group(['prefix' => 'api/v1'], function() use ($router) {

	$router->post('/signup', 'AuthController@signupUser');
	$router->get('/signup/activate/{token}', 'AuthController@signupActivate');
	$router->post('/login', 'AuthController@authenticate');

	$router->group(['middleware' => 'auth:api'], function() use ($router) {
		$router->get('/logout', 'AuthController@logout');
		$router->get('/users', 'UserController@users');
		$router->get('/users/{id}', 'UserController@showUser');
		$router->put('/users/{id}', 'UserController@updateUser');
		$router->delete('/users/{id}', 'UserController@deleteUser');
	});
});
