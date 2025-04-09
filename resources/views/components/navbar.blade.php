@extends('components.dark-mode')
<nav class="navbar navbar-expand-lg sticky-top" style="background-color: #2c3e50" data-bs-theme="dark">
  <div class="container-fluid">
    <a class="navbar-brand fw-bold" href="{{route('admin.dashboard')}}">
      Student Registration System
    </a>
    
    <!-- Toggle button for mobile -->
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapseContent" aria-controls="navbarCollapseContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    
    <div class="collapse navbar-collapse" id="navbarCollapseContent">
      <div class="d-flex align-items-center ms-auto">
        <!-- Dark mode toggle -->
        <div class="me-3">
          <input type="checkbox" name="checkbox" id="checkbox" class="checkbox">
          <label for="checkbox" class="checkbox-label">
            <i class="fas fa-moon"></i>
            <i class="fas fa-sun"></i>
            <span class="ball"></span>
          </label>
        </div>
        
        <!-- Navigation items -->
        <ul class="navbar-nav">
          @auth
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
              <i class="fa fa-user-circle"></i> {{ Auth::user()->name }}
            </a>
            <ul class="dropdown-menu dropdown-menu-end position-absolute">
              @if(auth()->user()->hasRole('Super admin'))
                <li>
                  <button class="dropdown-item d-flex align-items-center gap-2" data-bs-toggle="modal" data-bs-target="#viewPasswordModal">
                    <i class="fa fa-lock"></i> 
                    <span>Change Password</span>
                  </button>
                </li>
              @else
                <li>
                  <a class="dropdown-item d-flex align-items-center gap-2" href="{{route('change-password', Auth::user()->id)}}">
                    <i class="fa fa-lock"></i> 
                    <span>Change Password</span>
                  </a>
                </li>
              @endif
              <li><hr class="dropdown-divider m-0"></li>
              <li>
                <form action="{{route('logout')}}" method="POST">
                  @csrf
                  <button class="dropdown-item d-flex align-items-center gap-2" onclick="return confirm('Are you sure to log out?');">
                    <i class="fa fa-sign-out-alt"></i> 
                    <span>Logout</span>
                  </button>
                </form>
              </li>
            </ul>
          </li>
          @else
          <li class="nav-item d-flex">
            <a href="{{route('login')}}" class="btn btn-primary me-2">Login</a>
            <a href="{{route('register')}}" class="btn btn-secondary">Register</a>
          </li>
          @endauth
        </ul>
      </div>
    </div>
  </div>
</nav>

<div class="modal fade" id="viewPasswordModal" tabindex="-1" aria-labelledby="viewPasswordLabel" aria-hidden="true">
  <div class="modal-dialog">
      <form method="POST" action="{{ route('verify-password-view') }}">
          @csrf
          <input type="hidden" name="user_id" value="{{Auth::user()->id}}">
          <div class="modal-content">
              <div class="modal-header">
                  <h5 class="modal-title" id="viewPasswordLabel">Enter your password</h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
              </div>
              <div class="modal-body">
                  <input type="password" name="password" class="form-control" placeholder="Your password">
              </div>
              <div class="modal-footer">
                  <button type="submit" class="btn btn-primary">Verify</button>
              </div>
          </div>
      </form>
  </div>
</div>