<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Dashboard Sidebar Menu</title>
  <!-- CSS -->
  <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
  <!-- Boxicons CSS -->
  <link href='https://unpkg.com/boxicons@2.1.1/css/boxicons.min.css' rel='stylesheet'>
</head>
<body>

@include('partials.sidebar')

<section class="home">

<header class="header">
    <div class="header-content">
        <!-- Use profile_picture_url if available -->
        <img 
            src="{{ Auth::user()->profile_picture_url ?? asset('images/student-boy.png') }}" 
            alt="Student Profile" 
            class="student-avatar"
        >

        <!-- Show second name if exists, fallback to full name -->
        @php
            $nameParts = explode(' ', Auth::user()->name);
            $displayName = $nameParts[1] ?? $nameParts[0]; // Show second name if exists
        @endphp

        <h1><span class="hello">Hello,</span> {{ $displayName }}! 👋🏻</h1>
    </div>
</header>


<main class="main">

  <!--================ CLASS OVERVIEW =================-->
  <!-- Inside your <main class="main"> -->
  <div class="card class-overview-card">
    <h1>📚 Class Overview</h1>
    <div class="card-content">
        <!-- Left Arrow -->
        <div class="arrow left-arrow" onclick="prevCard()">
            <i class='bx bx-chevron-left'></i>
        </div>

        <!-- Class Slides (Only One Visible at a Time) -->
        <div class="class-carousel">
            @foreach($classrooms as $index => $class)
            <div class="class-slide" style="display: none;" data-index="{{ $index }}">
              <a href="{{ route('student.classroom', ['id' => $class->id]) }}" class="class-details" style="text-decoration: none; color: inherit;">
                  <!-- Profile Picture -->
                  <div class="teacher-image">
                      <img src="{{ $class->teacher->profile_picture_url ?? asset('images/default-profile.png') }}" alt="Teacher Profile">
                  </div>

                  <!-- Class Info -->
                  <div class="class-text">
                      <p class="class-subject">{{ $class->subject }}</p>
                      <p><i class='bx bx-user icon-card'></i> {{ $class->teacher->name }}</p>
                      <p><i class="bx bx-book icon-card"></i> {{ $class->assignments->count() }} Assignments</p>
                      <p><i class="bx bx-group icon-card"></i> {{ $class->students->count() }} Students</p>
                  </div>
              </a>
          </div>

            @endforeach
        </div>

        <!-- Right Arrow -->
        <div class="arrow right-arrow" onclick="nextCard()">
            <i class='bx bx-chevron-right'></i>
        </div>
    </div>
</div>


  </div>

  <!-- ✅ STUDENT DETAILS (Right Side - Top) -->
  <div class="card student-details-card">
      <h1>👤 Your Details</h1>

      @if(session('success'))
          <div style="background-color: #d4edda; color: #155724; padding: 10px; border-radius: 6px; margin-bottom: 10px;">
              {{ session('success') }}
          </div>
      @endif

      <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data" style="display: flex; flex-direction: column; gap: 15px;">
          @csrf

          <!-- Name -->
          <div>
              <label for="name">Name</label>
              <input class="classroom-input" type="text" id="name" name="name" value="{{ old('name', Auth::user()->name) }}" required>
          </div>

          <!-- Email -->
          <div>
              <label for="email">Email</label>
              <input class="classroom-input" type="email" id="email" name="email" value="{{ old('email', Auth::user()->email) }}" required>
          </div>

          <!-- Profile Picture -->
          <div>
              <label for="profile_picture">Profile Picture</label>
              <input type="file" name="profile_picture" accept="image/*">
              @if(Auth::user()->profile_picture_url)
                  <img src="{{ asset(Auth::user()->profile_picture_url) }}" alt="Current Picture" style="margin-top: 10px; width: 100px; height: 100px; object-fit: cover; border-radius: 8px;">
              @endif
          </div>

          <!-- Submit Button -->
          <button class="createButton" type="submit">Update Profile</button>
      </form>
  </div>


  <!-- ✅ FEEDBACK (Right Side - Bottom) -->
  <div class="card feedback-card">
    <div class="feedback-container">
      <h1>📝 Feedback</h1>

      @forelse($feedbacks as $feedback)
        <div class="feedback-card">
          <img src="{{ $feedback->teacher->profile_picture_url ?? asset('images/default-profile.png') }}" alt="{{ $feedback->teacher->name }}">
          <div class="feedback-content">
            <h4>👨‍🏫 {{ $feedback->teacher->name }}</h4>
            <p>{{ $feedback->message }}</p>
          </div>
        </div>
      @empty
        <p style="padding: 20px;">No feedback yet 💤</p>
      @endforelse

    </div>
  </div>



  <!-- ✅ BADGES Still Working -->
  <div class="card badges-card">
    <h1>🏅 Recent Achievement</h1>
    <div class="badge-carousel-container">
      <div class="badge-arrow left" onclick="prevBadgeSlide()">
        <i class='bx bx-chevron-left'></i>
      </div>

      <div class="badge-grid" id="badgeGrid">
        @forelse ($badges as $badge)
          <div class="badge">
              <img src="{{ asset('images/' . $badge->image) }}" alt="{{ $badge->name }}">
              <p>{{ $badge->name }}</p>
          </div>
        @empty
          <p style="padding: 10px;">No badges yet! 💤</p>
        @endforelse
      </div>

      <div class="badge-arrow right" onclick="nextBadgeSlide()">
        <i class='bx bx-chevron-right'></i>
      </div>
    </div>
  </div>




</main>

</section>

<script src="{{ asset('js/script.js') }}"></script>
<script src="{{ asset('js/dashboard.js') }}"></script>

</body>
</html>
