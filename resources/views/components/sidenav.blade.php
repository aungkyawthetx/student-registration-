@php
    use App\Models\Role;

    $roles = Role::all();
@endphp
<div class="d-flex flex-column flex-shrink-0 p-3 d-lg-block d-none bg-body-tertiary my-5 mb-5" style="position: fixed; left: 0; width:21%; height: 95vh; overflow-y:auto;">
    <ul class="nav nav-pills flex-column mb-auto">
        @auth
        @if(auth()->user()->hasRole($roles[1]->name) || auth()->user()->hasRole($roles->first()->name))
        <h6 class="text-underline" data-bs-toggle="collapse" href="#accounts" role="button" aria-expanded="{{ request()->routeIs('users.index') || request()->routeIs('roles.index') || request()->routeIs('users.create') || request()->routeIs('users.edit') || request()->routeIs('roles.create') || request()->routeIs('roles.edit') ? 'true' : 'false' }}" aria-controls="accountsMenu">Accounts <i class="bi bi-chevron-down"></i></h6>
        <div class="collapse {{ request()->routeIs('users.index') || request()->routeIs('roles.index') || request()->routeIs('users.create') || request()->routeIs('users.edit') || request()->routeIs('roles.create') || request()->routeIs('roles.edit') ? 'show' : '' }}" id="accounts">
            <li class="nav-item">
            <a href="{{route('users.index')}}" class="nav-link text-body {{ request()->routeIs('users.index') ? 'active fw-bold' : ''}}" aria-current="page">
                <i class="bi bi-people"></i> Users
            </a>
            </li>
            <li class="nav-item">
            <a href="{{route('roles.index')}}" class="nav-link text-body {{ request()->routeIs('roles.index') ? 'active fw-bold' : ''}}" aria-current="page">
                <i class="bi bi-shield-lock"></i> Roles
            </a>
            </li>
        </div>
        <hr>
        @endif
        @if(auth()->user()->hasRole($roles[1]->name) || auth()->user()->hasRole($roles->first()->name) || auth()->user()->hasRole($roles[3]->name))
        <h6 class="text-underline">Students</h6>
        <li class="nav-item">
            <a href="{{route('students.index')}}" class="nav-link text-body {{ request()->routeIs('students.index') ? 'active fw-bold' : ''}}" aria-current="page">
                <i class="bi bi-people"></i> Students
            </a>
        </li>
        <li>
            <a href="{{route('enrollments.index')}}" class="nav-link text-body {{ request()->routeIs('enrollments.index') ? 'active fw-bold' : '' }}">
                <i class="bi bi-card-list"></i> Enrollment
            </a>
        </li>
        <li>
            <a href="{{route('attendances.index')}}" class="nav-link text-body {{ request()->routeIs('attendances.index') ? 'active fw-bold' : '' }}">
                <i class="bi bi-check2-square"></i> Attendance
            </a>
        </li>
        <hr>
        @endif
        @if(auth()->user()->hasRole($roles[1]->name) || auth()->user()->hasRole($roles->first()->name))
        <h6 class="text-underline">Teachers</h6>
        <li>
            <a href="{{route('teachers.index')}}" class="nav-link text-body {{ request()->routeIs('teachers.index') ? 'active fw-bold' : ''}}">
                <i class="bi bi-person-badge"></i> Teachers
            </a>
        </li>
        <li>
            <a href="{{route('teachercourses.index')}}" class="nav-link text-body {{ request()->routeIs('teachercourses.index') ? 'active fw-bold' : ''}}">
                <i class="bi bi-journal-bookmark"></i> Teacher Courses
            </a>
        </li>
        <hr>
        @endif
        @if(auth()->user()->hasRole($roles[1]->name) || auth()->user()->hasRole($roles->first()->name) || auth()->user()->hasRole($roles[3]->name))
        <h6 class="text-underline">Courses</h6>
        <li>
            <a href="{{route('courses.index')}}" class="nav-link text-body {{ request()->routeIs('courses.index') ? 'active fw-bold' : ''}}">
                <i class="bi bi-book"></i> Courses
            </a>
        </li>
        <li>
            <a href="{{route('rooms.index')}}" class="nav-link text-body {{ request()->routeIs('rooms.index') ? 'active fw-bold' : ''}}">
                <i class="bi bi-door-closed"></i> Rooms
            </a>
        </li>
        <li>
            <a href="{{route('classes.index')}}" class="nav-link text-body  {{ request()->routeIs('classes.index') ? 'active fw-bold' : '' }}">
                <i class="bi bi-calendar"></i> Class Timetables
            </a>
        </li>
        <hr>
        <h6 class="text-underline">Reports</h6>
        <li>
            <a href="{{route('attendance.report')}}" class="nav-link text-body {{ request()->routeIs('attendance.report') ? 'active fw-bold' : ''}}">
                <i class="bi bi-book"></i> Student Attendance
            </a>
        </li>
        <li>
            <a href="{{route('enrollment.report')}}" class="nav-link text-body {{ request()->routeIs('enrollment.report') ? 'active fw-bold' : ''}}">
                <i class="fa-solid fa-users"></i> Student Enrollment
            </a>
        </li>
        @else
        <li>
            <p class="mt-5 text-body">Gain permission from super admin for admin panel access</p>
        </li>
        @endif
        @endauth
    </ul>
</div>

<div class="d-lg-none p-3 bg-body-tertiary">
    <ul class="nav nav-pills flex-row justify-content-around">
        @auth
        @if(auth()->user()->hasRole($roles[1]->name) || auth()->user()->hasRole($roles->first()->name))
        <li class="nav-item">
            <a href="{{route('users.index')}}" class="nav-link text-body {{ request()->routeIs('users.index') ? 'active fw-bold' : ''}}" aria-current="page">
                <i class="bi bi-people"></i> Users
            </a>
        </li>
        <li class="nav-item">
            <a href="{{route('roles.index')}}" class="nav-link text-body {{ request()->routeIs('roles.index') ? 'active fw-bold' : ''}}" aria-current="page">
                <i class="bi bi-people"></i> Roles
            </a>
        </li>
        @endif
        @if(auth()->user()->hasRole($roles[1]->name) || auth()->user()->hasRole($roles->first()->name) || auth()->user()->hasRole($roles[3]->name))
        <li class="nav-item">
            <a href="{{route('students.index')}}" class="nav-link text-body {{ request()->routeIs('students.index') ? 'active fw-bold' : '' }}" aria-current="page">
                <i class="bi bi-people"></i> Students
            </a>
        </li>
        <li>
            <a href="{{route('enrollments.index')}}" class="nav-link text-body {{ request()->routeIs('enrollments.index') ? 'active fw-bold' : '' }}">
                <i class="bi bi-card-list"></i> Enrollment
            </a>
        </li>
        <li>
            <a href="{{route('attendances.index')}}" class="nav-link text-body {{ request()->routeIs('attendances.index') ? 'active fw-bold' : '' }}">
                <i class="bi bi-check2-square"></i> Attendance
            </a>
        </li>
        @endif
        @if(auth()->user()->hasRole($roles[1]->name) || auth()->user()->hasRole($roles->first()->name))
        <li>
            <a href="{{route('teachers.index')}}" class="nav-link text-body {{ request()->routeIs('teachers.index') ? 'active fw-bold' : '' }}">
                <i class="bi bi-person-badge"></i> Teachers
            </a>
        </li>
        <li>
            <a href="{{route('teachercourses.index')}}" class="nav-link text-body {{ request()->routeIs('teachercourses.index') ? 'active fw-bold' : '' }}">
                <i class="bi bi-journal-bookmark"></i> Teacher Courses
            </a>
        </li>
        @endif
        @if(auth()->user()->hasRole($roles[1]->name) || auth()->user()->hasRole($roles->first()->name) || auth()->user()->hasRole($roles[3]->name))
        <li>
            <a href="{{route('courses.index')}}" class="nav-link text-body {{ request()->routeIs('courses.index') ? 'active fw-bold' : '' }}">
                <i class="bi bi-book"></i> Courses
            </a>
        </li>
        <li>
            <a href="{{route('rooms.index')}}" class="nav-link text-body {{ request()->routeIs('rooms.index') ? 'active fw-bold' : '' }}">
                <i class="bi bi-door-closed"></i> Rooms
            </a>
        </li>
        <li>
            <a href="{{route('classes.index')}}" class="nav-link text-body {{ request()->routeIs('classes.index') ? 'active fw-bold' : '' }}">
                <i class="bi bi-calendar"></i> Class Timetables
            </a>
        </li>
        <li>
            <a href="{{route('attendance.report')}}" class="nav-link text-body {{ request()->routeIs('attendance.report') ? 'active fw-bold' : ''}}">
                <i class="bi bi-book"></i> Attendance Report 
            </a>
        </li>
        <li>
            <a href="{{route('enrollment.report')}}" class="nav-link text-body {{ request()->routeIs('enrollment.report') ? 'active fw-bold' : ''}}">
                <i class="bi bi-file-earmark-text"></i> Enrollment Report 
            </a>
        </li>
        @else
        <li>
            <p class="mt-5 text-body">Gain permission from super admin for admin panel access</p>
        </li>
        @endif
        @endauth
    </ul>
</div>
