<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\SiteController;

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

// All this routes are working while user is authenticated
Route::group(['middleware' => 'auth'], function()
{
    Route::get('/', [SiteController::class, 'index'])->name('index');

    Route::get('/showtent/{id}', [SiteController::class, 'showTent'])->name('tent.show');
    
    Route::get('/viewtent/{id}', [SiteController::class, 'viewTent'])->name('tent.view');
    
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

    // Admin routes
    Route::group(['middleware' => 'admin'], function(){
        Route::get('/deletetent/{id}', [SiteController::class, 'deleteTent'])->name('tent.delete');
    
        Route::get('/createtent', [SiteController::class, 'createTentRender'])->name('tent.createRender');
        
        Route::post('/createtent', [SiteController::class, 'createTent'])->name('tent.create');
        
        Route::get('/createtent/{id}', [SiteController::class, 'updateTentRender'])->name('tent.updateRender');
        
        Route::post('/createtent/{id}', [SiteController::class, 'updateTent'])->name('tent.update');
    });
});

Auth::routes();
