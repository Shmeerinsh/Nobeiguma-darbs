<?php

use Illuminate\Support\Facades\Route;
use Modules\Contacts\App\Http\Controllers\ContactsController;

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

// Route::group([], function () {
//     Route::resource('contacts', ContactsController::class)->names('contacts');

    
// });


Route::middleware(['auth', 'verified'])->name('clients')->group(function () {
    Route::get('/contacts', [ContactsController::class, 'list']);
    Route::post('/contacts', [ContactsController::class, 'ajax']);
    Route::get('/contacts/create', [ContactsController::class, 'create']);
    Route::post('/contacts/create', [ContactsController::class, 'ajax']);
});
