<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quiz Page</title>
   
    <!-- CSS -->
    <link rel="stylesheet" href="{{ asset('css/quiz.css') }}">
    <!-- Boxicons CSS -->
    <link href='https://unpkg.com/boxicons@2.1.1/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
</head>

<body>

    <section class ="home">
        
        <!-- Header with Quiz Title -->
        <header class = "creation-header">
            <h1>General Knowledge Quiz</h1>
        </header>

        <main class = "creation-main">  

            <h1 id="question-title">QUESTION 1</h1>

            <!-- Question Box -->
            <div class="question-container">
                <p class="question">What is the capital of France?</p>
            </div>

            <!-- Answer Choices (Styled as Buttons) -->
            <div class="answer-container">
                <button class="answer-btn" data-answer="0">Berlin</button>
                <button class="answer-btn" data-answer="1">Madrid</button>
                <button class="answer-btn correct" data-answer="2">Paris</button> <!-- Correct Answer -->
                <button class="answer-btn" data-answer="3">Rome</button>
            </div>


           

        </main>

        <!-- Badge Modal -->
        <div id="badgeModal" class="badge-overlay">
            <div class="badge-content">
                <img src="{{ asset('images/badge-1.png') }}" alt="Badge" class="badge-image">
                <h2>Quiz Champion!</h2>
                <p>Complete 5 quizzes with full marks!</p>
                <button id="closeBadge">Close</button>
            </div>
        </div>


    </section>

</body>
<script src="{{ asset('js/quiz.js') }}"></script>
</html>
