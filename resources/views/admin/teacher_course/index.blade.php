@extends('layouts.app')

@section('title', 'Teacher Courses')

@section('content')
<div class="container my-4">
    <div class="card shadow-sm rounded">
        <div class="card-header container bg-transparent border-bottom">
            <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-3">
                <h2 class="card-title mb-0">Teacher Courses</h2>
                <div class="d-flex flex-wrap align-items-center gap-2">
                    @if(auth()->user()->hasRole($roles[1]->name) || auth()->user()->hasRole($roles->first()->name))
                        <a href="{{ route('teachercourses.create') }}" class="btn btn-primary btn-sm">
                            <i class="fas fa-plus me-1"></i>
                            <span class="d-none d-sm-inline">Add New</span>
                        </a>
                    @endif
                </div>
            </div>

            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show mt-2" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show mt-2" role="alert">
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif  

            <div class="row mt-3">
                <div class="col-12 d-flex flex-column flex-md-row align-items-stretch align-items-md-center justify-content-between gap-2">
                    <div class="d-flex flex-grow-1 gap-2" style="max-width: 400px;">
                        <form action="{{ route('teachercourses.search') }}" method="GET" class="d-flex flex-grow-1 input-group">
                            <input type="text" name="search_data" id="search_data" class="form-control" placeholder="Search..." value="{{ request('search_data') }}">
                            <button class="btn btn-secondary" type="submit" title="Search">
                                <i class="fas fa-search"></i>
                            </button>
                        </form>
                        <a href="{{ route('teachercourses.index') }}" class="btn btn-secondary" title="Show All">
                            <i class="fas fa-sync-alt"></i>
                        </a>
                    </div>

                    @if(auth()->user()->hasRole($roles[1]->name) || auth()->user()->hasRole($roles->first()->name))
                        <div class="d-flex flex-wrap justify-content-md-end gap-2">
                            <form action="{{ route('teachercourses.import') }}" method="POST" enctype="multipart/form-data" class="d-flex align-items-center gap-2">
                                @csrf
                                <div class="input-group input-group-sm" style="width: 150px;">
                                    <input type="file" name="teachercourses" class="form-control form-control-sm" required>
                                </div>
                                <button type="submit" class="btn btn-primary btn-sm" title="Import">
                                    <i class="fa-solid fa-upload"></i>
                                    <span class="d-none d-sm-inline">Import</span>
                                </button>
                            </form>
                            <a href="{{ route('teachercourses.export') }}" class="btn btn-primary btn-sm" title="Export" onclick="return confirm('Export teacher courses data as an excel file?')">
                                <i class="fa-solid fa-download"></i>
                                <span class="d-none d-sm-inline">Export</span>
                            </a>
                            <form action="{{ route('teachercourses.destroy-all') }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete all teacher courses?')">
                                    <i class="fas fa-trash"></i>
                                    <span class="d-none d-sm-inline">Delete All</span>
                                </button>
                            </form>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <div class="card-body">
            <div class="table-responsive my-3">
                <table class="table table-striped table-hover align-middle text-center">
                    <thead class="table-light">
                        <tr>
                            <th scope="col">ID</th>
                            <th scope="col">Teacher Name</th>
                            <th scope="col">Course</th>
                            @if(auth()->user()->hasRole($roles[1]->name) || auth()->user()->hasRole($roles->first()->name))
                                <th scope="col">Actions</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody>
                        @if($teacher_courses->isNotEmpty())
                            @foreach($teacher_courses as $teacher_course)
                                <tr>
                                    <td>{{ $teacher_course->id ?? 'null' }}</td>
                                    <td>
                                        <a href="#" 
                                        class="text-decoration-none text-body teacher-detail-link"
                                        data-id="{{ $teacher_course->id }}"
                                        data-bs-toggle="modal"
                                        data-bs-target="#teacherModal">
                                        {{ $teacher_course->teacher->name ?? 'no teacher' }}
                                    </a>
                                    </td>
                                    <td>{{ $teacher_course->course->name ?? 'no course' }}</td>
                                    @if(auth()->user()->hasRole($roles[1]->name) || auth()->user()->hasRole($roles->first()->name))
                                        <td>
                                            <div class="d-flex justify-content-center gap-2">
                                                <a href="{{ route('teachercourses.edit', $teacher_course->id) }}" class="btn btn-sm btn-success">
                                                    <i class="fas fa-edit"></i>
                                                    <span class="d-none d-sm-inline">Edit</span>
                                                </a>
                                                <form action="{{ route('teachercourses.destroy', $teacher_course->id) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this teacher course?')">
                                                        <i class="fas fa-trash"></i>
                                                        <span class="d-none d-sm-inline">Delete</span>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    @endif
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="{{ auth()->user()->hasRole($roles[1]->name) || auth()->user()->hasRole($roles->first()->name) ? 4 : 3 }}" class="text-center">No data found</td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>

        <div class="card-footer bg-transparent border-0 pt-0">
            <div class="container">
                {{ $teacher_courses->links('pagination::bootstrap-5') }}
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="teacherModal" tabindex="-1" aria-labelledby="teacherModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content shadow border-0">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title" id="teacherModalLabel">Teacher Details</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4" id="teacherDetailsContent">
                <div class="text-center">
                    <div id="teacherDetails"></div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).on('click', '.teacher-detail-link', function(e) {
        e.preventDefault();

        const teacherId = $(this).data('id');
        $('#teacherDetailsContent').html('<div class="spinner-border text-primary" role="status"><span class="visually-hidden">Loading...</span></div>');

        $.ajax({
            url: '/teachers/' + teacherId,
            type: 'GET',
            success: function(response) {
                $('#teacherDetailsContent').html(response);
            },
            error: function() {
                $('#teacherDetailsContent').html('<p class="text-danger">Error loading teacher details.</p>'); // Updated error message
            }
        });
    });
</script>
@endsection