<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Http;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\SettingController;


Route::get('/login', [AuthController::class, 'index'])->name('index');
// Route::post('/login', [AuthController::class, 'login'])->name('login');
// Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

Route::get('/users', [UserController::class, 'index'])->name('users.index');
Route::get('/users/add', [UserController::class, 'add'])->name('users.add');
Route::get('/users/{id}/edit', [UserController::class, 'edit'])->name('users.edit');
Route::get('/settings', [SettingController::class, 'index'])->name('settings.index');