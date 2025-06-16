<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Create Quiz</title>

    <link rel="stylesheet" href="{{ asset('css/create-quiz.css') }}">
    <link rel="stylesheet" href="{{ asset('css/classroom.css') }}"> 
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
        <div class="quiz-builder-header">

            <div class="quiz-title-wrapper">
                <input type="text" id="quiz-title" placeholder="Enter Quiz Title" value="{{ $quiz->title ?? '' }}">
            </div>

            <div class="quiz-settings">
            </div>
            <div class="action-buttons">
                <button id="save-quiz" class="question-meta">
                    <i class='bx bx-save'></i> Save
                </button>
            </div>
        </div>

        <div class="question-list" id="question-list">
            <!-- Question blocks will be injected here -->
        </div>

        <div class="add-question-container">
            <button id="add-question-btn"><i class='bx bx-plus'></i> Add Question</button>
        </div>
    </div>

    <script src="{{ asset('js/create-quiz.js') }}"></script>
    <div id="classroomMeta" data-classroom-id="{{ $classroom->id }}"></div>
    <div id="quizMeta"
        data-edit-mode="{{ isset($quiz) ? 'true' : 'false' }}"
        data-quiz-id="{{ isset($quiz) ? $quiz->id : '' }}"
        data-questions='@json(isset($transformedQuestions) ? $transformedQuestions : [])'>
    </div>

    </div>

</body>
</html>
