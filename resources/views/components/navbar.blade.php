@extends('components.dark-mode')
<nav class="navbar navbar-expand-lg bg-body-tertiary sticky-top">
  <div class="container-fluid">
    <a class="navbar-brand fw-bold" href="{{route('admin.dashboard')}}">
      Student Registration System
    </a>
    <input type="checkbox" name="checkbox" id="checkbox" class="checkbox">
    <label for="checkbox" class="checkbox-label">
      <i class="fas fa-moon"></i>
      <i class="fas fa-sun"></i>
      <span class="ball"></span>
    </label>
    <ul class="navbar-nav ms-auto me-3">
      @auth
      <li class="nav-item dropdown ms-auto">
        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
          <i class="fa fa-user-circle"></i> {{ Auth::user()->name }}
        </a>
        <ul class="dropdown-menu dropdown-menu-end">
        <li><a class="dropdown-item" href="#"><i class="fa fa-lock"></i> Change Password</a></li>
        <li><hr class="dropdown-divider"></li>
        <form action="{{route('logout')}}" method="POST">
          @csrf
          <li><button class="dropdown-item" onclick="return confirm('Are you sure to log out?');"><i class="fa fa-sign-out-alt"></i> Logout</button></li>
        </form>
        </ul>
      </li>
      @else
      <li class="d-flex justify-content-between">
        <a href="{{route('login')}}" class="btn btn-primary me-3">Login</a>
        <a href="{{route('register')}}" class="btn btn-secondary">Register</a>
      </li>
      @endauth
    </ul>
  </div>
</nav>
