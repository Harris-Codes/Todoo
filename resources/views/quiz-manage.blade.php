<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Manage Quiz</title>
    <link rel="stylesheet" href="{{ asset('css/quiz-manage.css') }}">
</head>
<body>

    @include('partials.sidebar-teacher')

    <div class="quiz-manage-container" style="margin-left: 250px; padding: 20px;">
        <h2>Manage Quiz: {{ $quiz->title }}</h2>
        <p><strong>Classroom:</strong> {{ $quiz->classroom->subject }}</p>

        <table class="table">
            <thead>
                <tr>
                    <th>Student Name</th>
                    <th>Score</th>
                    <th>Submitted At</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($quiz->attempts as $attempt)
                    <tr>
                        <td>{{ $attempt->user->name }}</td>
                        <td>{{ $attempt->score }}</td>
                        <td>{{ $attempt->created_at->format('d M Y H:i') }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3">No attempts yet.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <form method="POST" action="{{ route('quiz.publish', $quiz->id) }}">
            @csrf
            <button class="btn btn-success mt-3" type="submit">📢 Post Results to Students</button>
        </form>
    </div>

</body>
</html>
