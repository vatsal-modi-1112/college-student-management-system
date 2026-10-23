@extends('layouts.app')

@section('content')

<div class="container">

    <h2>Student Dashboard</h2>

    <p>Welcome, {{ $student->name }}</p>

    <div class="table-box">

        <table>

            <tr>
                <th>Name</th>
                <td>{{ $student->name }}</td>
            </tr>

            <tr>
                <th>Email</th>
                <td>{{ $student->email }}</td>
            </tr>

            <tr>
                <th>Course</th>
                <td>{{ $student->course }}</td>
            </tr>

            <tr>
                <th>Phone</th>
                <td>{{ $student->phone }}</td>
            </tr>

        </table>

    </div>

    <br>

    <a href="{{ route('student.results') }}" class="btn">
        View My Results
    </a>

    <br><br>

    <form action="{{ route('student.logout' )}}" method="post">

        @csrf

        <button type="submit" class="btn">
            LogOut
        </button>

    </form>

</div>
@endsection