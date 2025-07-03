<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Badge</title>

    <!-- Styles -->
    <link rel="stylesheet" href="{{ asset('css/teacher.css') }}">
    <link rel="stylesheet" href="{{ asset('css/quiz-overview.css') }}">
    <link rel="stylesheet" href="{{ asset('css/badges-create.css') }}">
    <link href='https://unpkg.com/boxicons@2.1.1/css/boxicons.min.css' rel='stylesheet'>
</head>

<body>

    @include('partials.sidebar-teacher')

    <div class="home">
        <div class="banner">
            <div class="banner-text">
                <h1>Create New Badge</h1>
            </div>
        </div>

        <div class="form-wrapper">
            {{-- Flash success or error message --}}
            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            @if (session('error'))
                <div class="alert alert-error">
                    {{ session('error') }}
                </div>
            @endif

            <form action="{{ route('badges.store') }}" method="POST">
                @csrf
                <input type="hidden" name="classroom_id" value="{{ $classroom_id }}">
                <input type="hidden" name="image" id="selectedBadgeImage">

                <!-- Step 1: Carousel Badge Design -->
                <div class="step step-1 active">
                    <p class="otpSubheading">Select a badge design</p>

                    <div class="bg-image-options" id="badgeImagePageContainer"></div>
                    <div class="image-carousel-controls">
                        <button type="button" class="arrow-btn" onclick="changeBadgeImagePage(-1)">&#8592;</button>
                        <span id="badgeImagePageIndicator">1</span>
                        <button type="button" class="arrow-btn" onclick="changeBadgeImagePage(1)">&#8594;</button>
                    </div>

                    <button type="button" class="createButton" onclick="goToBadgeStep2()">Next</button>
                </div>

                <!-- Step 2: Name & Conditions -->
                <div class="step step-2" style="display: none;">
                    <div class="step2-header">
                        <button type="button" class="back-icon-btn" onclick="goToBadgeStep1()">
                            <i class='bx bx-arrow-back'></i>
                        </button>
                        <p class="otpSubheading">Enter badge details</p>
                    </div>


                    <label for="name">Badge Name</label>
                    <input type="text" name="name" class="classroom-input" required>

                    <label for="type">Condition Type</label>
                    <select name="type" class="classroom-input" required>
                        <option value="submission_count">More than X assignment submissions</option>
                        <option value="perfect_quiz">X perfect quiz scores</option>
                        <option value="quiz_count">Total X quiz attempts</option>
                    </select>


                    <label for="condition_value">Condition Value</label>
                    <input type="number" name="condition_value" class="classroom-input" min="1" required>



                    <!-- Existing Submit Button -->
                    <button type="submit" class="createButton">Create Badge</button>
                </div>

            </form>
        </div>
    </div>

    <script src="{{ asset('js/badges-create.js') }}"></script>

</body>

</html>