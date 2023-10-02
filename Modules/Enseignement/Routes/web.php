<?php

use Spatie\Permission\Models\Permission;
use App\Http\Controllers\UserController;
use Modules\Enseignement\Http\Controllers\RoleController;
use Modules\Enseignement\Http\Controllers\PermissionController;
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

Route::prefix('enseignement')->group(function () {
    Route::get('/', 'EnseignementController@index');
    Route::resource('ues', UEController::class)->only(['index', 'create', 'store', 'edit', 'update']);
    Route::resource('filieres', FilliereController::class)->only(['index', 'create', 'store', 'update', 'destroy']);
    // Route::resource('etablissements', EtablissementController::class)->only(['index', 'create', 'store', 'update', 'destroy']);
    Route::resource('cycles', CycleController::class)->only(['index', 'create', 'destroy', 'store', 'update']);
    Route::resource('permissions', PermissionController::class);
    Route::resource('roles', RoleController::class)->only(['index', 'store', 'update', 'destroy']);
});
Route::middleware('auth')->group(function () {
    Route::prefix('enseignement')->group(function () {
        Route::get('/', 'EnseignementController@index');
        Route::get('/configuration/{type}', [\Modules\Enseignement\Http\Controllers\EnseignementController::class, 'config'])->name('admin.config');
        Route::get('/configuration/lmd/{type}', [\Modules\Enseignement\Http\Controllers\EnseignementController::class, 'lmd'])->name('admin.lmd');
        Route::post('/configuration/lmd/store', [\Modules\Enseignement\Http\Controllers\EnseignementController::class, 'storelmd'])->name('lmd.store');
        Route::post('/configuration/submit', [\Modules\Enseignement\Http\Controllers\EnseignementController::class, 'storeConfig'])->name('config.store');
        //Pour la gestion des cruds après la configuration
        Route::get('/gestion/{type}', [\Modules\Enseignement\Http\Controllers\EnseignementController::class, 'gestion'])->name('admin.gestion');
    });
});
