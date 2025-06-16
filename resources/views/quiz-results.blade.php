<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Quiz Results - {{ $quiz->title }}</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="{{ asset('css/quiz-results.css') }}">
    <link href='https://unpkg.com/boxicons@2.1.1/css/boxicons.min.css' rel='stylesheet'>
</head>
<body>

    <section class="result-section">
        @if (session('success'))
            <div class="alert-success">
                {{ session('success') }}
            </div>
        @endif

        <div class="header">
            <h1>{{ $quiz->title }}</h1>
            <p>Classroom: {{ $quiz->classroom->subject }}</p>
        </div>

        <div class="result-controls">
            @if (!$quiz->is_published)
                <form method="POST" action="{{ route('teacher.quiz.publish', $quiz->id) }}">
                    @csrf
                    <button type="submit" class="publish-button">
                        <i class="bx bx-upload"></i> Post Results to Classroom
                    </button>
                </form>
            @else
                <div class="published-status">
                    <i class="bx bx-check-circle"></i> Results already posted to classroom.
                </div>
            @endif
        </div>

        <table class="results-table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Student Name</th>
                    <th>Score</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($quiz->attempts as $index => $attempt)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $attempt->user->name }}</td>
                        <td>{{ $attempt->score }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3">No students have attempted this quiz yet.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </section>

</body>
</html>
