<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Teacher Dashboard</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Styles -->
    <link rel="stylesheet" href="{{ asset('css/teacher-dashboard.css') }}">
    <link href='https://unpkg.com/boxicons@2.1.1/css/boxicons.min.css' rel='stylesheet'>
</head>
<body>

@include('partials.sidebar-teacher') {{-- Or your sidebar name --}}

<section class="home">

    <header class="header">
        <div class="header-content">
            <img 
                src="{{ Auth::user()->profile_picture_url ?? asset('images/default-profile.png') }}" 
                alt="Profile" 
                class="student-avatar"
            >
            @php
                $nameParts = explode(' ', Auth::user()->name);
                $displayName = $nameParts[1] ?? $nameParts[0];
            @endphp
            <h1><span class="hello">Hello,</span> {{ $displayName }}! 👋🏻</h1>
        </div>
    </header>

    <main class="main">

        <!-- ✅ CLASS OVERVIEW -->
        <div class="card class-overview-card">
            <h1>📚 My Classrooms</h1>
            <div class="card-carousel-wrapper">
                <i class="carousel-btn prev bx bx-chevron-left" onclick="prevCard()"></i>

                <div class="card-content carousel-track" id="teacherClassCarousel">
                    @forelse ($classrooms as $class)
                        <div class="class-slide">
                            <a href="{{ route('teacher.classroom', $class->id) }}" class="class-details">
                                <div class="teacher-image">
                                    <img src="{{ $class->teacher->profile_picture_url ?? asset('images/default-profile.png') }}" alt="Class">
                                </div>
                                <div class="class-text">
                                    <p class="class-subject">{{ $class->subject }}</p>
                                    <p><i class='bx bx-group icon-card'></i> {{ $class->students->count() }} Students</p>
                                    <p><i class="bx bx-book icon-card"></i> {{ $class->assignments->count() }} Assignments</p>
                                </div>
                            </a>
                        </div>
                    @empty
                        <p>No classrooms created yet 😅</p>
                    @endforelse
                </div>

                <i class="carousel-btn next bx bx-chevron-right" onclick="nextCard()"></i>
            </div>
        </div>

        <!-- ✅ PROFILE EDIT -->
        <div class="card student-details-card">
            <h1>👤 Your Profile</h1>
            @if(Auth::user()->profile_picture_url)
                <div style="display: flex; justify-content: center; margin-bottom: 15px;">
                    <img src="{{ asset(Auth::user()->profile_picture_url) }}" alt="Current Profile Picture"
                        style="width: 120px; height: 120px; border-radius: 50%; object-fit: cover; border: 3px solid var(--todoo-color);">
                </div>
            @endif

            <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div style="margin-bottom: 15px;">
                    <label for="name">Name</label>
                    <input class="classroom-input" type="text" name="name" value="{{ old('name', Auth::user()->name) }}" required>
                </div>
                <div style="margin-bottom: 15px;">
                    <label for="email">Email</label>
                    <input class="classroom-input" type="email" name="email" value="{{ old('email', Auth::user()->email) }}" required>
                </div>
                <div style="margin-bottom: 15px;">
                    <label for="profile_picture">Profile Picture</label>
                    <input type="file" name="profile_picture" accept="image/*">
                </div>
                <button class="createButton" type="submit">Update Profile</button>
            </form>

        </div>


        <!-- ✅ RECENT ACTIVITY (Full Width) -->
        <div class="card recent-activity-card full-width-card">
            <h1>📅 Recent Activity</h1>
            <ul class="activity-list">
                @forelse ($activities ?? [] as $activity)
                    <li>
                        <i class='bx bx-bell'></i> {{ $activity->message }}
                        <span class="activity-time">{{ $activity->created_at->diffForHumans() }}</span>
                    </li>
                @empty
                    <p style="padding: 20px;">No activity recorded yet 💤</p>
                @endforelse
            </ul>
        </div>

    </main>
</section>

<script src="{{ asset('js/script.js') }}"></script>
<script src="{{ asset('js/dashboard.js') }}"></script>

</body>
</html>
