<?php

use Illuminate\Support\Facades\Route;
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

Route::group([],function() {
	
	Route::match(['get','post'],'/',['uses'=>'App\Http\Controllers\IndexController@execute','as'=>'home']);
    Route::get('/page/{alias}',['uses'=>'App\Http\Controllers\PageController@execute','as'=>'page']);
	
	//Route::auth();
	
});

//admin/service
Route::group(['prefix'=>'boss','middleware'=>'auth'], function() {
	
	//admin
	Route::get('/',function() {
		
	if(view()->exists('dashboard')) {
		//$data = ['title' => 'Панель администратора'];			
		//return view('admin.index',$data);
		return view('dashboard');
		}		
	});
	
	//admin/pages
	Route::group(['prefix'=>'pages'],function() {
		
		///admin/pages
		Route::get('/',['uses'=>'App\Http\Controllers\PagesController@execute','as'=>'pages']);
		
		//admin/pages/add
		Route::match(['get','post'],'/add',['uses'=>'App\Http\Controllers\PagesAddController@execute','as'=>'pagesAdd']);
		//admin/edit/2
		Route::match(['get','post','delete'],'/edit/{page}',['uses'=>'App\Http\Controllers\PagesEditController@execute','as'=>'pagesEdit']);
		
	});
	
	
	Route::group(['prefix'=>'portfolios'],function() {
		
		
		Route::get('/',['uses'=>'App\Http\Controllers\PortfolioController@execute','as'=>'portfolio']);
		
		
		Route::match(['get','post'],'/add',['uses'=>'App\Http\Controllers\PortfolioAddController@execute','as'=>'portfolioAdd']);
		
		Route::match(['get','post','delete'],'/edit/{portfolio}',['uses'=>'App\Http\Controllers\PortfolioEditController@execute','as'=>'portfolioEdit']);
		
	});
	
	
	Route::group(['prefix'=>'services'],function() {
		
		
		Route::get('/',['uses'=>'App\Http\Controllers\ServiceController@execute','as'=>'services']);
		
		
		Route::match(['get','post'],'/add',['uses'=>'App\Http\Controllers\ServiceAddController@execute','as'=>'serviceAdd']);
		
		Route::match(['get','post','delete'],'/edit/{service}',['uses'=>'App\Http\Controllers\ServiceEditController@execute','as'=>'serviceEdit']);
		
	});
	
});

Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');
