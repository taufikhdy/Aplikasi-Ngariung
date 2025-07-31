<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

use App\Models\User; //APAKAH DIAMBIL DARI WARGA?
use Illuminate\Support\Facades\Redirect;

class LoginRegisterController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware('guest', except: ['home', 'logout']),
            new Middleware('auth', only: ['home', 'logout']),
        ];
    }

    // public function register(): View
    // {
    //     return view('auth.register');
    // }

    // public function store(Request $request): RedirectResponse
    // {
    //     $request->validate([
    //         'name' => 'required|string|max:250',
    //         'email' => 'required|string|email:rfc,dns|max:250|unique:users,email',
    //         'password' => 'required|string|min:8|confirmed'
    //     ]);

    //     $user = User::create([
    //         'name' => $request->name,
    //         'email' => $request->email,
    //         'password' => Hash::make($request->password)
    //     ]);

    //     $credentials = $request->only('email', 'password');
    //     Auth::attempt($credentials);
    //     $request->session()->regenerate();
    //     return redirect()->route('home')
    //         ->withSuccess('You have successfully registered & logged in!');
    // }

    public function login(): View
    {
        return view('auth.login');
    }



    // PROSES CEK LOGIN PIKK TONG HILAPP
    public function authenticate(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'nik' => 'required',
            'password' => 'required'
        ]);


        if(Auth::attempt($credentials))
        {
            $request->session()->regenerate();

            $role = Auth::user()?->role?->nama_role;

            return match($role) {
                'warga' => redirect()->route('warga.dashboard'),
                'rt' => redirect()->route('admin.dashboard'),
                default => redirect()->route('login'),
            };
        }


        $nik = User::where('nik', $request->nik)->first();

        if(!$nik){
            return redirect()->back()->with('nik', 'NIK tidak ditemukan, Pastikan NIK yang digunakan sudah terdaftar.');
        }
        return redirect()->back()->withInput()->with('password', 'Password salah. Coba lagi.');

    }

    public function home()
    {
        if(Auth::user()->role->nama_role === 'warga'){
            return redirect()->route('warga.dashboard');
        }else if(Auth::user()->role->nama_role === 'rt'){
            return redirect()->route('admin.dashboard');
        }
    }

    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login')
            ->withSuccess('You have logged out successfully!');
    }
}
