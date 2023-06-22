<div class="p-3 header d-flex align-items-center">
    <h3 class="text-white">{{ $trainingProgram }}</h3>
    <div class="ms-auto dropdown">
        <a href="#" class="d-flex align-items-center text-white text-decoration-none dropdown-toggle" data-bs-toggle="dropdown">
            <img src="{{ asset('user.png') }}" alt="User Profile" width="32" height="32" class="rounded-circle me-2">
            <strong>{{ $currentUser->username }}</strong>
        </a>
        <ul class="dropdown-menu  text-small shadow rounded-0">
            <li>
                <h6 class="dropdown-header">User Account</h6>
            </li>
            <li><a class="dropdown-item" href="">Change
                    Credentials</a>
            </li>
            <li>
            <li><a class="dropdown-item" href="{{ route('logout') }}">Logout</a></li>
            </li>
        </ul>
    </div>
</div>