<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class StudentAuthController extends Controller
{
    public function showLogin(){
        return view('student.login');
    }

    public function login(Request $request){
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        $student = Student::where('email', $credentials['email'])->first();

        if (!$student || !Hash::check($credentials['password'], $student->password)) {
            return back()->with('error', 'Invalid email or password.');
        }

        $request->session()->regenerate();

        session([
            'student_id' => $student->id,
            'student_logged_in' => true
        ]);

        return redirect()->route('student.dashboard');
    }

    public function dashboard(){
        
        if (!session('student_logged_in')) {
            return redirect()->route('student.login');
        }

        $student = Student::find(session('student_id'));

        return view('student.dashboard', compact('student'));
    }

    public function logout(Request $request) {
        $request->session()->forget([
            'student_id',
            'student_logged_in'
        ]);

        $request->session()->regenerateToken();

        return redirect()->route('student.login');
    }
}
