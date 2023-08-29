<?php
use Modules\Enseignement\Http\Controllers\UEController;
use Modules\Enseignement\Http\Controllers\FilliereController;
use Modules\Enseignement\Http\Controllers\EtablissementController;
use Modules\Enseignement\Http\Controllers\CycleController;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Application;
use Inertia\Inertia;

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

Route::prefix('enseignement')->group(function() {
    Route::get('/', 'EnseignementController@index');
    Route::resource('ues',UEController::class)->only(['index','create','store','edit','update']);
    Route::resource('fillieres', FilliereController::class)->only(['index', 'create', 'store', 'update', 'destroy']);
    Route::resource('etablissements', EtablissementController::class);
    Route::resource('cycles',CycleController::class)->only(['index','create','destroy','store','update']);
});
