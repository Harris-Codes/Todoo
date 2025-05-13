<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register Page</title>
    <link rel="stylesheet" href="{{ asset('css/register.css') }}">
</head>
<body>
    <div class="container">
        <!-- Left Section -->
        <div class="left-section">
            <h1>Register</h1>

            <!-- Laravel form for registration -->
            <form action="{{ url('/register') }}" method="POST" enctype="multipart/form-data">
            @csrf

                <!-- Show validation errors, if any -->
                @if ($errors->any())
                    <div class="error-box">
                        @foreach ($errors->all() as $error)
                            <p style="color: red">{{ $error }}</p>
                        @endforeach
                    </div>
                @endif

                <!-- Full Name -->
                <label for="name">Full Name</label>
                <input type="text" id="name" name="name" placeholder="Your Name" required>

                <!-- Email -->
                <label for="email">Email</label>
                <input type="text" id="email" name="email" placeholder="Email Address" required>

                <!-- Role Selection -->
                <label for="role">Role</label>
                <select name="role" id="role" required>
                    <option disabled selected value="">Select Role</option>
                    <option value="Student">Student</option>
                    <option value="Teacher">Teacher</option>
                </select>
                <p>Selected Role: {{ old('role') }}</p>

                <!--Uploading Profile Picture-->
                <div class="field">
                    <label for="profile_picture">Profile Picture</label>
                    <input type="file" name="profile_picture" id="profile_picture" accept="image/*">
                </div>


                <!-- Password -->
                <label for="password">Password</label>
                <input type="password" id="password" name="password" placeholder="Password" required>

                <!-- Confirm Password -->
                <label for="password_confirmation">Confirm Password</label>
                <input type="password" id="password_confirmation" name="password_confirmation" placeholder="Confirm Password" required>

                <!-- Submit Button -->
                <input type="submit" value="Sign Up">

                <!-- Link to Login -->
                <h3>Have an account? <a href="{{ url('login') }}" id="new">Login here!</a></h3>
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
