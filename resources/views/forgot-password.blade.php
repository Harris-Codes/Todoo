<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Reset Password</title>
  <link rel="stylesheet" href="{{ asset('css/forgot-password.css') }}">
</head>
<body>
  <div class="container">
    <div class="forgot-password-section">
      <h2>Reset Your Password</h2>
      <p>Fill in your information to set a new password:</p>

      @if(session('status'))
        <p style="color: green;">{{ session('status') }}</p>
      @endif

      @if(session('error'))
        <p style="color: red;">{{ session('error') }}</p>
      @endif

        <form method="POST" action="{{ route('reset.password.submit') }}">
            @csrf
            <label for="email">Email</label>
            <input type="email" id="email" name="email" placeholder="Email Address" required>

            <label for="password">New Password</label>
            <input type="password" id="password" name="password" placeholder="New Password" required>

            <label for="password_confirmation">Confirm Password</label>
            <input type="password" id="password_confirmation" name="password_confirmation" placeholder="Confirm Password" required>

            <input type="submit" value="Reset Password">
        </form>


      <a href="{{ url('login') }}" class="back-to-login">Back to Login</a>
    </div>
  </div>
</body>
</html>
