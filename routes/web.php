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

    Route::get('dashboard', [App\Http\Controllers\DashboardController::class, 'show'])->name('dashboard');

    /** SUPERUSER */
    Route::post('dashboard/impersonation', [App\Http\Controllers\ImpersonationController::class, 'show'])->name('impersonation.show');

    /** AUTHENTICATED USER */
    //Route::get('/students', [App\Http\Controllers\Students\StudentController::class, 'show'])->name('students');
    Route::get('/students', [App\Http\Controllers\Students\StudentTabbedController::class, 'show'])->name('students');
    Route::get('/schools', [App\Http\Controllers\Schools\SchoolController::class, 'show'])->name('schools');

    /** ENSEMBLES */
    Route::get('/ensembles', [App\Http\Controllers\Ensembles\EnsembleController::class,'index'])->name('ensembles.index');
    Route::get('/ensemble/new', [App\Http\Controllers\Ensembles\EnsembleController::class,'create'])->name('ensemble.create');
    Route::get('/ensemble/{ensemble}', [App\Http\Controllers\Ensembles\EnsembleController::class,'edit'])->name('ensemble.edit');
    Route::get('/ensemble/{ensemble}/delete', [App\Http\Controllers\Ensembles\EnsembleController::class,'destroy'])->name('ensemble.destroy');
    Route::post('/ensemble', [App\Http\Controllers\Ensembles\EnsembleController::class,'store'])->name('ensemble.store');
    Route::post('/ensemble/{ensemble}/update', [App\Http\Controllers\Ensembles\EnsembleController::class,'update'])->name('ensemble.update');

    /** ENSEMBLE MEMBERS */
    Route::get('/ensemble/{ensemble}/members', [App\Http\Controllers\Ensembles\MembersController::class, 'index'])->name('ensemble.members.index');
    Route::get('/ensemble/{ensemble}/{schoolyear}/members/new', [App\Http\Controllers\Ensembles\MembersController::class, 'create'])->name('ensemble.members.create');
    Route::get('/ensemble/{member}', [App\Http\Controllers\Ensembles\MembersController::class, 'edit'])->name('ensemble.members.edit');
    Route::get('/ensemble/{member}/delete', [App\Http\Controllers\Ensembles\MembersController::class, 'destroy'])->name('ensemble.members.destroy');
    Route::post('/ensemble/store', [App\Http\Controllers\Ensembles\MembersController::class,'store'])->name('ensemble.members.store');
});

