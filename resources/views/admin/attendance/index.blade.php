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
                            <th>ID</th>
                            <th>Student Name</th>
                            <th>Date</th>
                            <th>Course Name</th>
                            <th>Room</th>
                            <th>Status</th>
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
                                    <td>{{ $attendance->student->name ?? 'no student' }}</td>
                                    <td>{{ $attendance->attendance_date }}</td>
                                    <td>{{ $attendance->course->name ?? 'no course' }}</td>
                                    <td>{{ $attendance->room->name ?? 'no room' }}</td>
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
@endsection