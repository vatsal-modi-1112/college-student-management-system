<?php

namespace App\Http\Controllers;

use App\Models\ResultSubject;
use App\Models\Student;
use App\Models\StudentResult;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class ResultController extends Controller
{
    public function index(Request $request){

        // Get available semesters
        $semesters = studentResult::select('semester')
            ->distinct()
            ->orderBy('semester')
            ->pluck('semester');
            
        // Get available academic years
        $academicYears = studentResult::select('academic_year')
            ->distinct()
            ->orderByDesc('academic_year')
            ->pluck('academic_year');

        //Retrieve Results with student and subject details
        $query = StudentResult::with(['student', 'subjects']);

        //Filter by semester
        if ($request->filled('semester')) {
            $query->where('semester', $request->semester);
        }

        //Filter by academic year
        if ($request->filled('academic_year')) {
            $query->where('academic_year', $request->academic_year);
        }
    
        $results = $query
            ->orderBy('semester')
            ->orderBy('academic_year')
            ->get();

        return view('results.index', compact('results', 'semesters', 'academicYears'));
    }

    public function create(){
        $students = Student::orderBy('name')->get();

        return view('results.create', compact('students'));
    }

    public function store(Request $request){
        $data = $request->validate([
            'student_id' => 'required|exists:students,id',
            'semester' => 'required|string|max:50',
            'academic_year' => 'required|string|max:20',
            'result_date' => 'required|date',

            'subjects' => 'required|array|min:1',
            'subjects.*.subject' => 'required|string|max:100',
            'subjects.*.marks_obtained' => 'required|numeric|min:0',
            'subjects.*.max_marks' => 'required|numeric|gt:0'
        ]);

        $this->checkMarks($data['subjects']);

        $exists = StudentResult::where(
            'student_id',
            $data['student_id']
        )
        ->where('semester', $data['semester'])
        ->where('academic_year', $data['academic_year'])
        ->exists();

        if ($exists) {
            return back()->withInput()->withErrors([
                'semester' => 'A result already exists for this student and semester.'
            ]);
        }

        DB::transaction(function () use ($data) {
            
            $result = StudentResult::create([
                'student_id' => $data['student_id'],
                'semester' => $data['semester'],
                'academic_year'=> $data['academic_year'],
                'result_date' => $data['result_date'],
            ]);

            foreach ($data['subjects'] as $subject) {
                $result->subjects()->create($subject);
            }
        });

        return redirect()->route('results.index')->with('success', 'Result added successfully!');
    }

    public function show(StudentResult $result){
        $result->load(['student', 'subjects']);

        return view('results.show', compact('result'));
    }

    public function edit(StudentResult $result){
        $students = Student::orderBy('name')->get();

        $result->load('subjects');

        return view('results.edit', compact('result', 'students'));
    }

    public function update(Request $request, StudentResult $result){
        $data = $request->validate([
            'student_id' => 'required|exists:students,id',
            'semester' => 'required|string|max:50',
            'academic_year' => 'required|string|max:20',
            'result_date' => 'required|date',

            'subjects' => 'required|array|min:1',
            'subjects.*.subject' => 'required|string|max:100',
            'subjects.*.marks_obtained' => 'required|numeric|min:0',
            'subjects.*.max_marks' => 'required|numeric|gt:0'
        ]);

        $this->checkMarks($data['subjects']);

        $exists = StudentResult::where(
            'student_id',
            $data['student_id']
        )
        ->where('semester', $data['semester'])
        ->where('academic_year', $data['academic_year'])
        ->where('id', '!=', $result->id)
        ->exists();

        if ($exists) {
            return back()->withInput()->withErrors([
                'semester' => 'A result already exists for this student and semester.'
            ]);
        }

        DB::transaction(function () use ($data, $result) {
            
            $result->update([
               'student_id' => $data['student_id'],
                'semester' => $data['semester'],
                'academic_year'=> $data['academic_year'],
                'result_date' => $data['result_date'], 
            ]);

            $result->subjects()->delete();

            foreach ($data['subjects'] as $subject) {
                $result->subjects()->create($subject);
            }
        });

        return redirect()->route('results.index')->with('success', 'Result updated successfully!');
    }

    public function destroy(StudentResult $result){
        $result->delete();

        return redirect()->route('results.index')->with('success', 'Result deleted successfully!'); 
    }

    public function studentResults(){
        if (!session('student_logged_in') || !session('student_id')) {
            return redirect()->route('student.login');
        }

        $results = StudentResult::with('subjects')
            ->where('student_id', session('student_id'))
            ->latest()
            ->get();

        return view('student.results', compact('results'));
    }

    private function checkMarks(array $subjects){
        $names = [];

        foreach ($subjects as $subject) {
            if ($subject['marks_obtained'] > $subject['max_marks']) {
                throw ValidationException::withMessages([
                    'subjects' => 'Marks obtained cannot exceed maximum marks.'
                ]);
            }

            $name = strtolower(trim($subject['subject']));

            if (in_array($name, $names)) {
                throw ValidationException::withMessages([
                    'subjects' => 'The same subject cannot be entered twice.'
                ]);
            }

            $names[] = $name;
        }
    }

}
