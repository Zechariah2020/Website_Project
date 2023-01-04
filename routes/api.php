<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\ForgotPasswordController;
use App\Http\Controllers\ResetPasswordController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::group(['middleware' => 'auth:sanctum'], function () {
    // All secure URLs
    Route::get("getprofile", [MemberController::class, "getInfoByToken"]);
    Route::post("updateprofile", [MemberController::class, "updateProfile"]);
});


Route::post("signup", [MemberController::class, "signup"]);
Route::post("signin", [MemberController::class, "signin"]);
Route::post("forgot-password", [ForgotPasswordController::class, "forgotPassword"]);
Route::post("reset-password", [ResetPasswordController::class, "resetPassword"]);