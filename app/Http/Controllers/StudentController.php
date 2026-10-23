<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class StudentController extends Controller
{
    private function checkAdmin(){
        if (!session('admin_logged_in')) {
            return redirect()->route('admin.login');
        }

        return null;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
       // Get semesters already assigned to students
       $semesters = Student::whereNotnull('semester')
            ->where('semester', '!=', '')
            ->select('semester')
            ->distinct()
            ->orderBy('semester')
            ->pluck('semester');

        //Start with all students
        $query = Student::query();

        //Filter students by semester
        if ($request->filled('semester')) {
            $query->where('semester', $request->semester);
        }

        //Retrieve the matching students
    
       $students=$query
           ->orderBy('semester')
           ->orderBy('name')
           ->get();
       
       return view('students.index', compact('students', 'semesters'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('students.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated=$request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:students,email',
            'password' => 'required|string|min:6',
            'course' => 'required|string|max:100',
            'semester' => 'required|string|max:50',
            'phone'=>'required|string|max:15'
        ]);

        $validated['password'] = Hash::make($validated['password']);

        Student::create($validated);

        return redirect()->route('students.index')->with('success', 'Student added successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Student $student)
    {
        return view('students.show', compact('student'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Student $student)
    {
        return view('students.edit', compact('student'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Student $student)
    {
        $validated=$request->validate([
            'name' =>  'required|string|max:255',
            'email' => 'required|email|unique:students,email,' . $student->id,
            'course' => 'required|string|max:100',
            'semester' => 'required|string|max:50',
            'phone' => 'required|string|max:15'
        ]);

        $student->update($validated);

        return redirect()->route('students.index')->with('success', 'Student updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Student $student)
    {
        $student->delete();

        return redirect()->route('students.index')->with('success', 'Student deleted successfully!');
    }
}
