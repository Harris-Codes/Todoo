<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="classroom-route" content="{{ route('classroom.store') }}">
    <title>Dashboard Sidebar Menu</title>
    <!-- CSS -->
    <link rel="stylesheet" href="{{ asset('css/teacher.css') }}">
    <!-- Boxicons CSS -->
    <link href='https://unpkg.com/boxicons@2.1.1/css/boxicons.min.css' rel='stylesheet'>

</head>

<body>
    <!-- Sidebar navigation menu -->
    @include('partials.sidebar-teacher')

    <!---------------------------------- Main content section---------------------------- -->
    <section class="home">

        <div class="text">My Classes
            <button class="Join-button" id="openPopup">
                <i class='bx bx-plus-circle join'></i>
                <span class="join-text">Add Classroom</span>
            </button>
        </div>


        <!-- =================== DYNAMIC CARD CONTAINER ===================== -->
        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <div class="card-container">
            @foreach ($classes as $class)
                <div class="card">
                    <div class="image_container" style="background-image: url('/images/{{ $class->background_image }}');">
                    </div>
                    <div class="title">
                        <span>{{ $class->subject }}</span>
                    </div>

                    <div class="creator">
                        <span>{{ Auth::user()->name }}</span>
                    </div>

                    <div class="button-group">
                        <a href="{{ route('classroom.show', $class->id) }}" class="view-button">
                            <span>View Class</span>
                        </a>

                        <form action="{{ route('classroom.destroy', $class->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="delete-button"
                                onclick="return confirm('Are you sure you want to delete this classroom?')">
                                <i class='bx bx-trash-alt icon'></i>
                            </button>
                        </form>
                    </div>
                </div>
            @endforeach
        </div>



        <!-- ================= FOR CREATING NEW CLASSROOM ======================== -->
        <div class="popup-container" id="popupContainer">
            <form class="classroom-form" method="POST" action="{{ route('classroom.store') }}">
                @csrf
                <h2 class="mainHeading">Create New Classroom</h2>


                <!-- Step 1: Background Selection -->
                <div class="step step-1 active">
                    <p class="otpSubheading">Select background first!</p>

                    <!-- Carousel controls -->
                    <div class="bg-image-options" id="imagePageContainer"></div>
                    <div class="image-carousel-controls">
                        <button type="button" class="arrow-btn" onclick="changeImagePage(-1)">&#8592;</button>
                        <span id="imagePageIndicator">1</span>
                        <button type="button" class="arrow-btn" onclick="changeImagePage(1)">&#8594;</button>
                    </div>

                    <button type="button" class="createButton" onclick="goToStep2()">Next</button>
                </div>

                <!-- Step 2: Classroom Name Input -->
                <div class="step step-2" style="display: none;">
                    <p class="otpSubheading">Enter classroom details</p>

                    <label for="classroomName">Classroom Name</label>
                    <input required type="text" name="subject" id="classroomName" class="classroom-input"
                        placeholder="Enter Classroom Name">

                    <button class="createButton" type="submit">Create Classroom</button>
                </div>
            </form>

            @if ($errors->any())
                <div class="error-box">
                    @foreach ($errors->all() as $error)
                        <p style="color: red">{{ $error }}</p>
                    @endforeach
                </div>
            @endif

            @if (session('success'))
                <p style="color: green">{{ session('success') }}</p>
            @endif
        </div>

    </section>

    <!-- JavaScript file -->
    <script src="{{ asset('js/teacher.js') }}"></script>
    <script src="{{ asset('js/script.js') }}"></script>


</body>

</html>