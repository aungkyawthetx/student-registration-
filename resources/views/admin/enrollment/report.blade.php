@php
    use App\Models\Role;
    $roles = Role::all();
@endphp
@extends('layouts.app')
@section('title', 'Enrollment Report')
@section('content')
<div class="card shadow-sm">
    <div class="card-header bg-body border-bottom">
        <div class="container d-flex justify-content-between align-items-center mt-1">
            <h2 class="card-title mb-0">Enrollment Report</h2>
        </div>

        <div class="container mt-2">
            @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
            @endif

            @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
            @endif
        </div>
        <div class="row mt-3">
            <div class="col-12 col-md-5 d-flex gap-2 mb-2 mb-md-0">
                <div class="d-flex align-items-end gap-2" style="width:100%;">
                <form action="{{ route('enrollment-report.search') }}" method="GET" class="w-100 input-group">
                    <input type="text" name="search_data" id="search_data" class="form-control form-control-sm" placeholder="Search..." value="{{ request('search_data') }}">
                    <button class="btn btn-secondary btn-sm" type="submit" title="Search">
                        <i class="fas fa-search"></i>
                    </button>
                </form>
                <form action="{{ route('enrollment.report') }}" method="GET">
                    <button type="submit" class="btn btn-secondary btn-sm" title="Show All">
                        <i class="fas fa-sync-alt"></i>
                    </button>
                </form>
            </div>
            </div>

            <div class="col-12 col-md-7">
                <div class="d-flex flex-wrap justify-content-md-end gap-1">
                    <form method="GET" action="{{ route('enrollment.report') }}" class="row w-100">
                        <div class="col-md-4">
                            <label for="month" class="form-label"><small>Month</small></label>
                            <input type="month" name="month" id="month" class="form-control" value="{{ request('month') }}">
                        </div>
        
                        <div class="col-md-4">
                            <label for="course_name" class="form-label"><small>Course</small></label>
                            <select name="course_name" id="course_name" class="form-select">
                                <option value="">All Courses</option>
                                @foreach($courses as $course)
                                    <option value="{{ $course->name }}" {{ request('course_name') == $course->name ? 'selected' : '' }}>
                                        {{ $course->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
        
                        <div class="col-md-4 d-flex align-items-end gap-2 justify-content-between">
                            <button type="submit" class="btn btn-primary btn-sm mt-2">Filter</button>
                            </form>
                            <form method="GET" action="{{ route('enrollment-report.export') }}" onsubmit="return confirm('Export enrollment report as an Excel file?')" class="d-inline">
                                <input type="hidden" name="course_name" value="{{ request('course_name') }}">
                                <input type="hidden" name="month" value="{{ request('month') }}">
                                <button type="submit" class="btn btn-primary btn-sm mt-2">
                                    <i class="fa-solid fa-download"></i>
                                    <span class="d-none d-sm-inline">Export</span>
                                </button>
                            </form>                            
                        </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card-body">
        <div class="table-responsive container">
            <table class="table table-striped table-hover align-middle text-center">
                <thead class="">
                    <tr>
                        <th>No.</th>
                        <th>Student Name</th>
                        <th>Enrollment Date</th>
                        <th>Course Name</th>
                        <th>Start Date</th>
                        <th>Time</th>
                        <th>Fees</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($enrollmentReport as $index => $record)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>
                            <a href="#" 
                                class="text-decoration-none text-body student-detail-link" 
                                data-id="{{ $record->student_id }}"
                                data-bs-toggle="modal"
                                data-bs-target="#studentModal">
                                {{ $record->student_name ?? 'N/A' }}
                            </a>
                        </td>
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
                        <td>{{ $record->enrollment_date}}</td>
                        <td>
                            <a href="#" 
                                class="text-decoration-none text-body class-detail-link" 
                                data-id="{{ $record->class_id }}"
                                data-bs-toggle="modal"
                                data-bs-target="#classModal">
                                {{ $record->class_name ?? 'N/A' }}
                            </a>
                        </td>
                        <div class="modal fade" id="classModal" tabindex="-1" aria-labelledby="classModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content border-0">
                                    <div class="modal-header bg-success text-white">
                                    <h5 class="modal-title" id="classModalLabel">Class Details</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <div id="classDetailContent">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <td>{{ $record->start_date }}</td>
                        <td>{{ $record->time }}</td>
                        <td>$ {{ $record->fees }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center">No data found</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    <div class="card-footer bg-transparent border-0 pt-0">
        <div class="container">
            {{ $enrollmentReport->links('pagination::bootstrap-5') }}
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
            url: 'attendance-report/student/' + studentId, 
            type: 'GET',
            success: function(response) {
                $('#studentDetailContent').html(response);
            },
            error: function() {
                $('#studentDetailContent').html('<p class="text-danger">Error loading student details.</p>');
            }
        });
    });

    $(document).on('click', '.class-detail-link', function(e) {
        e.preventDefault();
        const classId = $(this).data('id');
        $('#classDetailContent').html('Loading...');

        $.ajax({
            url: 'attendance-report/class/' + classId, 
            type: 'GET',
            success: function(response) {
                $('#classDetailContent').html(response);
            },
            error: function() {
                $('#classDetailContent').html('<p class="text-danger">Error loading class details.</p>');
            }
        });
    });
</script>
@endsection