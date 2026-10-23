@extends('layouts.app')

@section('content')

<div class="container">

    <div class="page-header">
        <h2>My Semester Results</h2>

        <a href="{{ route('student.dashboard') }}" class="btn btn-secondary">
            Back to Dashboard
        </a>
    </div>

    @forelse($results as $result)

        @php
            $obtained = $result->subjects->sum('marks_obtained');
            $maximum = $result->subjects->sum('max_marks');

            $percentage = $maximum > 0
                ? ($obtained / $maximum) * 100
                : 0;
        @endphp

        <div class="table-box result-card">

            <h3>{{ $result->semester }}</h3>

            <p>
                <strong>Academic Year:</strong>
                {{ $result->academic_year }}
            </p>

            <p>
                <strong>Result Date:</strong>
                {{ $result->result_date->format('d-m-Y') }}
            </p>

            <table>

                <thead>
                    <tr>
                        <th>Subject</th>
                        <th>Marks Obtained</th>
                        <th>Maximum Marks</th>
                    </tr>
                </thead>

                <tbody>

                    @foreach($result->subjects as $subject)

                        <tr>
                            <td>{{ $subject->subject }}</td>

                            <td>{{ number_format($subject->marks_obtained, 2) }}</td>

                            <td>{{ number_format($subject->max_marks, 2) }}</td>
                        </tr>

                    @endforeach

                    <tr>
                        <th>Total</th>
                        <th>{{ number_format($obtained, 2) }}</th>
                        <th>{{ number_format($maximum, 2) }}</th>
                    </tr>

                </tbody>

            </table>

            <div class="result-summary">
                <h3>Overall Percentage: {{ number_format($percentage, 2) }}%</h3>
            </div>

        </div>

        <br>

    @empty

        <div class="table-box">
            <p>No results have been published for you yet.</p>
        </div>

    @endforelse

</div>

@endsection