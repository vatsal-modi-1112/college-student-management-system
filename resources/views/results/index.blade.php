@extends('layouts.app')

@section('content')

<div class="container results-page">

    <div class="page-header">
        <div>
            <span class="eyebrow">ACADEMIC ADMINISTRATION</span>
            
            <h2>Semester-wise Result Management</h2>

            <P class="page-description">
                View and manage students' results by semester and academic year.
            </P>
        </div>

        <div class="page-actions">
            <a href="{{ url('/admin/dashboard') }}" class="btn btn-secondary">
                Back to Dashboard
            </a>
        
            <a href="{{ route('results.create') }}" class="btn">
                + Add Result
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

    {{-- Semester and academic year filters --}}

    <div class="filter-card">
        <div class="filter-heading">
            <h3>Filter Student Results</h3>

            <p>
                Select a semester and academic year to display matching results.
            </p>
        </div>

        <form action="{{ route('results.index') }}" method="get" class="filter-form">
            <div class="filter-field">
                <label for="semester">Semester</label>

                <select name="semester" id="semester">
                    <option value="">All Semesters</option>

                    @foreach($semesters as $semester)
                        <option value="{{ $semester }}" 
                            @selected(request('semester') == $semester)>
                            {{ $semester }}
                        </option>
                    @endforeach

                </select>
            </div>

            <div class="filter-field">
                <label for="academic_year">Academic Years</label>

                <select name="academic_year" id="academic_year">
                    <option value="">All Academic Years</option>

                    @foreach($academicYears as $year)
                        <option value="{{ $year }}" 
                            @selected(request('academic_year') == $year)>
                            {{ $year }}
                        </option>
                    @endforeach

                </select>
            </div>

            <div class="filter-actions">
                <button type="submit" class="btn">
                    Apply Filter
                </button>

                <a href="{{ route('results.index') }}" class="btn btn-light">
                    Clear
                </a>
            </div>

        </form>

    </div>

    {{-- Result count and active filter --}}

    <div class="results-summary-bar">

        <div>
            <strong>{{ $results->count() }}</strong>
            student result(s) displayed
        </div>

        <div class="active-filter">
            @if(request('semester') || request('academic_year'))

                Showing:
                {{ request('semester') ?: 'All Semesters' }}
                |
                {{ request('academic_year') ?: 'All Academic Years' }}

            @else
                 
                Showing all recorded results
            @endif
        </div>

    </div>

    {{-- Combined semester-wise result table --}}

    <div class="table-box results-table-box">

        <table class="results-table">

            <thead>
                <tr>
                    <th>Student</th>
                    <th>Course</th>
                    <th>Semester / Year</th>
                    <th>Subjects and Marks</th>
                    <th>Total Marks</th>
                    <th>Percentage</th>
                    <th>Result  Date</th>
                    <th>Manage</th>
                </tr>
            </thead>

            <tbody>

                @forelse($results as $result)

                    @php
                        $obtained = $result->subjects->sum('marks_obtained');

                        $maximum = $result->subjects->sum('max_marks');


                        $percentage = $maximum > 0
                            ? ($obtained / $maximum) * 100
                            : 0;
                    @endphp

                    <tr>
                        <td>
                            <div class="student-name">
                                {{ $result->student->name ?? 'Student unavailable' }}
                            </div>

                            <div class="student-email">
                                {{ $result->student->email ?? '' }}
                            </div>
                        </td>

                        <td>
                            {{ $result->student->course ?? '-s' }}
                        </td>

                        <td>
                            <span class="semester-badge">
                                {{ $result->semester }}
                            </span>

                            <div class="year-label">
                                {{ $result->academic_year }}    
                            </div>
                        </td>

                        <td class="subject-marks-cell">
                            @forelse($result->subjects as $subject)

                                <div class="subject-mark">

                                    <span>
                                        {{ $subject->subject }}
                                    </span>

                                    <strong>
                                        {{ number_format($subject->marks_obtained, 2) }}
                                        /
                                        {{ number_format($subject->max_marks, 2) }}
                                    </strong>

                                </div>

                            @empty

                                <span class="muted-text">
                                    No subjects entered
                                </span>

                            @endforelse

                        </td>

                        <td>
                            <strong>
                                {{ number_format($obtained, 2) }}
                            </strong>

                            <div class="muted-text">
                                Out of {{ number_format($maximum, 2) }}
                            </div>
                        </td>

                        <td>
                            <span class="percentage-badge">
                                {{ number_format($percentage, 2) }}%
                            </span>
                        </td>

                        <td>
                            {{ $result->result_date
                                ? $result->result_date->format('d M y')
                                : '-' }}
                        </td>

                        <td class="manage-actions">
                            <a href="{{ route('results.show', $result) }}" class="btn btn-small btn-light">
                                View
                            </a>

                            <a href="{{ route('results.edit', $result) }}" class="btn btn-small">
                                Edit Marks
                            </a>

                            <form action="{{ route('results.destroy', $result) }}" method="post" 
                                  class="inline-form"
                                  onsubmit="return confirm('Delete this semester result and its subject marks?');">
                                
                                @csrf
                                @method('DELETE')

                                <button type="submit" class="btn btn-small btn-danger">
                                    Delete
                                </button>

                            </form>
                        </td>
                    </tr>

                    @empty

                        <tr>
                            <td colspan="8" class="empty-state">
                                <strong>No results found.</strong>

                                <span>
                                    Try another semester or academic year, or add a new result. 
                                </span>
                            </td>
                        </tr>

                    @endforelse

            </tbody>

        </table>

    </div>

    <p class="table-note">
        Each row represents one student's result for a semester and academic year, 
        Use Edit Marks to manage student's subjects and marks. 
    </p>

</div>

@endsection