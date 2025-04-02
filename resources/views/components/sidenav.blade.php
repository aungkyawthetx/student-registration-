<div class="d-flex flex-column flex-shrink-0 p-3 bg-light d-lg-block d-none" style="position: fixed; left: 0; width:18%; height: 100vh;">
    <ul class="nav nav-pills flex-column mb-auto">
        <h6 class="text-underline">Students</h6>
        <li class="nav-item">
            <a href="{{route('students.index')}}" class="nav-link {{ request()->routeIs('students.index') ? 'active' : 'link-dark' }}" aria-current="page">
                <i class="bi bi-people"></i> Students
            </a>
        </li>
        <li>
            <a href="" class="nav-link link-dark">
                <i class="bi bi-card-list"></i> Enrollment
            </a>
        </li>
        <li>
            <a href="" class="nav-link link-dark">
                <i class="bi bi-check2-square"></i> Attendance
            </a>
        </li>
        <hr>
        <h6 class="text-underline">Teachers</h6>
        <li>
            <a href="{{route('teachers.index')}}" class="nav-link {{ request()->routeIs('teachers.index') ? 'active' : 'link-dark' }}">
                <i class="bi bi-person-badge"></i> Teachers
            </a>
        </li>
        <li>
            <a href="" class="nav-link link-dark">
                <i class="bi bi-journal-bookmark"></i> Teacher Courses
            </a>
        </li>
        <hr>
        <h6 class="text-underline">Courses</h6>
        <li>
            <a href="{{route('courses.index')}}" class="nav-link {{ request()->routeIs('courses.index') ? 'active' : 'link-dark' }}">
                <i class="bi bi-book"></i> Courses
            </a>
        </li>
        <li>
            <a href="{{route('rooms.index')}}" class="nav-link {{ request()->routeIs('rooms.index') ? 'active' : 'link-dark' }}">
                <i class="bi bi-door-closed"></i> Rooms
            </a>
        </li>
        <li>
            <a href="" class="nav-link link-dark">
                <i class="bi bi-calendar"></i> Class Timetables
            </a>
        </li>
        <hr>
    </ul>
</div>

<div class="d-lg-none bg-light p-3">
    <ul class="nav nav-pills flex-row justify-content-around">
        <li class="nav-item">
            <a href="{{route('students.index')}}" class="nav-link {{ request()->routeIs('students.index') ? 'active' : 'link-dark' }}" aria-current="page">
                <i class="bi bi-people"></i> Students
            </a>
        </li>
        <li>
            <a href="" class="nav-link link-dark">
                <i class="bi bi-card-list"></i> Enrollment
            </a>
        </li>
        <li>
            <a href="" class="nav-link link-dark">
                <i class="bi bi-check2-square"></i> Attendance
            </a>
        </li>
        <li>
            <a href="{{route('teachers.index')}}" class="nav-link {{ request()->routeIs('teachers.index') ? 'active' : 'link-dark' }}">
                <i class="bi bi-person-badge"></i> Teachers
            </a>
        </li>
        <li>
            <a href="" class="nav-link link-dark">
                <i class="bi bi-journal-bookmark"></i> Teacher Courses
            </a>
        </li>
        <li>
            <a href="{{route('courses.index')}}" class="nav-link {{ request()->routeIs('courses.index') ? 'active' : 'link-dark' }}">
                <i class="bi bi-book"></i> Courses
            </a>
        </li>
        <li>
            <a href="{{route('rooms.index')}}" class="nav-link {{ request()->routeIs('rooms.index') ? 'active' : 'link-dark' }}">
                <i class="bi bi-door-closed"></i> Rooms
            </a>
        </li>
        <li>
            <a href="" class="nav-link link-dark">
                <i class="bi bi-calendar"></i> Class Timetables
            </a>
        </li>
    </ul>
</div>
