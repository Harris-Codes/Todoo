<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Classroom</title>

  <!-- CSS -->
  <link rel="stylesheet" href="{{ asset('css/classroom.css') }}">
  <link href='https://unpkg.com/boxicons@2.1.1/css/boxicons.min.css' rel='stylesheet'>
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

      <!-- ASSIGNMENT SECTION -->
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
            @foreach ($classroom->assignments as $assignment)
              <tr class="clickable-row" data-title="{{ $assignment->title }}" data-desc="{{ $assignment->description }}">
                <td>{{ $assignment->title }}</td>
                <td>{{ \Carbon\Carbon::parse($assignment->due_date)->format('M d, Y') }}</td>
                <td><span class="status pending">Pending</span></td>
              </tr>
            @endforeach
          </tbody>
        </table>
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
                <a href="{{ route('quiz.show', [$classroom->id, $post->quiz->id]) }}" class="quiz-box">
                  <div class="quiz-icon"><i class='bx bx-task'></i></div>
                  <div class="quiz-text">
                    <h4>{{ $post->quiz->title }}</h4>
                    <p>Click to start</p>
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

  <!-- ==================== FILES TAB ==================== -->
  <div id="files" class="tab-content">
    <div class="file-header">
      <div class="file-column"><i class="bx bx-file"></i> Name</div>
      <div class="file-column">Modified</div>
      <div class="file-column">Modified By</div>
    </div>

    <div class="file-list">
      @forelse ($classroom->files as $file)
        <div class="file-row">
          <div class="file-column">
            <i class="bx bx-file"></i> 
            <a href="{{ asset('storage/' . $file->filepath) }}" target="_blank">{{ $file->filename }}</a>
          </div>
          <div class="file-column">{{ $file->updated_at->format('M d, Y') }}</div>
          <div class="file-column">{{ $file->uploader->name ?? 'Unknown' }}</div>
        </div>
      @empty
        <p>No files uploaded yet...</p>
      @endforelse
    </div>
  </div>
</section>

<!-- JS -->
<script src="{{ asset('js/script.js') }}"></script>
</body>
</html>
