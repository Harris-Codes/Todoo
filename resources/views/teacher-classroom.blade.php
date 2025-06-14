<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="csrf-token" content="{{ csrf_token() }}">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Classroom</title>
   
  <!-- CSS -->
  <link rel="stylesheet" href="{{ asset('css/teacher-classroom.css') }}">
  <!-- Boxicons CSS -->
  <link href='https://unpkg.com/boxicons@2.1.1/css/boxicons.min.css' rel='stylesheet'>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">

  
</head>
<body>
    
<!-- Sidebar navigation menu -->
@include('partials.sidebar-teacher')

<!---------------------------------- MAIN CONTENT -------------------------------------------------->
<section class="class-page"> 

    <div class="class-banner">
        <div class="banner-text">
            
            <h1>{{ $classroom->subject }}</h1>
            <p>{{ $classroom->teacher->name }}</p>

        </div>
    </div>

    <div class="navigation-class">

      <button class="tab-link active" onclick="openTab(event, 'posts')">Posts</button>
      <button class="tab-link" onclick="openTab(event, 'files')">FILES</button>
      <button class="tab-link" data-tab="grading" style="display: none;">Grading</button> <!-- Hidden initially -->
      <button class="tab-link" onclick="openTab(event, 'students')">Students</button>  <!-- New Tab -->
    </div>

    <!----------------------------- Tab Content --------------------------------->



    <!------- ========================================= POST TAB ===============================--------->
    <div id="posts" class="tab-content active">
        <div class = "class-container">             
            <!-------------------------- CLASS CODE AND ASSIGNMENT SECTION ------------------>
            <div class="parent-container">
                <div class="class-code-container">
                    <div class="class-code">
                        <h1>Class Code</h1>
                        <h3>{{$classroom->code}}</h3>
                    </div>
                </div>
                    <!---------------------------------- ASSIGNMENT SECTION ------------------------------ -->
                    <div class="assignment-section">
                        <h3>TODOO! </h3>
                        <button id="openAddAssignment" class="add-button"> + Add</button>


                        <table class="assignment-table">
                            @foreach ($classroom->assignments as $assignment)
                            <tr>
                                <td>{{ $assignment->title }}</td>
                                <td>{{ \Carbon\Carbon::parse($assignment->due_date)->format('M d, Y') }}</td>
                                <td>
                                    <div class="action-buttons">
                                        <!--Edit Button-->
                                        <button class="edit-button" 
                                                data-id="{{ $assignment->id }}"
                                                data-title="{{ $assignment->title }}"
                                                data-date="{{ $assignment->due_date }}"
                                                data-desc="{{ $assignment->description }}">
                                            <i class='bx bx-edit'></i>
                                        </button>
                                   
                                        <!-- View Button -->
                                        <button class="view-button" 
                                            data-assignment-id="{{ $assignment->id }}" 
                                            data-assignment-title="{{ $assignment->title }}">
                                            <i class='bx bx-detail'></i>
                                        </button>

                                        <!--Delete Button-->
                                        <form method="POST" action="{{ route('assignments.destroy', $assignment->id) }}" style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button class="delete-button"><i class='bx bx-trash'></i></button>
                                        </form>

                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </table>
                    </div>
            </div>
                                

            <!-------------------------- POST SECTION ------------------>
            <div class = "post-section">
                <!--------------------- CREATE POST ---------------------->
                <div class="create-post-container">
                        <form action="{{ route('posts.store') }}" method="POST">
                            @csrf
                            <input type="hidden" name="classroom_id" value="{{ $classroom->id }}">
                            
                            <div class="post-input" onclick="expandPost()">
                                <img src="{{ asset('storage/' . Auth::user()->profile_picture) }}" class="profile-pic" alt="Profile Picture">
                                <input type="text" id="postInput" placeholder="Announce something to your class" readonly>
                            </div>

                            <div class="post-expanded" id="postExpanded" style="display: none;">
                                <textarea name="content" required ></textarea>
                                <div class="post-actions">
                                    <div class="post-btn-group">
                                        <button type="button" class="cancel-button" onclick="cancelPost()">Cancel</button>
                                        <button type="submit" class="post-button">Post</button>
                                        <a href="{{ route('quiz.create', $classroom->id) }}" class="quiz-button"> Create Quiz</a>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>

                    @foreach ($classroom->posts->sortByDesc('created_at') as $post)
                        <div class="discussion-container">
                            <!-- User Info -->
                            <div class="user-info">
                                <img src="{{ asset('storage/' . $post->user->profile_picture) }}" alt="Profile Picture" class="profile-pic">
                                <div class="user-details">
                                    <span class="user-name">{{ $post->user->name }}</span><br>
                                    <span class="post-time">{{ $post->created_at->format('d/m/Y') }}</span>
                                </div>
                            </div>

                            <!-- Post Content -->
                        
                            <div class="post-content" style="position: relative;">
                                @if ($post->quiz)
                                    <a href="{{ route('quiz.edit', [$classroom->id, $post->quiz->id]) }}" class="quiz-preview-box">
                                        <div class="quiz-card">
                                            <!-- Edit Icon -->
                                            <i class='bx bx-edit-alt edit-quiz-icon'title = 'Edit Quiz'></i>
                                            <i class="fa-regular fa-lightbulb bulb-icon"></i>
                                            <div class="quiz-info">
                                                <strong>{{ $post->quiz->title }}</strong><br>
                                                @php
                                                    $totalSeconds = $post->quiz->timer_seconds ?? 0;
                                                    $minutes = floor($totalSeconds / 60);
                                                    $seconds = $totalSeconds % 60;
                                                @endphp
                                                <span>{{ $post->quiz->total_points ?? 0 }} pts · 
                                                    @if ($minutes > 0)
                                                        {{ $minutes }} min
                                                    @endif
                                                    @if ($seconds > 0)
                                                        {{ $seconds }} sec
                                                    @endif
                                                </span>
                                            </div>
                                        </div>
                                    </a>
                                @else
                                    <p>{{ $post->content }}</p> <!-- fallback for normal post -->
                                @endif

                                <!-- Delete Button -->
                                <form action="{{ route('posts.destroy', $post->id) }}" method="POST" style="position: absolute; top: 10px; right: 10px;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="delete-post-button" title="Delete Post" onclick="return confirm('Are you sure you want to delete this post?')">
                                        <i class='bx bx-trash'></i>
                                    </button>
                                </form>
                            </div>

                            <!-- ✨ Divider ABOVE comments -->
                            <hr style="margin: 15px 0; border: none; border-top: 1px solid #ccc;">

                           <!-- Comment List -->
                            <div class="comment-list">
                                @foreach ($post->comments as $comment)
                                    <div class="comment">
                                        <img src="{{ $comment->user->profile_picture ? asset('storage/' . $comment->user->profile_picture) : asset('images/default-user.png') }}" class="profile-pic">
                                        <div class="comment-details">
                                            <span class="comment-author">{{ $comment->user->name }}</span>
                                            <span class="comment-text">{{ $comment->comment_text }}</span>
                                        </div>
                                    </div>
                                @endforeach
                            </div>


                            <!-- Reply Section -->
                            <div class="reply-section">
                            <button class="reply-btn"><i class="bx bx-message"></i> Reply</button>
                            <form action="{{ route('comments.store') }}" method="POST" class="reply-form">
                                @csrf
                                <input type="hidden" name="post_id" value="{{ $post->id }}">
                                <div class="reply-input-container" style="display: none;">
                                    <input type="text" class="reply-input" name="comment_text" placeholder="Add a class comment..." required>
                                    <button type="submit" class="send-reply-btn">
                                        <i class="fa-solid fa-paper-plane"></i>
                                    </button>
                                </div>
                            </form>
                            </div>
                        </div>
                    @endforeach

                </div>
        </div>
    </div>


      <!------- Grading Tab  --------->
    <div id="grading" class="tab-content">
        <h3 id="grading-title"></h3> 
        <table class="student-table">
            <thead>
                <tr>
                    <th>Student</th>
                    <th>Submitted File</th>
                    <th>Download</th>
                    <th>Grade</th>
                </tr>
            </thead>
            <tbody id="grading-table-body">
            </tbody>
        </table>
    </div>

    <!-------------- FILES TAB--------->
    <div id="files" class="tab-content">
        <button id="backToMainTable" onclick="showMainFileTable()" style="display: none;">
            <i class='bx bx-arrow-back'></i> Back
        </button>

        <div class="folder-header">
            <h2 id="folderTitle">Files</h2>
            <div class="file-buttons"> <!-- Added class here -->
                <button onclick="openFolderModal()" class="add-folder-btn">
                <i class="bx bx-folder-plus"></i> Add Folder
                </button>
                <input type="file" id="uploadInput" style="display: none;" />
                <button onclick="triggerUpload(null)">
                <i class='bx bx-upload'></i> Upload File
                </button>
            </div>
        </div>


        <table class="file-table">
            <thead>
                <tr>
                <th>Name</th>
                <th>Modified</th>
                <th>Modified By</th>
                <th>Action</th> 
                </tr>
            </thead>
            <tbody id="fileTableBody">
                <tr><td colspan="4">Loading...</td></tr>
            </tbody>
        </table>
    </div>

    <!-- FOLDER MODAL -->
    <div id="folderModal" class="modal">
        <div class="modal-content">
            <h2>Create a Folder</h2>
            <input type="text" placeholder="Folder name" id="folderName">
            <button id="createFolderButton" onclick="createFolder()">CREATE</button>
            <span class="close-btn" onclick="closeFolderModal()">✖</span>

        </div>
    </div>

    
    <!------ STUDENT TAB------->
    <div id="students" class="tab-content">
        <button class="add-student-btn" onclick="openStudentModal()">
            <i class='bx bxs-user-plus'></i> Add Student
        </button>

        <h3>Students List</h3>
            <table class="student-table">
                <thead>
                    <tr>
                        <th></th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Remove</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($classroom->students as $student)
                    <tr>
                        <td>photo</td>
                        <td>{{ $student->name }}</td>
                        <td>{{ $student->email }}</td>
                        <td>
                        <form method="POST" action="{{ route('classroom.removeStudent', [$classroom->id, $student->id]) }}">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="delete-student"><i class='bx bx-trash'></i></button>
                        </form>

                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
    </div>


    <!------------------------------ MODAL FOR ASSIGNMENT CREATION ---------------------------------------->
    <div class="modal-student" id="addAssignmentModal">
        <div class="card">
            <span class="close-btn" id="closeAddAssignment">&times;</span>
            <h2>NEW ASSIGNMENT</h2>

            <form id="assignmentForm" method="POST" action="{{ route('assignments.store') }}" enctype="multipart/form-data">
                @csrf
                <input type="hidden" id="assignmentMethod" name="_method" value="POST">
                <input type="hidden" name="classroom_id" value="{{ $classroom->id }}">

                <!-- Assignment Title -->
                <label for="assignmentTitle">Title</label>
                <input type="text" id="assignmentTitle" name="title" required>

                <!-- Due Date -->
                <label for="assignmentDue">Due Date</label>
                <input type="date" id="assignmentDue" name="due_date" required>

                <!-- Description -->
                <label for="assignmentDesc">Description</label>
                <textarea id="assignmentDesc" name="description" required></textarea>

                <!-- Upload Section -->
                <div class="upload-section">
                    <div class="file-upload-container">
                        <!-- Hidden File Input -->
                        <input type="file" name="file" id="fileInput" style="display: none;" />

                        <!-- Custom Upload Button -->
                        <button type="button" id="uploadButton">
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
                        <span id="fileNameDisplay" class="file-name">No file chosen</span>
                    </div>
                </div>

                <!-- Submit Button -->
                <button type="submit" class="submit-button">Add Assignment</button>
            </form>

        </div>
    </div>

    <!-------------------------------------- MODAL FOR STUDENT ADDING ------------------------->
    <div class="modal-student" id="addStudentModal">
    <div class="card">
        <span class="close-btn" onclick="closeStudentModal()">&times;</span>
        <h2>Add New Student</h2>

        <form id="addStudentForm" method ="POST" action="{{ route('classroom.addStudent',$classroom->id) }}">
            @csrf
            <input type="email" name="email" required placeholder ="Student's Email">
            <button type="submit" class="submit-button">Add Student</button>
        </form>
    </div>
    </div>


    
</section>

<!-- JavaScript file -->
<div id="classroomMeta" data-classroom-id="{{ $classroom->id }}"></div>
<script src="{{ asset('js/teacher-classroom.js') }}"></script>

</body>



</html>
