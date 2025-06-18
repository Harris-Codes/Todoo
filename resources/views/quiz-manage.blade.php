<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Manage Quiz</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Styles -->
    <link rel="stylesheet" href="{{ asset('css/teacher.css') }}">
    <link rel="stylesheet" href="{{ asset('css/quiz-manage.css') }}"> {{-- Reuse this CSS --}}
    <link href='https://unpkg.com/boxicons@2.1.1/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
</head>
<body>

@include('partials.sidebar-teacher')

<div class="home">

    <!-- Class Banner -->
    <div class="banner">
        <div class="banner-text">
            <h1>Manage Quiz: {{ $quiz->title }}</h1>
            <p><strong>Classroom:</strong> {{ $quiz->classroom->subject }}</p>
        </div>
    </div>

    <div class="quiz-table-wrapper">
    <h2>List of Students</h2>
    <div class="publish-button-wrapper">
        <form method="POST" action="{{ route('quiz.publish', $quiz->id) }}">
            @csrf
            <button class="btn btn-secondary" type="submit">
                <i class="fa-solid fa-paper-plane"></i> Post Results to Students
            </button>
        </form>
    </div>
    <table class="quiz-table">
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
                    <td>{{ $attempt->created_at->format('d M Y') }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="3">No attempts yet.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

   
</div>


</div>

<script src="{{ asset('js/quiz-manage.js') }}"></script> {{-- Sidebar toggle --}}
</body>
</html>
