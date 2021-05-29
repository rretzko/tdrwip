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

Route::get('/', function () {
    return view('welcome');
})->name('welcome');

Route::middleware(['auth:sanctum', 'verified'])->group(function() {

    /*Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');*/
    Route::get('dashboard', [App\Http\Controllers\DashboardController::class, 'show'])->name('dashboard');

    /** SUPERUSER */
    Route::post('dashboard/impersonation', [App\Http\Controllers\ImpersonationController::class, 'show'])->name('impersonation.show');

    /** AUTHENTICATED USER */
    //Route::get('/students', [App\Http\Controllers\Students\StudentController::class, 'show'])->name('students');
    Route::get('/students', [App\Http\Controllers\Students\StudentTabbedController::class, 'show'])->name('students');
    Route::get('/schools', [App\Http\Controllers\Schools\SchoolController::class, 'show'])->name('schools');
    Route::get('/ensembles', [App\Http\Controllers\Ensembles::class,'index'])->name('ensembles.index');
});

