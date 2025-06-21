<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Welcome to Todoo</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('css/welcome.css') }}">
    <style>
        html {
            scroll-behavior: smooth;
        }
    </style>
</head>
<body>
    <nav class="navbar">
        <div class="logo">
            <img src="{{ asset('images/sidebar-logo.png') }}" alt="Todoo Logo">
        </div>
        <ul class="nav-links">
            <li><a href="#home">Home</a></li>
            <li><a href="#about">About Todoo!</a></li>
            <li><a href="#info">Inside Todoo!</a></li>
        </ul>
        <a href="{{ url('login') }}" class="get-started">Log in</a>
    </nav>

    <!-- Home Section -->
    <main id="home" class="main-content">
        <div class="text-section">
            <h1>
                <span>Join</span><br>
                <span>Todoo!</span>
            </h1>
            <p>Learn, grow, and succeed with your peers in a collaborative online classroom environment.</p>
            <a href="{{ url('register') }}" class="read-more-btn">Join Now!</a>
        </div>
        <div class="image-section">
            <img src="{{ asset('images/homepage.png') }}" alt="Student Community Illustration">
        </div>
    </main>

    <!-- About Section -->
    <section id="about" class="section-content">
    <div class="about-text">
        <h2>About Todoo!</h2>
        <p>
            Todoo! is an interactive learning management system designed for primary students.
            It makes education fun and effective with tools like quizzes, assignments, gamified badges,
            and feedback—all built for collaborative learning.
        </p>
    </div>
    <div class="about-image-placeholder">
        <img src="{{ asset('images/about.png') }}" alt="Info Illustration">
    </div>
</section>


    <!-- Info Section -->
    <section id="info" class="section-content reverse">
        <div class="text-box">
            <h2>Inside Todoo!</h2>
            <p>
                Todoo! is built using Laravel and Blade templating, designed to be scalable and user-friendly for teachers and students. It includes authentication, classroom management, quizzes, assignments, file storage, feedback, and gamification features.
            </p>
        </div>
        <div class="image-box">
            <img src="{{ asset('images/info.png') }}" alt="Info Illustration">
        </div>
    </section>

</body>
</html>
