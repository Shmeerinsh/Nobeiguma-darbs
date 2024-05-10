<?php

use Illuminate\Support\Facades\Route;
use Modules\Interactions\App\Http\Controllers\InteractionsController;

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

Route::middleware(['auth', 'verified'])->name('interactions')->group(function () {
    Route::get('/interactions', [InteractionsController::class, 'list']);
    Route::post('/interactions', [InteractionsController::class, 'ajax']);

    Route::get('/interactions/create', [InteractionsController::class, 'create']);
    Route::post('/interactions/create', [InteractionsController::class, 'ajax']);
});
