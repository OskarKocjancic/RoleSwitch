<?php

use App\Http\Controllers\AuthManager;
use App\Http\Controllers\ChatGptController;
use Illuminate\Support\Facades\Route;



Route::post(
    '/login',
    [
        AuthManager::class,
        'loginPost'
    ]
)->name('login.post');

Route::post(
    '/add-prompt',
    [
        ChatGptController::class,
        'addPrompt'
    ]
)->name('add-prompt.post');

Route::post(
    '/delete-prompt',
    [
        ChatGptController::class,
        'deletePrompt'
    ]
)->name('delete-prompt.post');

Route::post(
    '/edit-prompt',
    [
        ChatGptController::class,
        'editPrompt'
    ]
)->name('edit-prompt.post');

Route::post(
    '/save-settings',
    [
        ChatGptController::class,
        'saveSettings'
    ]
)->name('save-settings.post');

Route::post(
    '/chat',
    [
        ChatGptController::class,
        'getResponseFromChatGPT'
    ]
)->name('chat.post');

Route::post(
    '/registration',
    [
        AuthManager::class,
        'registrationPost'
    ]
)->name('registration.post');

Route::get('/sitemap.xml', [SitemapController::class, 'index'])->name('sitemap.index');

Route::get('/', function () {
    return view('login');
});

Route::get(
    '/login',
    [
        AuthManager::class,
        'login'
    ]
)->name('login');

Route::get('/main_page', function () {
    return view('main-screen');
})->name('home');

Route::get('/settings', function () {
    return view('settings');
})->name('settings');

Route::get('/roles', function () {
    return view('role-edit');
})->name('roles');

Route::get('/registration', function () {
    return view('registration');
});

Route::get('/logout', [AuthManager::class, 'logout'])->name('logout');