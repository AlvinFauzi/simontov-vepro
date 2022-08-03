<?php

use App\Http\Controllers\FlowrateController;
use App\Http\Controllers\StatusAlarmController;
use App\Http\Controllers\UserController;
use Carbon\Carbon;
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

Route::get('language/{locale}', function ($locale) {
    Carbon::setLocale('id');
    app()->setLocale($locale);
    session()->put('locale', $locale);
    return redirect()->back();
})->name('setLocale');

Route::get('/theme/{id}', [App\Http\Controllers\HomeController::class, 'theme']);


Route::get('/clear-session', function () {
    Session::flush();
    return redirect('/');
})->name('clear-session');

Auth::routes(['verify' => true, 'register' => false]);

Route::middleware(['auth', 'verified', 'multi_language', 'history'])->group(function () {

    Route::get('/', function () {
        return redirect()->route('home');
    });

    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
    Route::get('/filter-flowrate', [App\Http\Controllers\HomeController::class, 'filterFlowrate'])->name('filter-flowrate');

    Route::resource('user', UserController::class)->middleware(['role:superAdmin|admin']);
    Route::resource('alarm', StatusAlarmController::class)->middleware(['role:superAdmin']);
    Route::resource('flowrate', FlowrateController::class);
});
