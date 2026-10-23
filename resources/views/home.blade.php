@extends('layouts.app')

@section('content')

<div class="container">
    
    <div class="hero">
        <h1>Welcome to College Student Management System</h1>

        <p>
            Manage student information easily. 
        </p>

    </div>

    <div class="cards">

        <div class="card">
            
            <h3>Admin Login</h3>

            <p>
                Admin can add, view, edit and delete student records.
            </p>

            <a href="{{ route('admin.login') }}" class="btn">
                Admin Login
            </a>

        </div>

        <div class="card">
            
            <h3>Student Login</h3>

            <p>
                Registered students can login and view their details.
            </p>

            <a href="{{ route('student.login') }}" class="btn">
                Student Login
            </a>

        </div>

    </div>
    
</div>

@endsection