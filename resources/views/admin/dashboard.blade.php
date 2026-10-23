@extends('layouts.app')

@section('content')

<div class="container">

    <h2>Admin Dashboard</h2>

    <p>Welcome, {{ $admin->name }}</p>

    <p>
        From here you can manage student records.
    </p>

    <a href="{{ route('students.index') }}" class="btn">
        Student Management
    </a>

    <br><br>

    <a href="{{ route('results.index') }}" class="btn">
        Result Management
    </a>

    <form action="{{ route('admin.logout' )}}" method="post">

        @csrf

        <button type="submit" class="btn">
            LogOut
        </button>

    </form>

</div>
@endsection