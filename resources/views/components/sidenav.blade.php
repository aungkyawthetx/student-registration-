@php
    use App\Models\Role;
    $roles = Role::all();
@endphp

<!-- Desktop Sidebar -->
<div class="d-flex flex-column flex-shrink-0 p-3 d-lg-block d-none bg-body-tertiary mt-5" style="position: fixed; left: 0; width:18%; height: 95%; z-index: 1000; overflow-y:auto;">
    <ul class="nav nav-pills flex-column mb-auto">
        @auth
        <!-- Dashboard -->
        <li class="nav-item mt-3">
            <a href="{{ route('admin.dashboard') }}" class="nav-link text-body {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}"> 
                <i class="fa-solid fa-gauge me-2"></i> Dashboard 
            </a>
        </li>

        @if(auth()->user()->hasRole($roles[1]->name) || auth()->user()->hasRole($roles->first()->name))
        <!-- Accounts Section -->
        <li class="nav-item mt-3">
            <div class="fw-bold mb-2 ps-2">Accounts</div>
            <ul class="nav flex-column ps-3">
                <li class="nav-item">
                    <a href="{{route('users.index')}}" class="nav-link text-body {{ request()->routeIs('users.*') ? 'active' : ''}}">
                        <i class="bi bi-people me-2"></i> Users
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{route('roles.index')}}" class="nav-link text-body {{ request()->routeIs('roles.*') ? 'active' : ''}}">
                        <i class="bi bi-shield-lock me-2"></i> Roles
                    </a>
                </li>
            </ul>
        </li>
        @endif

        @if(auth()->user()->hasRole($roles[1]->name) || auth()->user()->hasRole($roles->first()->name) || auth()->user()->hasRole($roles[3]->name))
        <!-- Students Section -->
        <li class="nav-item mt-3">
            <div class="fw-bold mb-2 ps-2">Students</div>
            <ul class="nav flex-column ps-3">
                <li class="nav-item">
                    <a href="{{route('students.index')}}" class="nav-link text-body {{ request()->routeIs('students.*') ? 'active' : ''}}">
                        <i class="bi bi-people me-2"></i> Students
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{route('enrollments.index')}}" class="nav-link text-body {{ request()->routeIs('enrollments.*') ? 'active' : '' }}">
                        <i class="bi bi-card-list me-2"></i> Enrollment
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{route('attendances.index')}}" class="nav-link text-body {{ request()->routeIs('attendances.*') ? 'active' : '' }}">
                        <i class="bi bi-check2-square me-2"></i> Attendance
                    </a>
                </li>
            </ul>
        </li>
        @endif

        @if(auth()->user()->hasRole($roles[1]->name) || auth()->user()->hasRole($roles->first()->name))
        <!-- Teachers Section -->
        <li class="nav-item mt-3">
            <div class="fw-bold mb-2 ps-2">Teachers</div>
            <ul class="nav flex-column ps-3">
                <li class="nav-item">
                    <a href="{{route('teachers.index')}}" class="nav-link text-body {{ request()->routeIs('teachers.*') ? 'active' : ''}}">
                        <i class="fas fa-chalkboard-teacher me-2"></i> Teachers
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{route('teachercourses.index')}}" class="nav-link text-body {{ request()->routeIs('teachercourses.*') ? 'active' : ''}}">
                        <i class="bi bi-journal-bookmark me-2"></i> Teacher Courses
                    </a>
                </li>
            </ul>
        </li>
        @endif

        @if(auth()->user()->hasRole($roles[1]->name) || auth()->user()->hasRole($roles->first()->name) || auth()->user()->hasRole($roles[3]->name))
        <!-- Courses Section -->
        <li class="nav-item mt-3">
            <div class="fw-bold mb-2 ps-2">Courses</div>
            <ul class="nav flex-column ps-3">
                <li class="nav-item">
                    <a href="{{route('courses.index')}}" class="nav-link text-body {{ request()->routeIs('courses.*') ? 'active' : ''}}">
                        <i class="bi bi-book me-2"></i> Courses
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{route('rooms.index')}}" class="nav-link text-body {{ request()->routeIs('rooms.*') ? 'active' : ''}}">
                        <i class="bi bi-door-closed me-2"></i> Rooms
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{route('classes.index')}}" class="nav-link text-body {{ request()->routeIs('classes.*') ? 'active' : '' }}">
                        <i class="bi bi-calendar me-2"></i> Classes
                    </a>
                </li>
            </ul>
        </li>
        <li class="nav-item mt-3">
            <h6 class="fw-bold mb-2 ps-2">Reports</h6>
            <li class="nav-item">
                <a href="{{route('attendance.report')}}" class="nav-link text-body {{ request()->routeIs('attendance.report') ? 'active fw-bold' : ''}}">
                    <i class="bi bi-clipboard-check"></i> Attendance Report
                </a>
            </li>
            <li class="nav-item">
                <a href="{{route('enrollment.report')}}" class="nav-link text-body {{ request()->routeIs('enrollment.report') ? 'active fw-bold' : ''}}">
                    <i class="bi bi-clipboard-check"></i> Enrollment Report
                </a>
            </li>
        </li>
        @else
        <li class="nav-item mt-5">
            <div class="text-body">Gain permission from super admin for admin panel access</div>
        </li>
        @endif
        @endauth
    </ul>
</div>

<!-- Mobile Bottom Navigation -->
<div class="d-lg-none fixed-bottom bg-body-tertiary border-top">
    <ul class="nav nav-pills justify-content-around py-2 align-items-center">
        @auth
        <!-- Dashboard -->
        <li class="nav-item">
            <a href="{{ route('admin.dashboard') }}" class="nav-link text-center {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                <i class="fa-solid fa-gauge d-block mx-auto mb-2"></i>
                <small>Dashboard</small>
            </a>
        </li>

        @if(auth()->user()->hasRole($roles[1]->name) || auth()->user()->hasRole($roles->first()->name))
        <!-- Accounts -->
        <li class="nav-item">
            <a href="{{route('users.index')}}" class="nav-link text-center {{ request()->routeIs('users.*') ? 'active' : ''}}">
                <i class="bi bi-people d-block mx-auto"></i>
                <small>Users</small>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{route('roles.index')}}" class="nav-link text-center {{ request()->routeIs('roles.*') ? 'active' : ''}}">
                <i class="bi bi-shield-lock d-block mx-auto"></i>
                <small>Roles</small>
            </a>
        </li>
        @endif

        @if(auth()->user()->hasRole($roles[1]->name) || auth()->user()->hasRole($roles->first()->name) || auth()->user()->hasRole($roles[3]->name))
        <!-- Students -->
        <li class="nav-item">
            <a href="{{route('students.index')}}" class="nav-link text-center {{ request()->routeIs('students.*') ? 'active' : '' }}">
                <i class="bi bi-people d-block mx-auto"></i>
                <small>Students</small>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{route('enrollments.index')}}" class="nav-link text-center {{ request()->routeIs('enrollments.*') ? 'active' : '' }}">
                <i class="bi bi-card-list d-block mx-auto"></i>
                <small>Enrollment</small>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{route('attendances.index')}}" class="nav-link text-center {{ request()->routeIs('attendances.*') ? 'active' : '' }}">
                <i class="bi bi-check2-square d-block mx-auto"></i>
                <small>Attendance</small>
            </a>
        </li>
        @endif

        @if(auth()->user()->hasRole($roles[1]->name) || auth()->user()->hasRole($roles->first()->name))
        <!-- Teachers -->
        <li class="nav-item">
            <a href="{{route('teachers.index')}}" class="nav-link text-center {{ request()->routeIs('teachers.*') ? 'active' : '' }}">
                <i class="fas fa-chalkboard-teacher d-block mx-auto"></i>
                <small>Teachers</small>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{route('teachercourses.index')}}" class="nav-link text-center {{ request()->routeIs('teachercourses.*') ? 'active' : '' }}">
                <i class="bi bi-journal-bookmark d-block mx-auto"></i>
                <small>Teach Courses</small>
            </a>
        </li>
        @endif

        @if(auth()->user()->hasRole($roles[1]->name) || auth()->user()->hasRole($roles->first()->name) || auth()->user()->hasRole($roles[3]->name))
        <!-- Courses -->
        <li class="nav-item">
            <a href="{{route('courses.index')}}" class="nav-link text-center {{ request()->routeIs('courses.*') ? 'active' : '' }}">
                <i class="bi bi-book d-block mx-auto"></i>
                <small>Courses</small>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{route('rooms.index')}}" class="nav-link text-center {{ request()->routeIs('rooms.*') ? 'active' : '' }}">
                <i class="bi bi-door-closed d-block mx-auto"></i>
                <small>Rooms</small>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{route('classes.index')}}" class="nav-link text-center {{ request()->routeIs('classes.*') ? 'active' : '' }}">
                <i class="bi bi-calendar d-block mx-auto"></i>
                <small>Classes</small>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{route('attendance.report')}}" class="nav-link text-center {{ request()->routeIs('attendance.report') ? 'active' : ''}}">
            <i class="bi bi-book d-block mx-auto"></i>
            <small class="d-block text-wrap">Attendance Report</small>
            <small class="d-block text-wrap">Attendance Report</small>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{route('enrollment.report')}}" class="nav-link text-center {{ request()->routeIs('enrollment.report') ? 'active' : ''}}">
            <i class="fa-solid fa-users d-block mx-auto mb-1"></i>
            <small class="d-block text-wrap"> Enrollment Report</small>
            </a>
        </li>
        @endif
        @endauth
    </ul>
</div>

<style>
    @media (max-width: 992px) {
        body {
            padding-bottom: 60px;
        }
        .nav-pills {
            flex-wrap: nowrap;
            overflow-x: auto;
            white-space: nowrap;
        }
        .nav-item {
            min-width: 70px;
        }
    }
    
    .nav-link small {
        font-size: 0.75rem;
    }
    
    .nav-link.active {
        font-weight: 500;
    }
    
    .nav-link i {
        font-size: 1.1rem;
    }
</style>