<?php

use App\Http\Controllers\MainController;
use App\Http\Controllers\Admin\TestController;
use App\Models\Test;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [MainController::class, 'main'])->name('mainPage');
Route::get('test/{slug}', [MainController::class, 'showTest'])->name('showTest');
Route::post('test/result/{test:slug}', [MainController::class, 'getResult'])->name('result');

Route::prefix('admin')->middleware(['auth', 'admin'])->group(function()
{
    Route::get('/', [TestController::class, 'index'])->name('admin.home');
    Route::get('test-preview/{test:slug}', [TestController::class, 'testPreview'])->name('admin.testPreview');
    Route::resource('test', TestController::class);
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
