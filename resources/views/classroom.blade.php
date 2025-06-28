<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>Classroom</title>

  <!-- CSS -->
  <link rel="stylesheet" href="{{ asset('css/classroom.css') }}">
  <link href='https://unpkg.com/boxicons@2.1.1/css/boxicons.min.css' rel='stylesheet'>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

</head>
<body>

@include('partials.sidebar')

<section class="class-page"> 
  <div class="class-banner">
    <div class="banner-text">
      <h1>{{ $classroom->subject }}</h1>
      <p>{{ $classroom->teacher->name }}</p>
    </div>
  </div>

  <div class="navigation-class">
    <button class="tab-link active" onclick="openTab(event, 'posts')">Posts</button>
    <button class="tab-link" onclick="openTab(event, 'files')">Files</button>
  </div>

  <!-- ==================== POSTS TAB ==================== -->
  <div id="posts" class="tab-content active">
      <div class="class-container">
      <div class ="left-panel">

          <!---------------- ASSIGNMENT SECTION ------------------------>
        <div class="assignment-section">
          <h3>TODOO!</h3>
          <div class="table-scroll">
            <table class="assignment-table">
              <thead>
                <tr>
                  <th>Title</th>
                  <th>Due</th>
                  <th>Status</th>
                </tr>
              </thead>
              <tbody>
                @foreach ($classroom->assignments as $assignment)
                  @php
                    $submission = $assignment->submissions->where('student_id', auth()->id())->first();
                  @endphp
                  
                  <tr class="clickable-row"
                    data-id="{{ $assignment->id }}"
                    data-title="{{ $assignment->title }}"
                    data-desc="{{ $assignment->description }}"
                    data-grade="{{ $submission?->grade }}"
                    data-attachment="{{ $assignment->file_path ?? '' }}"
                    data-due="{{ $assignment->due_date }}">

                      <td>{{ $assignment->title }}</td>
                      <td>{{ \Carbon\Carbon::parse($assignment->due_date)->format('M d, Y') }}</td>
                      <td>
                        @if ($submission && $submission->grade)
                          <span class="status graded">Graded</span>
                        @elseif ($submission)
                          <span class="status submitted">Submitted</span>
                        @else
                          <span class="status pending">Pending</span>
                        @endif
                      </td>

                  </tr>
                @endforeach
              </tbody>
            </table>
          </div>
        </div>

        <!-- QUIZ RESULTS SECTION -->
        <div class="result-section" style="margin-top: 30px;">
          <h3>Quiz Results</h3>
          <div class="table-scroll">
            <table class="result-table">
              <thead>
                <tr>
                  <th>Title</th>
                  <th>Score</th>
                </tr>
              </thead>
              <tbody>
                @forelse ($quizResults as $result)
                <tr class="clickable-result-row" data-quiz-id="{{ $result->quiz->id }}">
                  <td>{{ $result->quiz->title }}</td>
                  <td>{{ $result->score }} / {{ $result->quiz->total_points }}</td>
                </tr>
                @empty
                  <tr>
                    <td colspan="3">No quiz results yet.</td>
                  </tr>
                @endforelse
              </tbody>
            </table>
          </div>
        </div>

        <!-- BADGES SECTION -->
        <div class="badge-section" style="margin-top: 30px;">
            <h3>Obtainable Badges</h3>
            <div class="table-scroll">
              <table class="badge-table">
                  <thead>
                      <tr>
                          <th>Badge</th>
                          <th>Name</th>
                          <th>Condition</th>
                      </tr>
                  </thead>
                  <tbody>
                      @foreach($classroom->badges as $badge)
                      <tr class="clickable-badge-row"
                          data-name="{{ $badge->name }}"
                          data-image="{{ asset('images/' . $badge->image) }}"
                          data-type="{{ $badge->type }}"
                          data-condition="{{ $badge->condition_value }}">
                          <td><img src="{{ asset('images/' . $badge->image) }}" class="badge-thumbnail" style="width:40px; border-radius:50%;"></td>
                          <td>{{ $badge->name }}</td>
                          <td>
                              @switch($badge->type)
                                  @case('submission_count')
                                      Submit {{ $badge->condition_value }} assignments
                                      @break
                                  @case('perfect_quiz')
                                      {{ $badge->condition_value }} perfect quiz scores
                                      @break
                                  @case('quiz_count')
                                      {{ $badge->condition_value }} total quiz attempts
                                      @break
                                  @default
                                      Achievement
                              @endswitch
                          </td>
                      </tr>
                      @endforeach
                  </tbody>
              </table>
            </div>
        </div>
      </div>
      


      <!-- POSTS SECTION -->
      <div class="post-section">
        @foreach ($classroom->posts as $post)
          <div class="discussion-container">
            <!-- User Info -->
            <div class="user-info">
              <img src="{{ $post->user->profile_picture ? asset('storage/' . $post->user->profile_picture) : asset('images/default-user.png') }}" alt="Profile Picture" class="profile-pic">
              <div class="user-details">
                <span class="user-name">{{ $post->user->name }}</span><br>
                <span class="post-time">{{ $post->created_at->format('d/m/Y') }}</span>
              </div>
            </div>

            <!-- Post Content -->
            <div class="post-content">
                <p>{{ $post->content }}</p>

                @if ($post->quiz)
                    @php
                        $attempts = $post->quiz->attempts ?? collect();  // fallback to empty collection
                        $attempted = $attempts->where('user_id', auth()->id())->count() > 0;
                    @endphp
                    
                    <a href="{{ $attempted ? '#' : route('quiz.show', [$classroom->id, $post->quiz->id]) }}"
                      class="quiz-box {{ $attempted ? 'disabled-quiz' : '' }}">
                        <div class="quiz-icon"><i class='bx bx-task'></i></div>
                        <div class="quiz-text">
                            <h4>{{ $post->quiz->title }}</h4>
                            <p>{{ $attempted ? 'Already Attempted' : 'Click to start' }}</p>
                        </div>
                    </a>
                @endif
            </div>

              <!-- Divider ABOVE comments -->
              @if ($post->comments->count())
                  <hr style="margin: 15px 0; border: none; border-top: 1px solid #ccc;">
              @endif

              <!-- Comment List -->
              @if ($post->comments->count())
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
              @endif

              <!-- Dynamic Divider if No Comments -->
              @if (! $post->comments->count())
                  <hr style="margin: 15px 0; border: none; border-top: 1px solid #ccc;">
              @endif

              <!-- Reply Button -->
              <div class="reply-section">
                  <button class="reply-btn">
                      <i class='bx bx-message'></i> <strong>REPLY</strong>
                  </button>

                  <!-- Reply Input Field (Hidden Initially) -->
                  <form method="POST" action="{{ route('comments.store') }}" class="reply-input-container" style="display: none;">
                      @csrf
                      <input type="hidden" name="post_id" value="{{ $post->id }}">
                      <input type="text" name="comment_text" class="reply-input" placeholder="Add a class comment..." required>
                      <button type="submit" class="send-reply-btn"><i class="fa-solid fa-paper-plane"></i></i></button>
                  </form>
              </div>
          </div>
        @endforeach
      </div>

    </div>
  </div>

<!-- ==================== FILES TAB (STUDENT) ==================== -->
<div id="files" class="tab-content">
    <button id="backToMainTable" onclick="showMainFileTable()" style="display: none;">
        <i class='bx bx-arrow-back'></i> Back
    </button>

    <div class="file-wrapper">
            <div class="file-header">
                <h2 id="folderTitle">Files</h2>
            </div>

            <table class="file-table">
                <thead>
                    <tr>
                    <th>Name</th>
                    <th>Modified</th>
                    <th>Modified By</th>
                    </tr>
                </thead>
                <tbody id="fileTableBody">
                    <tr><td colspan="4">Loading...</td></tr>
                </tbody>
            </table>
    </div>
</div>


</section>

<!-- Assignment Modal -->
<div class="modal" id="assignmentModal">
  <div class="card">
   

    <div class="header">
      <p class="title" id="modalTitle">Assignment Title</p>
      <span class="close-btn">&times;</span>
    </div>

    <div class="description-container">
      <p class="message" id="modalDescription">Assignment description goes here.</p>
    </div>

    <!-- Upload Form -->
    <div id="submissionWrapper">
      <form action="{{ route('assignment.submit') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="assignment_id" id="modalAssignmentId">

        <div class="upload-section">
          <div class="file-upload-container">
            <!-- Hidden File Input -->
            <input type="file" id="fileInput" name="submission_file" style="display: none;" required>

            <!-- Custom Upload Button -->
            <button type="button" id="uploadButton">
              <i class="fa fa-upload"></i> ADD FILE
            </button>

            <p id="fileNameDisplay" class="file-name">No file chosen</p>
          </div>
        </div>

        <div class="submit-btn-container">
          <button type="submit" class="submit-btn">Submit Assignment</button>
        </div>
      </form>

    </div>

  </div>
</div>


<!-- Leaderboard Modal -->
<div class="modal-result" id="leaderboardModal">
  <div class="card leaderboard-card">
    <span class="close-btn" onclick="closeLeaderboardModal()">&times;</span>
    <h2 class="leaderboard-title">🏆 Quiz Leaderboard</h2>

    <div class="podium">
      <div class="podium-player second">
        <img class="leaderboard-avatar" id="second-avatar">
        <p id="second-name">—</p>
        <small>🥈 2nd</small> <!--  Label -->
        <span id="second-score">0 pts</span>
      </div>
      <div class="podium-player first">
        <img class="leaderboard-avatar" id="first-avatar">
        <p id="first-name">—</p>
        <small>🥇1st</small> <!--  Label -->
        <span id="first-score">0 pts</span>
      </div>
      <div class="podium-player third">
        <img class="leaderboard-avatar" id="third-avatar">
        <p id="third-name">—</p>
        <small>🥉3rd</small> <!--  Label -->
        <span id="third-score">0 pts</span>
      </div>
    </div>

    <div class="leaderboard-list" id="leaderboard-list">
      <!-- Remaining users will be injected here -->
    </div>
  </div>
</div>


<!-- Badge Modal -->
@if (session('new_badge'))
    @php
        $badge = session('new_badge');
    @endphp

    <div id="badgeModal" class="badge-modal">
        <div class="badge-modal-content">
            <div class="badge-card">
              <!-- ✨ SVG Sketch Outline INSIDE here -->
              <svg class="badge-sketch" viewBox="0 0 320 400" preserveAspectRatio="none">
                    <rect x="0" y="0" width="100%" height="100%" stroke="#0072ff" stroke-width="4"
                          fill="none" style="stroke-dasharray: 2000; stroke-dashoffset: 2000;" />
              </svg>
                <div class="badge-banner">
                    <img src="{{ asset('images/' . $badge['image']) }}" alt="Badge Image" class="badge-medal">
                </div>

                <div class="badge-body">
                    <h2 class="badge-title">🎉 Congratulations!</h2>
                    <p class="badge-subtext">{{ $badge['name'] }}</p>
                    <p class="badge-condition">
                        @switch($badge['type'])
                            @case('submission_count')
                                {{ $badge['condition_value'] }} assignment submissions
                                @break
                            @case('perfect_quiz')
                                {{ $badge['condition_value'] }} perfect quiz scores
                                @break
                            @case('quiz_count')
                                {{ $badge['condition_value'] }} total quiz attempts
                                @break
                            @default
                                Achievement Unlocked
                        @endswitch
                    </p>
                    <button class="badge-button" onclick="closeBadgeModal()">Got it!</button>
                </div>
            </div>
            
        </div>
    </div>
@endif

<!-- Badge Info Modal -->
<div id="badgeInfoModal" class="badge-modal" style="display:none;">
    <div class="badge-modal-content">
        <div class="badge-card">
            <div class="badge-banner">
                <img id="badgeInfoImage" src="" class="badge-medal">
            </div>
            <div class="badge-body">
                <h2 id="badgeInfoName" class="badge-title"></h2>
                <p id="badgeInfoCondition" class="badge-condition"></p>
                <button class="badge-button" onclick="closeBadgeInfoModal()">Got it!</button>
            </div>
        </div>
    </div>
</div>




<!-- JS -->
<script>
function closeBadgeModal() {
    const modal = document.getElementById('badgeModal');
    if (modal) {
        modal.style.display = 'none';
    }
}
</script>

<script src="{{ asset('js/script.js') }}"></script>
<script>
    const csrfToken = '{{ csrf_token() }}';
</script>
<script>
    window.assignmentSubmitUrl = "{{ route('assignment.submit') }}";
</script>


<div id="classroomMeta" data-classroom-id="{{ $classroom->id }}"></div>
<div id="fileData"
     data-folders='@json($classroom->folders)'
     data-files='@json($classroom->files)'>
</div>


<audio id="badgeSound" src="{{ asset('sounds/get_badge2.mp3') }}"></audio>


</body>
</html>
