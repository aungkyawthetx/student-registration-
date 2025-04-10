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
            <div class="col-12 col-md-6 d-flex gap-2 mb-2 mb-md-0">
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

            <div class="col-12 col-md-6">
                @if(auth()->user()->hasRole($roles[1]->name) || auth()->user()->hasRole($roles->first()->name))
                    <div class="d-flex flex-wrap justify-content-md-end gap-2">
                        <a href="{{ route('enrollment-report.export') }}" class="btn btn-primary btn-sm" title="Export" onclick="return confirm('Export students data as an excel file?')">
                            <i class="fa-solid fa-download"></i>
                            <span class="d-none d-sm-inline">Export</span>
                        </a>
                    </div>
                @endif
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
                        <th>Class Name</th>
                        <th>Start Date</th>
                        <th>Time</th>
                        <th>Fees</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($enrollmentReport as $index => $record)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $record->student_name}}</td>
                        <td>{{ $record->enrollment_date}}</td>
                        <td>{{ $record->class_name}}</td>
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
@endsection