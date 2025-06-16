<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quiz Overview</title>
    
    <!-- Styles -->
    <link rel="stylesheet" href="{{ asset('css/classroom.css') }}"> {{-- Uses same styling as other pages --}}
    <link rel="stylesheet" href="{{ asset('css/quiz-overview.css') }}"> {{-- Additional quiz-specific styles --}}
    <link href='https://unpkg.com/boxicons@2.1.1/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
</head>

<body>
   
    @include('partials.sidebar-teacher')

   
    <div class="class-page"> 
        <div class = "banner">
            <div class = "banner-text">
            <h1>Quiz Management</h1>
            </div>
            
        </div>
       
       

         <div class="dropdown-content">

                <form method="GET" action="{{ route('quiz.overview') }}">
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

            @if(request()->has('classroom_id') && request('classroom_id') != '')
                <div class="quiz-overview-container">
                    <div style="display: flex; justify-content: space-between; align-items: center;">
                        <h2>Your Quizzes</h2>
                        <a href="{{ route('quiz.create', request('classroom_id')) }}" class="btn btn-create">
                        <i class='bx bx-plus-medical' ></i> Create New Quiz
                        </a>
                    </div>

                    <table class="quiz-table">
                        <thead>
                            <tr>
                                <th>Quiz Title</th>
                                <th>Classroom</th>
                                <th>Created</th>
                                <th>Points</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($quizzes as $quiz)
                                <tr>
                                    <td>{{ $quiz->title }}</td>
                                    <td>{{ $quiz->classroom->subject }}</td>
                                    <td>{{ $quiz->created_at->format('d M Y') }}</td>
                                    <td>{{ $quiz->total_points }}</td>
                                    <td>
                                        <div class="action-buttons">
                                            <a href="{{ route('quiz.edit', [$quiz->classroom_id, $quiz->id]) }}" class="btn btn-sm btn-primary">
                                                <i class='bx bx-edit'></i>
                                            </a>
                                            <a href="{{ route('quiz.manage', $quiz->id) }}" class="btn btn-sm btn-secondary">
                                                <i class='bx bx-detail'></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif

    </div>

    {{-- Scripts --}}
    <script src="{{ asset('js/sidebar-toggle.js') }}"></script> {{-- Your main toggle script --}}
    <script src="{{ asset('js/quiz-overview.js') }}"></script> {{-- Optional: JS for table/filters etc --}}
</body>
</html>
