<?php

// app/Http/Controllers/AuthController.php (Lumen)
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        // Validasi inputan
        if (empty($credentials['email']) || empty($credentials['password'])) {
            return response()->json(['success' => false, 'message' => 'Email dan password diperlukan'], 400);
        }

        // Cek apakah email dan password valid
        $user = User::where('email', $credentials['email'])->first();

        if ($user && Hash::check($credentials['password'], $user->password)) {
            // Login berhasil
            return response()->json(['success' => true, 'message' => 'Login berhasil']);
        }

        // Login gagal
        return response()->json(['success' => false, 'message' => 'Email atau password salah'], 401);
    }
}

