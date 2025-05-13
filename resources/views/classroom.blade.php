<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Classroom</title>
   
  <!-- CSS -->
  <link rel="stylesheet" href="{{ asset('css/classroom.css') }}">
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
            <a href="{{ url('homepage') }}">
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
        
        <!-- Dark mode toggle switch -->
       
      </div>
    </div>
  </nav>

  <!---------------------------------- MAIN CONTENT -------------------------------------------------->
  <section class="class-page"> 

    <div class="class-banner">
        <div class="banner-text">
            <h1> Bahasa Malaysia </h1>
            <p> Fatimah Rosli </p>
        </div>
    </div>

    <div class="navigation-class">

      <button class="tab-link active" onclick="openTab(event, 'posts')">Posts</button>
      <button class="tab-link" onclick="openTab(event, 'files')">Files</button>

    </div>

    <!-- Tab Content -->
    <div id="posts" class="tab-content active">
      <div class = "class-container">
        <!---------------------------------- MODAL BACKGROUND  ----------------------------------->
        <!-- Assignment Modal -->
        <div class="modal" id="assignmentModal">
          <div class="card">
            <span class="close-btn">&times;</span>
            <div class="header">
              <p class="title" id="modalTitle">Assignment Title</p>
              
            </div>

            <div class="description-container">
              <p class="message" id="modalDescription">
                  Assignment description goes here.
              </p>
            </div>

          <!-- Upload Section -->
            <div class="upload-section">
                <!-- Flex Container for Button & File Name -->
                <div class="file-upload-container">
                    <!-- Hidden File Input -->
                    <input type="file" id="fileInput" style="display: none;" />

                    <!-- Custom Upload Button -->
                    <button id="uploadButton">
                        <svg
                            aria-hidden="true"
                            stroke="currentColor"
                            stroke-width="2"
                            viewBox="0 0 24 24"
                            fill="none"
                            xmlns="http://www.w3.org/2000/svg"
                        >
                            <path
                                stroke-width="2"
                                stroke="#ffffff"
                                d="M13.5 3H12H8C6.34315 3 5 4.34315 5 6V18C5 19.6569 6.34315 21 8 21H11M13.5 3L19 8.625M13.5 3V7.625C13.5 8.17728 13.9477 8.625 14.5 8.625H19M19 8.625V11.8125"
                                stroke-linejoin="round"
                                stroke-linecap="round"
                            ></path>
                            <path
                                stroke-linejoin="round"
                                stroke-linecap="round"
                                stroke-width="2"
                                stroke="#ffffff"
                                d="M17 15V18M17 21V18M17 18H14M17 18H20"
                            ></path>
                        </svg>
                        ADD FILE
                    </button>

                    <!-- Display Selected File Name -->
                    <p id="fileNameDisplay" class="file-name">No file chosen</p>
                </div>
            </div>



            <!-------------------------- submit button ------------------------------->
            <div class="actions">
              <button class="submit-btn">Submit</button>
            </div>
            
          </div>
        </div>

        <!---------------------------------- ASSIGMENT SECTION ------------------------------ -->

        <div class="assignment-section">
              <h3>TODOO!</h3>
              <table class="assignment-table">
                  <thead>
                      <tr>
                          <th>Title</th>
                          <th>Due</th>
                          <th>Status</th>
                      </tr>
                  </thead>
                  <tbody>

                    <tr class="clickable-row" data-title="Lukis Bendera Malaysia" data-desc="Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum. Lorem ipsum odor amet, consectetuer adipiscing elit. Convallis ullamcorper faucibus lacus nascetur ad maximus pulvinar faucibus ipsum. Adipiscing auctor mi augue libero egestas ultricies vitae mollis. Praesent phasellus vel mauris pellentesque tristique id. Elementum dis cubilia consequat nascetur nunc. Dolor ultricies adipiscing tincidunt elit vivamus etiam metus suspendisse nullam. Condimentum porta libero dignissim sollicitudin ornare.">
                        <td>Lukis Bendera Malaysia</td>
                        <td>Feb 5, 2025</td>
                        <td><span class="status pending">Pending</span></td>
                    </tr>

                    <tr onclick="location.href='assignment-details.html?task=Karangan';" class="clickable-row">
                        <td>Karangan</td>
                        <td>Feb 12, 2025</td>
                        <td><span class="status completed">Completed</span></td>
                    </tr>
                    
                    <tr onclick="location.href='assignment-details.html?task=Tatabahasa';" class="clickable-row">
                        <td>Tatabahasa</td>
                        <td>Feb 20, 2025</td>
                        <td><span class="status pending">Pending</span></td>
                    </tr>

                    <tr onclick="location.href='assignment-details.html?task=Lukis Bendera Negeri';" class="clickable-row">
                        <td>Lukis Bendera Negeri</td>
                        <td>Feb 20, 2025</td>
                        <td><span class="status pending">Pending</span></td>
                    </tr>

                  </tbody>
              </table>
          </div>

        <!-------------------------- POST SECTION ------------------>
          <div class = "post-section">
                  <div class ="discussion-container">
                    
                    <!------------------- User Info ---------------->
                    <div class = "user-info">
                      <img src="{{ asset('images/bm_teacher.png') }}" alt="Profile Picture" class="profile-pic">
                      <div class = "user-details">
                          <span class ="user-name">Fatimah Rosli</span>
                          <br>
                          <span class ="post-time"> 28/1/2025 </span>
                      </div>
                    </div>

                    <!----------------------- Post Content ---------------------------------->
                    <div class ="post-content">
                        <h3> Kuiz 1 </h3>
                        <p> Salam Sejahtera murid-murid, berikut adalah kuiz 1. Boleh tekan dan jawab. Good luck!</p>

                        <!------------------------- Clickable Quiz Box --------------->
                        <a href="{{ url('quiz') }}" class="quiz-box">
                            <div class="quiz-icon">
                                <i class='bx bx-task'></i>
                            </div>
                            <div class="quiz-text">
                                <h4>Quiz 1</h4>
                                <p>Click to start</p>
                            </div>
                        </a>
                    </div>

                    <!-- Reply Section -->
                    <div class="reply-section">
                        <button class="reply-btn" id="replyBtn">
                            <i class='bx bx-message'></i> Reply
                        </button>

                        <!-- Hidden Reply Input -->
                        <div class="reply-input-container" id="replyInputContainer">
                            <input type="text" id="replyInput" placeholder="Reply..." />
                            <button id="sendReplyBtn"><i class='bx bx-send'></i></button>
                        </div>
                    </div>


                    <!-- Comment Input (Initially Hidden) -->
                    <div class="reply-input-container" id="replyInputContainer" style="display: none;">
                        <input type="text" id="replyInput" class="reply-input" placeholder="Reply...">
                        <button class="send-reply-btn" id="sendReplyBtn">
                          <i class="bx bx-send"></i>
                        </button>
                      </div>

                      <!-- Comments List -->
                      <div class="comment-list" id="commentList">
                        <!-- User Replies Will Appear Here -->
                      </div>

                  </div>



                <!--post 2 content from teachers-->
                <div class ="discussion-container">
                  
                  <!----Post Content -->
                    <div class = "user-info">
                      <img src="{{ asset('images/bm_teacher.png') }}" alt="Profile Picture" class="profile-pic">
                      <div class = "user-details">
                          <span class ="user-name">Fatimah Rosli</span>
                          <br>
                          <span class ="post-time"> 28/1/2025 </span>
                      </div>
                    </div>

                      
                      <div class ="post-content">
                        <h3> Cuti sambutan Tahun Baru Cina </h3>
                        <p> Harap maklum tiada kelas pada 29/1/2025 kerana cuti tahun baru cina. Terima Kasih. </p>

                      </div>

                      <!-- reply section -->
                      <div class="reply-section">
                          <button class="reply-btn">
                              <i class='bx bx-message'></i> Reply
                          </button>
                      </div>


                      

                </div>

                <!--post content from teachers-->
                <div class ="discussion-container">
                  
                  <!----Post Content -->
                    <div class = "user-info">
                      <img src="{{ asset('images/bm_teacher.png') }}" alt="Profile Picture" class="profile-pic">
                      <div class = "user-details">
                          <span class ="user-name">Fatimah Rosli</span>
                          <br>
                          <span class ="post-time"> 28/1/2025 </span>
                      </div>
                    </div>

                      
                      <div class ="post-content">
                        <h3> Cuti sambutan Tahun Baru Cina </h3>
                        <p> Harap maklum tiada kelas pada 29/1/2025 kerana cuti tahun baru cina. Terima Kasih. </p>

                      </div>

                      <!-- reply section -->
                      <div class="reply-section">
                          <button class="reply-btn">
                              <i class='bx bx-message'></i> Reply
                          </button>
                      </div>

                </div>
            </div>
      </div>
    </div>

    <div id="files" class="tab-content">
      <div class="file-header">
          <div class="file-column">
              <i class="bx bx-file"></i> Name
          </div>
          <div class="file-column">Modified </div>
          <div class="file-column">Modified By </div>
          
      </div>

      <div class="file-list">
          <p>No files uploaded yet...</p>
      </div>

    </div>

    
</section>
</body>
<!-- JavaScript file -->
<script src="{{ asset('js/script.js') }}"></script>


</html>
