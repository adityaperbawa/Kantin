<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            // Authentication passed...
            return $this->authenticated($request, Auth::user())->with('success','Login Success');
        }

        // Authentication failed...
        return redirect()->back()->with('error','Akun Tidak Ada / Salah Password');
    }

    protected function authenticated(Request $request, $user)
    {
        // Customize redirection based on user role
        if ($user->role === 'manager') {
            return redirect()->route('manager.dashboard');
        } elseif ($user->role === 'kasir') {
            return redirect()->route('kasir.dashboard');
        } elseif ($user->role === 'dapur') {
            return redirect()->route('dapur.dashboard');
        }
    }
}
