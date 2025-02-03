<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Http;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\SettingController;

Route::get('/login', function () {
    return view('login');
});

Route::get('/logout', function () {
    return redirect('/login');
});

// Route::post('/login', function (Request $request) {
//     // Ambil data inputan login dari form
//     $credentials = $request->only('email', 'password');
    
//     // Kirim request POST ke API Lumen untuk melakukan autentikasi
//     $response = Http::post('http://localhost:8001/login', $credentials);
    
//     // Cek apakah login berhasil berdasarkan response dari Lumen
//     if ($response->successful()) {
//         return redirect('/dashboard');
//     }
    
//     return back()->withErrors([
//         'email' => 'Email atau password salah.',
//     ]);
// })->name('login');

Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
Route::get('/users', [UserController::class, 'index'])->name('users.index');
Route::get('/settings', [SettingController::class, 'index'])->name('settings.index');