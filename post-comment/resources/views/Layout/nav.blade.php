<nav class="navbar navbar-expand-lg bg-dark border-bottom border-bottom-dark ticky-top bg-body-tertiary"
     data-bs-theme="dark">
    <div class="container">
        <a class="navbar-brand fw-light" href="/"><span class="fas fa-brain me-1"> </span>Ideas</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
            <ul class="navbar-nav">
                @guest()
                    <li class="nav-item">
                        <a class="nav-link {{ Route::is("login") ? "active" : "" }}" aria-current="page" href="/login">Login</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ Route::is("register") ? "active" : "" }}" href="{{ route("register") }}">Register</a>
                    </li>
                @endguest
                @auth()
                    <li class="nav-item">
                        <a class="nav-link {{ Route::is("profile") ? "active bg-secondary text-dark" : "" }}" href="{{ route("profile", auth()->user()->id) }}">
                            {{ auth()->user()->name }} @if(auth()->user()->is_admin) <sup>(Admin)</sup> @endif
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/logout">Logout</a>
                    </li>
                @endauth
            </ul>
        </div>
    </div>
</nav>
