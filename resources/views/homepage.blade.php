<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="classroom-route" content="{{ route('classroom.store') }}">
    <title>Dashboard Sidebar Menu</title>
    <!-- CSS -->
    <link rel="stylesheet" href="{{ asset('css/homepage.css') }}">
    <!-- Boxicons CSS -->
    <link href='https://unpkg.com/boxicons@2.1.1/css/boxicons.min.css' rel='stylesheet'>
</head>

<body>

    @include('partials.sidebar')

    <!---------------------------------- Main content section---------------------------- -->
    <section class="home">

        <div class="text">My Classes
            <button class="Join-button" id="openPopup">
                <i class='bx bx-plus-circle join'></i>
                <span class="join-text">Join Classroom</span>
            </button>
        </div>

        <div class="card-container">
            @foreach ($joinedClasses as $class)
                <div class="card">
                    <div class="image_container" style="background-image: url('/images/{{ $class->background_image }}');">
                    </div>


                    <div class="title">
                        <span>{{ $class->subject }}</span>
                    </div>

                    <div class="creator">
                        <span>{{ $class->teacher->name }}</span> {{-- Assuming you have teacher() relationship --}}
                    </div>

                    <div class="button-group">
                        <a href="{{ route('student.classroom', $class->id) }}" class="view-button">
                            <span>View Class</span>
                        </a>
                        <form action="{{ route('classroom.leave', [$class->id]) }}" method="POST" style="display: inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="delete-button"
                                onclick="return confirm('Are you sure you want to leave this classroom?')">
                                <i class='bx bx-log-out'></i>
                            </button>
                        </form>
                    </div>
                </div>
            @endforeach
        </div>



        <!-- Pop-up Modal -->
        <div class="popup-container" id="popupContainer">

            <form class="otp-Form" method="POST" action="{{ route('classroom.join') }}">
                @csrf

                <span class="mainHeading">Classroom Code</span>
                <p class="otpSubheading">Enter clasroom code</p>
                <div class="inputContainer">
                    <input required="required" maxlength="1" type="text" class="otp-input" id="otp-input1">
                    <input required="required" maxlength="1" type="text" class="otp-input" id="otp-input2">
                    <input required="required" maxlength="1" type="text" class="otp-input" id="otp-input3">
                    <input required="required" maxlength="1" type="text" class="otp-input" id="otp-input4">
                    <input required="required" maxlength="1" type="text" class="otp-input" id="otp-input5">
                    <input required="required" maxlength="1" type="text" class="otp-input" id="otp-input6">
                    <input type="hidden" name="code" id="fullCode">
                </div>
                <button class="joinButton" type="submit">Join</button>
                <button class="exitBtn">x</button>

            </form>



        </div>

    </section>

    <!-- JavaScript file -->
    <script src="{{ asset('js/script.js') }}"></script>
    <script src="{{ asset('js/homepage.js') }}"></script>

</body>

</html>