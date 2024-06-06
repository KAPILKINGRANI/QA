<nav class="navbar navbar-expand-lg bg-body-tertiary">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">QA</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="#">Home</a>
                </li>
                @auth
                    <li class="nav-item">
                        <a class="nav-link"
                            href="{{ route('users.notifications') }}">{{ auth()->user()->unreadNotifications->count() }}
                            Notifications</a>
                    </li>
                @endauth

            </ul>
        </div>
    </div>
</nav>
