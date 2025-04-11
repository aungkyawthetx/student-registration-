@extends('layouts.app')

@section('title', 'Attendances')

@section('content')
<div class="container my-4">
    <div class="card shadow-sm rounded">
        <div class="card-header bg-transparent border-bottom">

            {{-- Title and Add New Button --}}
            <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap gap-2">
                <h2 class="card-title mb-0">Attendances List</h2>
                @if(auth()->user()->hasRole($roles[1]->name) || auth()->user()->hasRole($roles->first()->name) || auth()->user()->hasRole($roles[3]->name))
                    <a href="{{ route('attendances.create') }}" class="btn btn-primary btn-sm">
                        <span class="d-none d-sm-inline">Add New</span>
                        <i class="fas fa-plus ms-1"></i>
                    </a>
                @endif
            </div>

            {{-- Flash Messages --}}
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

                    {{-- Search Bar --}}
                    <div class="d-flex flex-grow-1 gap-2" style="max-width: 400px;">
                        <form action="{{ route('attendances.search') }}" method="GET" class="d-flex flex-grow-1 input-group">
                            <input type="text" name="search_data" id="search_data" class="form-control" placeholder="Search..." value="{{ request('search_data') }}">
                            <button class="btn btn-secondary" type="submit" title="Search">
                                <i class="fas fa-search"></i>
                            </button>
                        </form>
                        <a href="{{ route('attendances.index') }}" class="btn btn-secondary" title="Show All">
                            <i class="fas fa-sync-alt"></i>
                        </a>
                    </div>

                    {{-- Import / Export / Delete All --}}
                    @if(auth()->user()->hasRole($roles[1]->name) || auth()->user()->hasRole($roles->first()->name))
                        <div class="d-flex flex-wrap gap-2 justify-content-md-end">
                            <form action="{{ route('attendances.import') }}" method="POST" enctype="multipart/form-data" class="d-flex align-items-center gap-2">
                                @csrf
                                <div class="input-group input-group-sm" style="width: 150px;">
                                    <input type="file" name="attendances" class="form-control form-control-sm" required>
                                </div>
                                <button type="submit" class="btn btn-primary btn-sm" title="Import">
                                    <i class="fa-solid fa-upload"></i>
                                    <span class="d-none d-sm-inline">Import</span>
                                </button>
                            </form>

                            <a href="{{ route('attendances.export') }}" class="btn btn-primary btn-sm" title="Export" onclick="return confirm('Export attendances data as an excel file?')">
                                <i class="fa-solid fa-download"></i>
                                <span class="d-none d-sm-inline">Export</span>
                            </a>

                            <form action="{{ route('attendances.destroy-all') }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete all attendances?')">
                                    <i class="fas fa-trash"></i>
                                    <span class="d-none d-sm-inline">Delete All</span>
                                </button>
                            </form>
                        </div>
                    @endif
                </div>
            </div>

        {{-- Table --}}
        <div class="card-body">
            <div class="table-responsive my-3">
                <table class="table table-striped table-hover align-middle text-center">
                    <thead class="table-light">
                        <tr>
                            <th scope="col">ID</th>
                            <th scope="col">Class Name</th>
                            <th scope="col">Student Name</th>
                            <th scope="col">Date</th>
                            <th scope="col">Status</th>
                            @if(auth()->user()->hasRole($roles[1]->name) || auth()->user()->hasRole($roles->first()->name) || auth()->user()->hasRole($roles[3]->name))
                                <th>Actions</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody>
                        @if($attendances->isNotEmpty())
                            @foreach ($attendances as $attendance)
                                <tr>
                                    <td>{{ $attendance->id }}</td>
                                    <td>{{ $attendance->class->course->name ?? 'no class' }}</td>
                                    <td title="view student details">
                                        <a href="#" 
                                            class="text-decoration-none text-body student-detail-link" 
                                            data-id="{{ $attendance->student->id }}"
                                            data-bs-toggle="modal"
                                            data-bs-target="#studentModal">
                                            {{ $attendance->student->name ?? 'no student' }}
                                        </a>
                                    </td>

                                    <td>{{ $attendance->attendance_date }}</td>
                                    <td>{{ $attendance->attendance_status }}</td>
                                    @if(auth()->user()->hasRole($roles[1]->name) || auth()->user()->hasRole($roles->first()->name) || auth()->user()->hasRole($roles[3]->name))
                                        <td>
                                            <div class="d-flex justify-content-center gap-2">
                                                <a href="{{ route('attendances.edit',$attendance->id) }}" class="btn btn-sm btn-success">
                                                    <i class="fas fa-edit"></i>
                                                    <span class="d-none d-sm-inline">Edit</span>
                                                </a>
                                                <form action="{{ route('attendances.destroy', $attendance->id) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this row?')">
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
                                <td colspan="{{ auth()->user()->hasRole($roles[1]->name) || auth()->user()->hasRole($roles->first()->name) || auth()->user()->hasRole($roles[3]->name) ? 7 : 6 }}" class="text-center">No data found.</td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Pagination --}}
        <div class="card-footer bg-transparent border-0 pt-0">
            <div class="container">
                {{ $attendances->links('pagination::bootstrap-5') }}
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="studentModal" tabindex="-1" aria-labelledby="studentModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0">
            <div class="modal-header bg-success text-white">
            <h5 class="modal-title" id="studentModalLabel">Student Details</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div id="studentDetailContent">
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    document.addEventListener('livewire:load', function() {
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
        });
    });

    $(document).on('click', '.student-detail-link', function(e) {
        e.preventDefault();
        const studentId = $(this).data('id');
        $('#studentDetailContent').html('Loading...');

        $.ajax({
            url: '/students/' + studentId, // adjust if you have a different route
            type: 'GET',
            success: function(response) {
                $('#studentDetailContent').html(response);
            },
            error: function() {
                $('#studentDetailContent').html('<p class="text-danger">Error loading student details.</p>');
            }
        });
    });
</script>

@endsection