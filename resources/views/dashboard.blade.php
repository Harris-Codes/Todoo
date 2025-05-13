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
  <!-- Sidebar navigation menu -->
  <nav class="sidebar close">
    <!-- Sidebar header containing logo and toggle button -->
    <header>
      <div class="image-text">
        <span class="image">
            <img src="{{ asset('images/sidebar-logo.png') }}" alt="Graphic">
        </span>
        <div class="text logo-text">
          <span class="name">Student</span>
          <span class="profession">Harris</span>
        </div>
      </div>
      <i class='bx bx-chevron-right toggle'></i>
    </header>

    <!-- Sidebar menu items -->
    <div class="menu-bar">
      <div class="menu">
        <!-- Search box within the sidebar -->
        
        <!-- List of menu links -->
        <ul class="menu-links">
          <li class="nav-link">
            <a href="{{ url ('dashboard')}}">
                <i class='bx bxs-dashboard icon' ></i>
              <span class="text nav-text">Dashboard</span>
            </a>
          </li>
          <li class="nav-link">
            <a href="{{ url ('homepage')}}">
                <i class='bx bx-book-content icon' ></i>
              <span class="text nav-text">My Classes</span>
            </a>
          </li>
        </ul>
      </div>

      <!-- Bottom content of the sidebar -->
      <div class="bottom-content">
        <li>
          <a href="{{ url ('login')}}">
            <i class='bx bx-log-out icon'></i>
            <span class="text nav-text">Logout</span>
          </a>
        </li>
        
      
        
      </div>
    </div>
  </nav>

  <!---------------------------------- Main content section---------------------------- -->
<section class="home">

<header class="header">
    <div class="header-content">
        <!-- Student Image -->
        <img src="{{ asset('images/student-boy.png') }}" alt="Student Profile" class="student-avatar">
        
        <!-- Greeting Message -->
        <h1><span class="hello">Hello,</span> Harris! 👋🏻</h1>
    </div>
</header>


  

  <main class="main">
  

    <!--====================== CLASS CARDS ========================---->
    
    <div class="card">
      
      <h1>📚 Class Overview</h1>
      
      <div class ="card-content">
              <!-- Left Arrow -->
            <div class="arrow left-arrow" onclick="prevCard()">
                <i class='bx bx-chevron-left'></i>
            </div>

            <!-- Teacher Image -->
            <div class="teacher-image">
                <img id="teacherImage" src="{{ asset('images/bm_teacher.png') }}" alt="Teacher Profile">
            </div>

            <!-- Class Information -->
            <div class="class-info">
                <h3 id="className" class="class-name">Bahasa Malaysia</h3>

                <!-- Class Details -->
                <div class="class-details">
                    <p class="teacher-info">
                        <i class='bx bx-user icon-card'></i>
                        <span id="teacherName" class="teacher-name"><b>Fatimah Rosli</b></span>
                    </p>
                    <p>
                        <i class="bx bx-book icon-card"></i>
                        <span id="assignmentCount">5</span> Assignments Due
                    </p>
                    <p>
                        <i class="bx bx-group icon-card"></i>
                        <span id="studentCount">312</span> Students
                    </p>
                </div>
          </div>

          <!-- Right Arrow -->
          <div class="arrow right-arrow" onclick="nextCard()">
              <i class='bx bx-chevron-right'></i>
          </div>


      </div>

    </div>

    <div class="card">
      <h1>📝 FeedBack</h1>

      <div class="feedback-container">

        <!-- Teacher 1 Comment -->
        <div class="feedback-card">
            <img src="{{ asset('images/bm_teacher.png') }}" alt="Teacher 1">
            <div class="feedback-content">
                <h4>👩‍🏫 Fatimah Rosli</h4>
                <p>Great job on your test! 🎉 Keep it up! </p>
            </div>
        </div>

        <!-- Teacher 2 Comment -->
        <div class="feedback-card">
            <img src="{{ asset('images/bm_teacher.png') }}" alt="Teacher 2">
            <div class="feedback-content">
                <h4>👨‍🏫 Fatimah Rosli</h4>
                <p>Try to read more books 📚 to improve your vocabulary!</p>
            </div>
        </div>

        <!-- Teacher 3 Comment -->
        <div class="feedback-card">
            <img src="{{ asset('images/math_teacher.png') }}" alt="Teacher 3">
            <div class="feedback-content">
                <h4>👩‍🏫 Stephena Hawking</h4>
                <p>You're improving in math! ✨ Let's practice multiplication! </p>
            </div>
        </div>
      </div>
    </div>
    
    <div class="card">
        <h1>🏅 Recent Achievement</h1>
        <div class="badge-container">
          
          <div class="badge-grid">
              <div class="badge">
                  <img src="{{ asset('images/badge-1.png') }}" alt="Badge 1">
                  <p>Top Performer</p>
              </div>
              <div class="badge">
                  <img src="{{ asset('images/badge-1.png') }}" alt="Badge 2">
                  <p>Perfect Attendance</p>
              </div>
              <div class="badge">
                  <img src="{{ asset('images/badge-1.png') }}" alt="Badge 3">
                  <p>Assignment Master</p>
              </div>
              <div class="badge">
                  <img src="{{ asset('images/badge-1.png') }}" alt="Badge 4">
                  <p>Quiz Champion</p>
              </div>

              <div class="badge">
                  <img src="{{ asset('images/badge-1.png') }}" alt="Badge 5">
                  <p>Top Performer</p>
              </div>
              <div class="badge">
                  <img src="{{ asset('images/badge-1.png') }}" alt="Badge 6">
                  <p>Perfect Attendance</p>
              </div>
           
          </div>
      </div>
    </div>
    
  </main>

    
    

</section>

  <!-- JavaScript file -->
  <script src="{{ asset('js/script.js') }}"></script>
  <script src="{{ asset('js/dashboard.js') }}"></script>

</body>
</html>