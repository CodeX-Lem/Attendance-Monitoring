<p class="text-white display-5 fs-5 m-0 d-none d-sm-block">{{ $trainingProgram->course }}</p>
<div class="dropdown me-4">
    <a href="#" class="d-flex align-items-center text-white text-decoration-none dropdown-toggle"
        data-bs-toggle="dropdown">
        <img src="{{ asset('user.png') }}" alt="User Profile" width="32" height="32" class="rounded-circle me-2">
        <strong>{{ $currentUser->username }}</strong>
    </a>
    <ul class="dropdown-menu  text-small shadow rounded-0">
        <li>
            <h6 class="dropdown-header">User Account</h6>
        </li>
        <li>
            <a href="{{ route('trainor.user.show-change-profile') }}" class="dropdown-item">Change Credential</a>
        </li>
        <li>
        <li><a class="dropdown-item" href="{{ route('logout') }}">Logout</a></li>
        </li>
    </ul>
</div>