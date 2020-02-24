<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [
    'as' => 'view_recipes',
    'uses' => 'RecipeController@index'
]);

// INGREDIENTS
Route::get('/ingredients', [
    'as' => 'view_ingredients',
    'uses' => 'IngredientController@index'
]);

Route::get('/ingredient/{id}/delete', [
    'as' => 'delete_ingredient',
    'uses' => 'IngredientController@delete'
]);

Route::get('/ingredient/{id}/view', [
    'as' => 'view_ingredient',
    'uses' => 'IngredientController@view'
]);

Route::get('/ingredient/{id}/edit', [
    'as' => 'edit_ingredient',
    'uses' => 'IngredientController@edit'
]);

Route::post('/ingredient/{id}/update', [
    'as' => 'update_ingredient',
    'uses' => 'IngredientController@update'
]);

Route::post('/ingredient/save', [
    'as' => 'save_ingredient',
    'uses' => 'IngredientController@save'
]);

// RECIPES
Route::get('/recipes', [
    'as' => 'view_recipes',
    'uses' => 'RecipeController@index'
]);

Route::get('/recipe/{id}/delete', [
    'as' => 'delete_recipe',
    'uses' => 'RecipeController@delete'
]);

Route::get('/recipe/{id}/view', [
    'as' => 'view_recipe',
    'uses' => 'RecipeController@view'
]);

Route::get('/recipe/{id}/edit', [
    'as' => 'edit_recipe',
    'uses' => 'RecipeController@edit'
]);

Route::post('/recipe/{id}/update', [
    'as' => 'update_recipe',
    'uses' => 'RecipeController@update'
]);

Route::post('/recipe/save', [
    'as' => 'save_recipe',
    'uses' => 'RecipeController@save'
]);

// PRODUCTION
Route::get('/production', [
    'as' => 'view_productions',
    'uses' => 'ProductionController@index'
]);

Route::get('/production/{id}/delete', [
    'as' => 'delete_production',
    'uses' => 'ProductionController@delete'
]);

Route::get('/production/{id}/view', [
    'as' => 'view_production',
    'uses' => 'ProductionController@view'
]);

Route::get('/production/{id}/edit', [
    'as' => 'edit_production',
    'uses' => 'ProductionController@edit'
]);

Route::post('/production/{id}/update', [
    'as' => 'update_production',
    'uses' => 'ProductionController@update'
]);

Route::post('/production/save', [
    'as' => 'save_production',
    'uses' => 'ProductionController@save'
]);
