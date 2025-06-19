<!-- Sidebar navigation menu -->
<nav class="sidebar close">
    <!-- Sidebar header containing logo and toggle button -->
    <header>
      <div class="image-text">
        <span class="image">
            <img src="{{ asset('images/sidebar-logo.png') }}" alt="Graphic">
        </span>
        <div class="text logo-text">
            
            <!-- Will actually load the right username and roles -->
            <span class="name">{{ Auth::user()->role }}</span>
            <span class="profession">{{ explode(' ', Auth::user()->name)[1] ?? Auth::user()->name }}</span>

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
                    <a href="{{ url('teacher') }}">
                            <i class='bx bx-book-content icon' ></i>
                        <span class="text nav-text">Manage Classes</span>
                    </a>
                </li>
                <li class="nav-link">
                    <a href="{{ route('quiz.overview') }}">
                        <i class='bx bx-task icon'></i>
                        <span class="text nav-text">Manage Quizzes</span>
                    </a>
                </li>

                <li class="nav-link">
                    <a href="{{ route('badges.overview') }}">
                        <i class='bx bx-medal icon'></i>
                        <span class="text nav-text">Manage Badges</span>
                    </a>
                </li>

            </ul>
      </div>

    <!-- Bottom content of the sidebar -->
    <form method="POST" action="{{ route('logout') }}">
        @csrf
        <li class="nav-link" style="all: unset;">
            <button type="submit" style="all: unset; cursor: pointer; width: 100%; display: flex; align-items: center; padding: 0;">
                <i class='bx bx-log-out icon'></i>
                <span class="text nav-text">Logout</span>
            </button>
        </li>
    </form>


    </div>
</nav>
