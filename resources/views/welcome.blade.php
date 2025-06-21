<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Welcome to Todoo</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('css/welcome.css') }}">
</head>
<body>
    <div class="welcome-container">
        <div class="welcome-content">
            <h1>Welcome to <span class="brand">Todoo!</span></h1>
            <p>A fun and simple classroom system for primary students and teachers.</p>
            <div class="button-group">
                <a href="{{ url('/login') }}" class="btn">Login</a>
                <a href="{{ url('/register') }}" class="btn outline">Create Account</a>
            </div>
        </div>
    </div>
</body>
</html>
