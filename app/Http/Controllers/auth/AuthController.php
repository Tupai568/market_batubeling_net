<?php

namespace App\Http\Controllers\auth;

use App\Models\User;
use App\Mail\Register;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class AuthController extends Controller
{

    // Tampilan Login
    public function index()
    {
        return view('home.login');
    }


    // Tampilan Register
    public function register()
    {
        return view('home.register');
    }


    // Logika untuk Melakukan Login
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string|min:5|max:255',
        ]);

        if (Auth::attempt($request->only('email', 'password'))) {
            $user = Auth::user();

            if ($user->email_verified_at) {
                $request->session()->regenerate();

                if ($user->is_admin) {
                    return redirect()->intended('/Admin');
                } elseif ($user->user_type == "guest") {
                    return redirect()->intended(route("favorite"));
                } else {
                    return redirect()->intended(route("dashboard"));
                }
            } else {
                $this->logout($request);
                return redirect(route('login'))->with('error', 'Please Confirm Email');
            }
        }

        return back()->with('error', 'Invalid Username Or Password');
    }


    // Logika untuk Melakukan Register
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|alpha_num|min:5|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|string|min:5|max:255|confirmed',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'email_verified_token' => Str::random(100),
        ]);

        $link = env('APP_URL') . "/email/verify/{$user->id}/{$user->email_verified_token}";
        Mail::to($user->email)->send(new Register($link));

        return back()->with('success', 'Registration Successful! Please Confirm Your Email');
    }


    // Logika untuk Memverifikasi Email
    public function verifyEmail($id, $hash)
    {
        $user = User::findOrFail($id);

        if ($user->email_verified_token !== $hash) {
            return redirect('/login')->with('error', 'Invalid Email Verification Token');
        }

        $user->update(['email_verified_at' => now()]);

        return redirect('/login')->with('success', 'Verification Successful');
    }


    // Logika untuk Logout
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
