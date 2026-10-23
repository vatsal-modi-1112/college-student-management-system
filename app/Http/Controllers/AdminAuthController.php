<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminAuthController extends Controller
{
    public function showLogin(){
        return view('admin.login');
    }

    public function login(Request $request){
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        $admin = User::where('email', $credentials['email'])->first();

        if (!$admin || !Hash::check($credentials['password'], $admin->password)) {
            return back()->with('error', 'Invalid admin email or password.');
        }

        $request->session()->regenerate();

        session([
            'admin_id' => $admin->id,
            'admin_logged_in' => true
        ]);

        return redirect()->route('admin.dashboard');
    }

    public function dashboard(){
        
        if (!session('admin_logged_in')) {
            return redirect()->route('admin.login');
        }

        $admin = User::find(session('admin_id'));

        return view('admin.dashboard', compact('admin'));
    }

    public function logout(Request $request) {
        $request->session()->forget([
            'admin_id',
            'admin_logged_in'
        ]);

        $request->session()->regenerateToken();

        return redirect()->route('admin.login');
    }
}
