<?php

use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\PostsController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\OpportunityController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\DonateController;
use App\Http\Controllers\ArchiveController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\EmailController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\GroupChatController;
use App\Http\Controllers\ImportController;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GroupzController;

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


Route::group(['middleware' => ['auth:sanctum','isAdmin']], function () {

  Route::post('/sendemail', [EmailController::class, 'sendEmail']);
});


//public routes
Route::post('/login', [LoginController::class, 'login']);
Route::post('/register', [RegisterController::class, 'register']);



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
  Route::post('/logout', [LogoutController::class, 'logout']);

  Route::resource('/users', UserController::class);
  Route::post('/users', [UserController::class, 'update']);
  Route::delete('/users', [UserController::class, 'destroy']);
  Route::get('search/{name}', [UserController::class, 'search']);
  Route::put('/user/{id}', [UserController::class, 'updateAdmin']);


  Route::resource('/posts', PostsController::class);
  Route::get('/post', [PostsController::class, 'showUser'])->name('post.show');

  Route::resource('/opps', OpportunityController::class);

  Route::resource('/event', EventController::class);

  Route::resource('/donate', DonateController::class);

  Route::resource('/archive', ArchiveController::class);

  Route::resource('/posts/{post_id}/likes', LikeController::class);


  Route::resource('/posts/{post}/comments', CommentController::class);

  Route::post('/messages', [ChatController::class, 'sendPrivateMessage']);
  Route::get('/messages/{rd}', [ChatController::class, 'getPrivateMessage']);
  Route::get('/messages', [ChatController::class, 'fetchMessages']);
  Route::put('/messages/{id}', [ChatController::class, 'putPrivateMessage']);
  Route::delete('/messages/{id}', [ChatController::class, 'delPrivateMessage']);

  Route::resource('/group', GroupChatController::class);
  Route::post('/group/{id}/user', [GroupChatController::class, 'addUser']);
  Route::get('/groups/{id}', [GroupChatController::class, 'showGroupUsers']);

});

//Route::post('messages', [ChatController::class, 'sendPrivateMessage'])->middleware('auth:sanctum');

Route::post('/groupy', [ChatController::class, 'sendGroupMessage'])->middleware('auth:sanctum');
// Route::resource('/groupy', ChatController::class)->middleware('auth:sanctum');

// Groupz Routes
Route::post('/groupz', [GroupzController::class, 'createGroup'])->middleware('auth:sanctum');
Route::get('/groupz', [GroupzController::class, 'getGroupz'])->middleware('auth:sanctum');
Route::get('/groupz_info', [GroupzController::class, 'getGroupsWithMembers'])->middleware('auth:sanctum');
Route::post('/groupz/{groupId}/join', [GroupzController::class, 'joinGroup'])->middleware('auth:sanctum');
Route::post('/groupz/{groupId}/leave', [GroupzController::class, 'leaveGroup'])->middleware('auth:sanctum');
Route::delete('/groupz/{groupId}', [GroupzController::class, 'deleteGroup']); // DELETE request to delete a group
Route::post('/groupz/{groupId}/invite', [GroupzController::class, 'inviteToGroup']); // POST request to invite users
Route::get('/user/groups', [GroupzController::class, 'getGroupsForAuthenticatedUser'])->middleware('auth:sanctum');

// Group Message
Route::post('/groupz/{groupId}/send', [GroupzController::class, 'sendMessage'])->middleware('auth:sanctum');
Route::get('/groupz/{groupId}/messages', [GroupzController::class, 'getGroupMessages'])->middleware('auth:sanctum');

// Import
// Route::post('/import', 'ImportController@import');
Route::post('/import', [ImportController::class, 'import']);
