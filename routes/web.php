<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// we should have all our routes before the slug , otherwise , we will always get the slug's route


Route::prefix('/app')->middleware([App\Http\Middleware\AdminCheck::class])->group(function () {
    Route::post('/create_releveur', [App\Http\Controllers\AdminController::class, 'addReleveur']);
    Route::get('/get_releveur', [App\Http\Controllers\AdminController::class, 'getReleveur']);
    Route::post('/edit_releveur', [App\Http\Controllers\AdminController::class, 'editReleveur']);
    Route::post('/delete_releveur', [App\Http\Controllers\AdminController::class, 'deleteReleveur']);
    Route::post('/delete_user', [App\Http\Controllers\AdminController::class, 'deleteUser']);
    Route::post('/create_plan', [App\Http\Controllers\AdminController::class, 'addPlan']);
    Route::get('/get_plan', [App\Http\Controllers\AdminController::class, 'getPlan']);
    Route::post('/edit_plan', [App\Http\Controllers\AdminController::class, 'editPlan']);
    Route::post('/delete_plan', [App\Http\Controllers\AdminController::class, 'deletePlan']);
    Route::post('/upload', [App\Http\Controllers\AdminController::class, 'upload']);
    Route::post('/delete_image', [App\Http\Controllers\AdminController::class, 'deleteImage']);
    Route::post('/create_user', [App\Http\Controllers\AdminController::class, 'createUser']);
    Route::get('/get_users', [App\Http\Controllers\AdminController::class, 'getUsers']);
    Route::post('/edit_user', [App\Http\Controllers\AdminController::class, 'editUser']);
    Route::post('/admin_login', [App\Http\Controllers\AdminController::class, 'adminLogin']);
    Route::get('/get_historique', [App\Http\Controllers\AdminController::class, 'getHistorique']);
    Route::delete('/clear_historique', [App\Http\Controllers\AdminController::class, 'clearHistorique']);

    // role routes
    Route::post('/create_role', [App\Http\Controllers\AdminController::class, 'createRole']);
    Route::get('/get_roles', [App\Http\Controllers\AdminController::class, 'getRoles']);
    Route::post('/edit_role', [App\Http\Controllers\AdminController::class, 'editRole']);
    Route::post('/delete_role', [App\Http\Controllers\AdminController::class, 'deleteRole']);
    Route::post('/assign_role', [App\Http\Controllers\AdminController::class, 'assignRole']);
});
  


// Route::get('/app/get_releveur_count', [App\Http\Controllers\AdminController::class, 'getReleveurCount']);





// Route::get('/{any}', [App\Http\Controllers\AppController::class, 'index'])->where('any', '.*'); 

Route::get('/logout', [App\Http\Controllers\AdminController::class, 'logout']);
Route::get('/', [App\Http\Controllers\AdminController::class, 'index']);
Route::get('/{slug}', [App\Http\Controllers\AdminController::class, 'index']);

// Route::get('/', function () {
//     return view('welcome');
// });

// Route::get('/karim', [App\Http\Controllers\Controller::class, 'karim']);

// // The 'any' route
// Route::any('{slug}', function () {
//     return view('welcome');
// });