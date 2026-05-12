<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class LoginController extends Controller
{
    public function index()
    {
        // Cek sudah login atau belum
        if (Auth::check()) {
            $user = Auth::user();
            Log::info('User already authenticated, redirecting', ['role' => $user->role]);
            
            return match($user->role) {
                'admin' => redirect('/admin'),
                'mentor' => redirect('/mentor'),
                'student' => redirect('/user'),
                default => redirect('/')
            };
        }
        
        Log::info('Login page accessed', [
            'ip' => request()->ip(),
            'user_agent' => request()->userAgent()
        ]);
        
        return view('auth.login');
    }

    public function login(Request $request)
    {
        Log::info('=== LOGIN ATTEMPT START ===');
        Log::info('Request data', [
            'email' => $request->email,
            'has_password' => !empty($request->password),
            'ip' => $request->ip(),
            'method' => $request->method(),
            'url' => $request->url(),
            'session_id' => session()->getId(),
            'all_input' => $request->all() // Cek semua input yang masuk
        ]);

        // Validasi
        $validated = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ], [
            'email.required' => 'Email Wajib di isi!',
            'email.email' => 'Email harus valid!',
            'password.required' => 'Password Wajib di isi!',
        ]);

        Log::info('Validation passed', $validated);

        $credentials = [
            'email' => $request->email,
            'password' => $request->password,
        ];

        $remember = $request->filled('remember');
        
        Log::info('Credentials prepared', [
            'email' => $credentials['email'],
            'remember' => $remember
        ]);

        // Cek user di database
        $userExists = \App\Models\User::where('email', $request->email)->first();
        Log::info('User lookup', [
            'exists' => $userExists ? 'YES' : 'NO',
            'user_id' => $userExists->id ?? null,
            'user_role' => $userExists->role ?? null,
        ]);

        // Attempt login
        if (Auth::attempt($credentials, $remember)) {
            $request->session()->regenerate();
            
            $user = Auth::user();
            
            Log::info('✅ Authentication SUCCESSFUL', [
                'user_id' => $user->id,
                'email' => $user->email,
                'role' => $user->role,
                'session_id' => session()->getId(),
            ]);

            // Redirect berdasarkan role - LANGSUNG tanpa intended
            $redirectPath = match($user->role) {
                'admin' => '/admin',
                'mentor' => '/mentor',
                'student' => '/user',
                default => null
            };

            if ($redirectPath) {
                Log::info('Redirecting to: ' . $redirectPath);
                return redirect($redirectPath);
            } else {
                Log::warning('❌ Invalid role detected', ['role' => $user->role]);
                Auth::logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();
                
                return redirect('/')
                    ->withErrors('Role tidak valid: ' . $user->role);
            }
        }

        // Login gagal
        Log::warning('❌ Authentication FAILED', [
            'email' => $request->email,
            'ip' => $request->ip(),
            'reason' => 'Invalid credentials'
        ]);

        return redirect('/')
            ->withErrors('Email dan Password yang dimasukan tidak sesuai')
            ->withInput($request->only('email'));
    }

    public function logout(Request $request)
    {
        $userId = Auth::id();
        
        Log::info('User logout', ['user_id' => $userId]);
        
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        return redirect('/');
    }
}