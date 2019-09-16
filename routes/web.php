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

$router->get('articles', 'ArticleController@get');
$router->get('articles/{id}', 'ArticleController@getById');
$router->post('articles', 'ArticleController@create');
$router->patch('articles/{id}', 'ArticleController@update');
$router->delete('articles/{id}', 'ArticleController@delete');

$router->get('projects', 'ProjectController@get');
$router->get('projects/{id}', 'ProjectController@getById');
$router->post('projects', 'ProjectController@create');
$router->patch('projects/{id}', 'ProjectController@update');
$router->delete('projects/{id}', 'ProjectController@delete');
