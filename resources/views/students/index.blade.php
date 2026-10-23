@extends('layouts.app')

@section('content')

<div class="container students-page">

    <div class="page-header">
        <div>
            <span class="eyebrow">ACADEMIC ADMINISTRATION</span>

            <h2>Student Management</h2>

            <p class="page-description">
                View students together by their current semester and manage their information.
            </p>
        </div>

        <div class="page-actions">
            <a href="{{ route('admin.dashboard') }}" class="btn btn-secondary">
                Back to Dashboard
            </a>

            <a href="{{ route('students.create') }}" class="btn">
                + Add Student
            </a>
        </div>
    </div>

    @if(session('success'))
        <div class="alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if($errors->any())
        <div class="alert-error">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- Semester filter --}}

    <div class="filter-card">

        <div class="filter-heading">
            <h3>Filter Students by Semester</h3>

            <p>
                Select a semester to display all students assigned to it.
            </p>
        </div>

        <form action="{{ route('students.index') }}"
              method="GET"
              class="filter-form">

            <div class="filter-field">
                <label for="semester">Current Semester</label>

                <select name="semester" id="semester">
                    <option value="">All Semesters</option>

                    @foreach($semesters as $semester)
                        <option
                            value="{{ $semester }}"
                            @selected(request('semester') == $semester)
                        >
                            {{ $semester }}
                        </option>
                    @endforeach

                </select>
            </div>

            <div class="filter-actions">
                <button type="submit" class="btn">
                    Apply Filter
                </button>

                <a href="{{ route('students.index') }}" class="btn btn-light">
                    Clear
                </a>
            </div>

        </form>

    </div>

    <div class="results-summary-bar">
        <div>
            <strong>{{ $students->count() }}</strong>
            student(s) displayed
        </div>

        <div class="active-filter">
            @if(request('semester'))
                Showing: {{ request('semester') }}
            @else
                Showing all students
            @endif
        </div>
    </div>

    {{-- Students table --}}

    <div class="table-box results-table-box">

        <table class="students-table">

            <thead>
                <tr>
                    <th>ID</th>
                    <th>Student</th>
                    <th>Email</th>
                    <th>Course</th>
                    <th>Current Semester</th>
                    <th>Phone</th>
                    <th>Actions</th>
                </tr>
            </thead>

            <tbody>

                @forelse($students as $student)

                    <tr>
                        <td>{{ $student->id }}</td>

                        <td>
                            <div class="student-name">
                                {{ $student->name }}
                            </div>
                        </td>

                        <td>{{ $student->email }}</td>

                        <td>{{ $student->course }}</td>

                        <td>
                            @if($student->semester)
                                <span class="semester-badge">
                                    {{ $student->semester }}
                                </span>
                            @else
                                <span class="muted-text">
                                    Semester not assigned
                                </span>
                            @endif
                        </td>

                        <td>{{ $student->phone }}</td>

                        <td class="manage-actions">

                            <a href="{{ route('students.edit', $student) }}"
                               class="btn btn-small">
                                Edit
                            </a>

                            <a href="{{ route('results.index', ['semester' => $student->semester]) }}"
                               class="btn btn-small btn-light">
                                View Results
                            </a>

                            <form action="{{ route('students.destroy', $student) }}"
                                  method="POST"
                                  class="inline-form"
                                  onsubmit="return confirm('Delete this student and their associated records?');">

                                @csrf
                                @method('DELETE')

                                <button type="submit"
                                        class="btn btn-small btn-danger">
                                    Delete
                                </button>

                            </form>

                        </td>
                    </tr>

                @empty

                    <tr>
                        <td colspan="7" class="empty-state">
                            <strong>No students found.</strong>

                            <span>
                                Try another semester or add a new student.
                            </span>
                        </td>
                    </tr>

                @endforelse

            </tbody>

        </table>

    </div>

</div>

@endsection