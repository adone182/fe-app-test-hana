<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class AuthController extends Controller
{
    public function index()
    {
        return view('login');
    }

    public function login(Request $request)
    {
        // Validasi input
        $request->validate([
            'user_email' => 'required|email',
            'user_password' => 'required'
        ]);

        // Kirim request login ke backend
        $response = Http::post(env('APP_URL_BE') . '/login', [
            'email' => $request->user_email,
            'password' => $request->user_password,
        ]);

        // Cek apakah login gagal
        if ($response->failed()) {
            return response()->json(['message' => 'Email atau password salah.'], 401);
        }

        // Ambil token dari respons
        $token = $response->json('token');

        // Simpan token ke session jika perlu (untuk backend session)
        session(['token' => $token]);

        // Kirim respons JSON dengan token
        return response()->json(['token' => $token, 'message' => 'Login berhasil']);
    }

    public function logout(Request $request)
    {
        // Kirim request logout ke backend
        Http::withHeaders([
            'Authorization' => 'Bearer ' . session('token')
        ])->post(env('APP_URL') . '/logout');

        // Hapus session token
        session()->forget('token');

        return redirect('/login');
    }
}
