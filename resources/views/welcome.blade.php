<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Welcome to Todoo</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('css/welcome.css') }}">
</head>
<body>
    <nav class="navbar">
        <div class="logo">Todoo!</div>
        <ul class="nav-links">
            <li><a href="#">Home</a></li>
            <li><a href="#">About Us</a></li>
            <li><a href="#">Work</a></li>
            <li><a href="#">Info</a></li>
        </ul>
        <a href="{{ url('login') }}" class="get-started">Get Started</a>
    </nav>

    <main class="main-content">
        <div class="text-section">
            <h1>Join Student Communities</h1>
            <p>Learn, grow, and succeed with your peers in a collaborative online classroom environment.</p>
            <a href="{{ url('register') }}" class="read-more-btn">Read More</a>
        </div>
        <div class="image-section">
            <img src="{{ asset('images/student_community.png') }}" alt="Student Community Illustration" class="hero-illustration">

        </div>
    </main>
</body>
</html>
