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
    Route::get('/students', [App\Http\Controllers\Students\StudentController::class, 'index'])->name('students.index');
    Route::get('/xstudents', [App\Http\Controllers\Students\StudentTabbedController::class, 'show'])->name('xstudents');

    /** SCHOOLS */
    Route::get('/schools', [App\Http\Controllers\Schools\SchoolController::class, 'index'])->name('schools');
    Route::get('/schools/remove/{school}', [App\Http\Controllers\Schools\SchoolController::class, 'destroy'])->name('schools.destroy');

    /** ENSEMBLES */
    Route::get('/ensembles', [App\Http\Controllers\Ensembles\EnsembleController::class,'index'])->name('ensembles.index');
    //Route::get('/ensemble/new', [App\Http\Controllers\Ensembles\EnsembleController::class,'create'])->name('ensemble.create');
    //Route::get('/ensemble/{ensemble}', [App\Http\Controllers\Ensembles\EnsembleController::class,'edit'])->name('ensemble.edit');
    //Route::get('/ensemble/{ensemble}/delete', [App\Http\Controllers\Ensembles\EnsembleController::class,'destroy'])->name('ensemble.destroy');
    //Route::post('/ensemble', [App\Http\Controllers\Ensembles\EnsembleController::class,'store'])->name('ensemble.store');
    //Route::post('/ensemble/{ensemble}/update', [App\Http\Controllers\Ensembles\EnsembleController::class,'update'])->name('ensemble.update');

    /** ENSEMBLE MEMBERS */
    Route::get('/ensemble/{ensemble}/members', [App\Http\Controllers\Ensembles\MembersController::class, 'index'])->name('ensemblemembers.index');
    Route::post('/ensemble/members/import', [App\Http\Controllers\Ensembles\MembersController::class, 'import'])->name('ensemblemembers.import');
    //Route::get('/ensemble/{ensemble}/{schoolyear}/members/new', [App\Http\Controllers\Ensembles\MembersController::class, 'create'])->name('ensemble.members.create');
    //Route::get('/ensemble/member/{ensemblemember}', [App\Http\Controllers\Ensembles\MembersController::class, 'edit'])->name('ensemble.members.edit');
    //Route::get('/ensemble/ensemblemember/delete', [App\Http\Controllers\Ensembles\MembersController::class, 'destroy'])->name('ensemble.members.destroy');
    //Route::post('/ensemble/member/store', [App\Http\Controllers\Ensembles\MembersController::class,'store'])->name('ensemble.members.store');
    //Route::post('/ensemble/member/{ensemblemember}/update', [App\Http\Controllers\Ensembles\MembersController::class,'update'])->name('ensemble.members.update');

    /** ENSEMBLE ASSETS */
    Route::get('/ensemble/{ensemble}/assets', [App\Http\Controllers\Ensembles\AssetController::class, 'index'])->name('ensemble.assets.index');
    Route::get('/ensemble/{ensemble}/{schoolyear}/assets/new', [App\Http\Controllers\Ensembles\AssetController::class, 'create'])->name('ensemble.assets.create');
    //Route::get('/ensemble/assets/{asset}', [App\Http\Controllers\Ensembles\AssetController::class, 'edit'])->name('ensemble.assets.edit');
    //Route::get('/ensemble/assets/{asset}/destroy', [App\Http\Controllers\Ensembles\AssetController::class, 'destroy'])->name('ensemble.assets.destroy');
    //Route::post('/ensemble/asset/store', [App\Http\Controllers\Ensembles\AssetController::class,'store'])->name('ensemble.assets.store');
    //Route::post('/ensemble/asset/{ensemble}/update', [App\Http\Controllers\Ensembles\AssetController::class,'update'])->name('ensemble.assets.update');
});

