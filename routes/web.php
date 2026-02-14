<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\CompetitionController as AdminCompetitionController;
use App\Http\Controllers\Admin\RegistrationController as AdminRegistrationController;
use App\Http\Controllers\Admin\SupportController;
use App\Http\Controllers\User\DashboardController as UserDashboardController;
use App\Http\Controllers\User\CompetitionController as UserCompetitionController;
use App\Http\Controllers\Support\DashboardController as SupportDashboardController;
use App\Http\Controllers\Support\ChatController;
use App\Http\Controllers\Auth\SocialAuthController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

    Route::resource('categories', CategoryController::class);
    Route::resource('competitions', AdminCompetitionController::class);

    Route::get('/registrations', [AdminRegistrationController::class, 'index'])->name('registrations.index');
    Route::post('/registrations/{registration}/confirm', [AdminRegistrationController::class, 'confirm'])->name('registrations.confirm');
    Route::post('/registrations/{registration}/reject', [AdminRegistrationController::class, 'reject'])->name('registrations.reject');
    Route::delete('/registrations/{registration}', [AdminRegistrationController::class, 'destroy'])->name('registrations.destroy');

    Route::resource('support', SupportController::class);
});

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [UserDashboardController::class, 'index'])->name('dashboard');

    Route::get('/competitions', [UserCompetitionController::class, 'index'])->name('competitions.index');
    Route::get('/competitions/{competition:slug}', [UserCompetitionController::class, 'show'])->name('competitions.show');
    Route::post('/competitions/{competition}/register', [UserCompetitionController::class, 'register'])->name('competitions.register');
    Route::get('/my-competitions', [UserCompetitionController::class, 'myCompetitions'])->name('competitions.my');
});
Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::get('/calendar', [UserCompetitionController::class, 'calendar'])->name('competitions.calendar');
Route::middleware(['auth', 'support'])->prefix('support')->name('support.')->group(function () {
    Route::get('/dashboard', [SupportDashboardController::class, 'index'])->name('dashboard');
    Route::get('/chats', [ChatController::class, 'index'])->name('chats.index');
    Route::get('/chats/{user}', [ChatController::class, 'show'])->name('chats.show');
    Route::post('/chats/{user}/send', [ChatController::class, 'sendMessage'])->name('chats.send');
    Route::post('/chats/{user}/claim', [ChatController::class, 'claimChat'])->name('chats.claim');
});

Route::get('/auth/{provider}', [SocialAuthController::class, 'redirectToProvider'])->name('social.redirect');
Route::get('/auth/{provider}/callback', [SocialAuthController::class, 'handleProviderCallback'])->name('social.callback');
require __DIR__ . '/auth.php';
