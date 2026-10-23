@extends('layouts.app')

@section('content')

<div class="container">

    <h2>Student Login</h2>

    @if(session('error'))
        <p style="color: red;">
            {{ session('error') }}
        </p>
    @endif

    <form action="{{ route('student.login.submit') }}" method="post">

        @csrf

        <p>
            <label>Email:</label>
            <input type="email" name="email" required>
        </p>

        <p>
            <label>Password:</label>
            <input type="password" name="password" required>
        </p>

        <button type="submit" class="btn">
            Login
        </button>
    
    </form> 

</div>

@endsection