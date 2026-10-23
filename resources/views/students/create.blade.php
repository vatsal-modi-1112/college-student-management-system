@extends('layouts.app')

@section('content')

<div class="container">

    <div class="page-header">
        <div>
            <span class="eyebrow">STUDENT ADMINISTRATION</span>
            
            <h2>Add Student</h2>

            <P class="page-description">
                Enter the student information and assign the current semester.
            </P>
        </div>

        <div class="page-actions">
            <a href="{{ route('students.index') }}" class="btn btn-secondary">
                Back to Students
            </a>
        </div>
    </div>

    <div class="form-container">
        @if($errors->any())
            <div class="alert-error">
                <strong>Please correct the following errors:</strong>

                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
        
            </div>
        @endif

        <form action="{{ route('students.store') }}" method="post">
            
            @csrf

            <div class="form-group">
                <label for="name">Student Name</label>
                <input type="text"  id="name" name="name" value="{{ old('name') }}" required>
            </div>

            <div class="form-group">
                <label for="email">Email</label>
                <input type="email"  id="email" name="email" value="{{ old('email') }}" required>
            </div>

            <div class="form-group">
                <label for="password">Password</label>
                <input type="password"  id="password" name="password" required>
                <small>Minimum 6 characters.</small>
            </div>

            <div class="form-group">
                <label for="course">Course</label>
                <input type="text"  id="course" name="course" value="{{ old('course') }}" required>
            </div>

            <div class="form-group">
                <label for="semester">Current Semester</label>

                <select id="semester" name="semester" required>
                    <option value="">-- Select Semester --</option>

                    @for($i = 1; $i <= 6; $i++)
                        <option value="Semester {{ $i }}"
                            @selected(old('semester') == "Semester $i")
                        >
                            Semester {{ $i }}
                        </option>
                    @endfor
                </select>
            </div>

            <div class="form-group">
                <label for="phone">Phone</label>
                <input type="text"  id="phone" name="phone" value="{{ old('phone') }}" maxlength="15" required>
            </div>

            <div class="form-actions">
                <button type="submit" class="btn">
                    Save Student
                </button>

                <a href="{{ route('students.index') }}" class="btn btn-light">
                    Cancel
                </a>
            </div>

        </form>
    
    </div>

</div>

@endsection