<nav class="navbar navbar-expand-lg bg-body-tertiary sticky-top">
  <div class="container-fluid">
    <a class="navbar-brand fw-bold" href="{{route('admin.dashboard')}}">
      Student Registration System
    </a>
    <ul class="navbar-nav ms-auto me-3">
      <li class="nav-item dropdown ms-auto">
        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
        Account Name
        </a>
        <ul class="dropdown-menu dropdown-menu-end">
        <li><a class="dropdown-item" href="#"><i class="fa fa-info-circle"></i> Info</a></li>
        <li><a class="dropdown-item" href="#"><i class="fa fa-lock"></i> Change Password</a></li>
        <li><hr class="dropdown-divider"></li>
        <li><a class="dropdown-item" href="#"><i class="fa fa-sign-out-alt"></i> Log out</a></li>
        </ul>
      </li>
    </ul>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
  </div>
</nav>