<?php

use App\Http\Controllers\InviteResultController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\SecurityQuestionAnswersController;
use App\Http\Controllers\SecurityQuestionsController;
use App\Http\Controllers\UserInvitesController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
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

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return Inertia::render('Dashboard');
    })->name('dashboard');
});

// security questions
Route::resource("security_questions", SecurityQuestionsController::class)
    ->middleware("auth:web")
    ->except(["show"]);

// security questions answers
Route::resource('security_questions_answers', SecurityQuestionAnswersController::class)
    ->middleware("auth:web")
    ->except("show");


//invites and connection
Route::post('/invites', [UserInvitesController::class, 'index'])->middleware('auth:web');
Route::post('/users/{user}/invite', [UserInvitesController::class, 'store'])->middleware('auth:web');
Route::post('/invites/{invite}/accept', [InviteResultController::class, 'accept'])->middleware('auth:web');
Route::post('/invites/{invite}/accept', [InviteResultController::class, 'reject'])->middleware('auth:web');

// searching
Route::get('/search', [SearchController::class, "search"]);

