<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Quiz Page</title>
   
    <!-- CSS -->
    <link rel="stylesheet" href="{{ asset('css/quiz.css') }}">
    <!-- Boxicons CSS -->
    <link href='https://unpkg.com/boxicons@2.1.1/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
</head>

<body>

    <section class ="home">
        
        <header class="creation-header">
            <h1>{{ $quiz->title }}</h1>
        </header>

        <div class="quiz-warning">
            ⚠️ <strong>Do not refresh or close this page!</strong> Your quiz will be submitted immediately.
        </div>

        <main class = "creation-main">  
        </main>

        <!-- Submission Success Modal -->
        <div id="quizCompleteModal" class="badge-overlay">
            <div class="badge-content">
                <h2>Quiz Completed!</h2>
                <p>You answered all the questions.</p>
                <button id="goBackButton">Return to Classroom</button>
            </div>
        </div>


    </section>


<div id="quizData" 
     data-quiz='@json($quizData)' 
     data-quiz-id="{{ $quiz->id }}">
</div>

<div id="classroomMeta" data-classroom-id="{{ $classroom->id }}"></div>
</body>
<script src="{{ asset('js/quiz.js') }}"></script>
</html>
