<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password</title>
    <link rel="stylesheet" href="CSS/forgot-password.css">
</head>
<body>
    <div class="container">
        <div class="forgot-password-section">
            <h2>Forgot Password</h2>
            <p>Enter your email address to reset your password:</p>
            <form>
                <label for="email">Email</label>
                <input type="email" id="email" name="email" placeholder="Email Address" required>
                <input type="submit" value="Send Reset Link">
            </form>
            <a href="{{ url('login') }}" class="back-to-login">Back to Login</a>
        </div>
    </div>
</body>
</html>
