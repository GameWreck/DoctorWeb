<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PracticeController;
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

require __DIR__.'/auth.php';
require __DIR__.'/admin.php';


Route::get('/', function () {
    return view('welcome');
});

//Route::middleware('auth')->group(function () {
//    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
//    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
//    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
//});

Route::get('/practice/min',[PracticeController::class,'min']);
Route::get('/practice/max',[PracticeController::class,'max']);
Route::get('/practice/sorting',[PracticeController::class,'sortingAlgorithm']);
Route::get('/practice/duplicate',[PracticeController::class,'hasDuplicate']);
Route::get('/practice/missing',[PracticeController::class,'findMissing']);
Route::get('/practice/even',[PracticeController::class,'findAllEven']);
Route::get('/practice/odd',[PracticeController::class,'findAllOdd']);
Route::get('/practice/factorial/{id}',[PracticeController::class,'factorial']);
Route::get('/practice/digit',[PracticeController::class,'sumOfDigits']);
Route::get('/practice/loop',[PracticeController::class,'loopThroughArrayMap']);
