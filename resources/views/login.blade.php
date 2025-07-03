<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <link rel="stylesheet" href="{{ asset('css/login.css') }}">
</head>

<body>
    <div class="container">
        <!-- Left Section -->
        <div class="left-section">
            <div class="welcome-text">
                <span class="hello">Hello,</span><br>
                <span class="welcome">welcome!</span>
            </div>

            <form action="{{ url('/login') }}" method="POST">
                @csrf

                @if ($errors->any())
                    <div class="error-box">
                        @foreach ($errors->all() as $error)
                            <p style="color: red">{{ $error }}</p>
                        @endforeach
                    </div>
                @endif

                <label for="email">Email</label>
                <input type="text" id="email" name="email" placeholder="Email Address" required>

                <label for="pwd">Password</label>
                <input type="password" id="pwd" name="password" placeholder="Password" required>

                <a href="{{ url('forgot-password') }}" id="forgot">Forgot Password?</a>
                <input type="submit" value="Login">
                <h3>Don't have an account? <a href="{{ url('register') }}" id="new">Create Account!</a></h3>
            </form>

        </div>


    </div>

    <!-- Right Section -->
    <div class="Containerforgraphic">

        <div class="right-section">
            <img src="{{ asset('images/todoo logo.png') }}" alt="Graphic">
        </div>

    </div>

</body>

</html>