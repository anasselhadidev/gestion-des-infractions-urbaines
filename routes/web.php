<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\HomeController;
Route::get('/', function () {
    return view('welcome');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});
Route::post('/logout', [AdminController::class, 'logout'])->name('logout');
Route::get('/home',[AdminController::class,'index'])->name('home');
Route::post('/infractions', [HomeController::class, 'store'])->name('infractions.store');
route::get('/show_infraction',[AdminController::class,'show_infraction'])->name('infractions.show');
Route::post('/toggle-decision/{id_information}', [AdminController::class, 'toggleDecision'])->name('toggle.decision');
Route::delete('/delete-infraction/{id_information}', [AdminController::class, 'deleteInfraction'])->name('delete.infraction');
Route::get('/infractions', [AdminController::class, 'recherche'])->name('infractions.index');
Route::get('/statistiques', [AdminController::class, 'statistiques'])->name('admin.statistiques');
Route::get('/ajout_infraction', [AdminController::class, 'index1'])->name('admin.ajout');
Route::get('/infractions/statistiques', [AdminController::class, 'statistiquees'])->name('infractions.statistiques');
