<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Badge Overview</title>

    <!-- Reuse styles -->
    <link rel="stylesheet" href="{{ asset('css/teacher.css') }}">
    <link rel="stylesheet" href="{{ asset('css/quiz-overview.css') }}"> 
    <link href='https://unpkg.com/boxicons@2.1.1/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
</head>

<body>

@include('partials.sidebar-teacher')

<div class="home">
    <div class="banner">
        <div class="banner-text">
            <h1>Badge Management</h1>
        </div>
    </div>

    <div class="dropdown-content">
        <form method="GET" action="{{ route('badges.index') }}">
            <label for="classroom">Filter by Classroom:</label>
            <select name="classroom_id" id="classroom" onchange="this.form.submit()">
                <option value="">-- Select Classroom --</option>
                @foreach ($teacherClassrooms as $class)
                    <option value="{{ $class->id }}" {{ request('classroom_id') == $class->id ? 'selected' : '' }}>
                        {{ $class->subject }}
                    </option>
                @endforeach
            </select>
        </form>
    </div>

    @if(session('success'))
        <div class="alert alert-success" style="margin: 20px 50px; padding: 12px 16px; background-color: #d4edda; color: #155724; border-radius: 8px;">
            {{ session('success') }}
        </div>
    @endif

    @if(request()->has('classroom_id') && request('classroom_id') != '')
        <div class="quiz-overview-container">
            <div style="display: flex; justify-content: space-between; align-items: center;">
                <h2>Your Badges</h2>
                <a href="{{ route('badges.create', request('classroom_id')) }}" class="btn btn-create">
                    <i class='bx bx-plus-medical'></i> Create New Badge
                </a>
            </div>

            <table class="quiz-table">
                <thead>
                    <tr>
                        <th>Badge Name</th>
                        <th>Condition Type</th>
                        <th>Requirement</th>
                        <th>Created</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($badges as $badge)
                        <tr>
                            <td>{{ $badge->name }}</td>
                            <td>{{ ucfirst(str_replace('_', ' ', $badge->type)) }}</td>
                            <td>
                                @if ($badge->type === 'submissions')
                                    ≥ {{ $badge->condition_value }} Submissions
                                @elseif ($badge->type === 'perfect_quizzes')
                                    {{ $badge->condition_value }} Perfect Quiz Scores
                                @elseif ($badge->type === 'quiz_attempts')
                                    {{ $badge->condition_value }} Total Quiz Attempts
                                @else
                                    {{ $badge->condition_value }}
                                @endif
                            </td>
                            <td>{{ $badge->created_at->format('d M Y') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" style="text-align: center;">No badges created for this class.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    @endif
</div>
<script src="{{ asset('js/badges-create.js') }}"></script>
</body>
</html>
