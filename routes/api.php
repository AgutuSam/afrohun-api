<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\PostsController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\OpportunityController;
use App\Http\Controllers\DonateController;
use App\Http\Controllers\ArchiveController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use App\Http\Controllers\ChatController;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum', 'verified')->get('/user', function (Request $request) {
    return $request->user();
});



//public routes
Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);

Route::get('/members', [MemberController::class, 'index']);
Route::get('/members/{mem_id}/posts/{id}', [PostsController::class, 'show']);
Route::get('/members/search/{name}', [MemberController::class, 'search']);

Route::resource('/members', MemberController::class);
Route::resource('/members/{mem_id}/posts', PostsController::class);
Route::resource('/members/{mem_id}/posts/{post_id}/Comments', CommentController::class);
Route::post('/posts/{post}/comments', [CommentController::class, 'store'])->name('comments.store');
Route::resource('/members/{mem_id}/posts/{post_id}/likes', LikeController::class);
Route::resource('/members/{mem_id}/opps', OpportunityController::class);
Route::resource('/members/{mem_id}/donate', DonateController::class);
Route::resource('/users', UserController::class)->middleware(['auth:sanctum']);
Route::resource('/archive', ArchiveController::class);
Route::get('/notifs', [NotificationController::class, 'index']);
Route::post('/comments/{$com_id}/notifs', [NotificationController::class, 'storePostNotification']);
//Route::post('/members/{mem_id}/posts/{post_id}/Comments/{$com_id}/notifications',[NotificationController::class, 'storePostNotification']);
// Route::post('/sendemail', [EmailController::class, 'sendEmail']);

// Route::post('email/verification-notification', [EmailVerificationController::class, 'sendVerificationEmail'])->middleware('auth:sanctum');
// Route::get('verify-email/{id}/{hash}', [EmailVerificationController::class, 'verify'])->name('verification.verify')->middleware('auth:sanctum');
// Email verification routes
Route::get('/email/verify', 'App\Http\Controllers\Auth\VerificationController@show')
    ->name('verification.notice')
    ->middleware('auth:sanctum');

// Route::get('/email/verify/{id}/{hash}', 'App\Http\Controllers\Auth\VerificationController@verify')
//     ->name('verification.verify')
//     ->middleware('auth:sanctum');
Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
  $request->fulfill();
})->middleware(['auth:sanctum'])->name('verification.verify');

Route::post('/email/resend', 'App\Http\Controllers\Auth\VerificationController@resend')
    ->name('verification.resend')
    ->middleware('auth:sanctum');

Route::get('/forgot-password', [ForgotPasswordController::class, 'forgotPassword']
      // return view('auth.forgot-password');
  )->middleware('auth:sanctum')->name('password.request');

Route::get('/reset-password/{token}', [ResetPasswordController::class, 'resetPassword']
    // return view('auth.reset-password', ['token' => $token]);
)->middleware('auth:sanctum')->name('password.reset');

//protected routes
Route::group(['middleware' => ['auth:sanctum']], function () {
  Route::post('/logout', [AuthController::class, 'logout']);  

});

//Route::post('messages', [ChatController::class, 'sendPrivateMessage'])->middleware('auth:sanctum');
Route::resource('/messages', ChatController::class)->middleware('auth:sanctum');