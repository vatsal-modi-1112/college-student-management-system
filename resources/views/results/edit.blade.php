@extends('layouts.app')

@section('content')

<div class="container form-container">

    <h2>Edit Semester Result</h2>

    @if($errors->any())
        <div class="alert-error">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('results.update', $result) }}" method="POST">

        @csrf
        @method('PUT')

        <div class="form-group">
            <label>Student:</label>

            <select name="student_id" required>

                @foreach($students as $student)
                    <option value="{{ $student->id }}"
                        @selected(old('student_id', $result->student_id) == $student->id)>
                        {{ $student->name }} ({{ $student->email }})
                    </option>
                @endforeach

            </select>
        </div>

        <div class="form-group">
            <label>Semester:</label>

            <input type="text"
                   name="semester"
                   value="{{ old('semester', $result->semester) }}"
                   required>
        </div>

        <div class="form-group">
            <label>Academic Year:</label>

            <input type="text"
                   name="academic_year"
                   value="{{ old('academic_year', $result->academic_year) }}"
                   required>
        </div>

        <div class="form-group">
            <label>Result Date:</label>

            <input type="date"
                   name="result_date"
                   value="{{ old('result_date', $result->result_date->format('Y-m-d')) }}"
                   required>
        </div>

        <h3>Subject Marks</h3>

        <div id="subjects-container">

            @foreach($result->subjects as $i => $subject)

                <div class="subject-row">

                    <div class="form-group">
                        <label>Subject Name:</label>

                        <input type="text"
                               name="subjects[{{ $i }}][subject]"
                               value="{{ $subject->subject }}"
                               required>
                    </div>

                    <div class="form-group">
                        <label>Marks Obtained:</label>

                        <input type="number"
                               name="subjects[{{ $i }}][marks_obtained]"
                               value="{{ $subject->marks_obtained }}"
                               min="0"
                               step="0.01"
                               required>
                    </div>

                    <div class="form-group">
                        <label>Maximum Marks:</label>

                        <input type="number"
                               name="subjects[{{ $i }}][max_marks]"
                               value="{{ $subject->max_marks }}"
                               min="0.01"
                               step="0.01"
                               required>
                    </div>

                    <button type="button" class="btn btn-danger remove-subject">
                        Remove Subject
                    </button>

                    <hr>

                </div>

            @endforeach

        </div>

        <button type="button" id="add-subject" class="btn">
            + Add Subject
        </button>

        <br><br>

        <button type="submit" class="btn">
            Update Result
        </button>

        <a href="{{ route('results.index') }}" class="btn btn-secondary">
            Cancel
        </a>

    </form>

</div>

<script>
    let subjectIndex = {{ $result->subjects->count() }};

    document.getElementById('add-subject')?.addEventListener('click', function () {

        const container = document.getElementById('subjects-container');
        const row = document.createElement('div');

        row.className = 'subject-row';

        row.innerHTML = `
            <div class="form-group">
                <label>Subject Name:</label>
                <input type="text" name="subjects[${subjectIndex}][subject]" required>
            </div>

            <div class="form-group">
                <label>Marks Obtained:</label>
                <input type="number" name="subjects[${subjectIndex}][marks_obtained]"
                       min="0" step="0.01" required>
            </div>

            <div class="form-group">
                <label>Maximum Marks:</label>
                <input type="number" name="subjects[${subjectIndex}][max_marks]"
                       value="100" min="0.01" step="0.01" required>
            </div>

            <button type="button" class="btn btn-danger remove-subject">
                Remove Subject
            </button>
            <hr>
        `;

        container.appendChild(row);
        subjectIndex++;
    });

    document.getElementById('subjects-container')?.addEventListener('click', function (event) {

        if (event.target.classList.contains('remove-subject')) {

            const rows = this.querySelectorAll('.subject-row');

            if (rows.length > 1) {
                event.target.closest('.subject-row').remove();
            } else {
                alert('At least one subject is required.');
            }
        }
    });
</script>

@endsection