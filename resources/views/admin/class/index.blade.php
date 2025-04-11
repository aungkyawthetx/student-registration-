@extends('layouts.app')

@section('title', 'Class List')

@section('content')
<div class="container my-4">
    <div class="card shadow-sm rounded">
        <div class="card-header container bg-transparent border-bottom">
            <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-3">
                <h2 class="card-title mb-0">Class List</h2>
                <div class="d-flex flex-wrap align-items-center gap-2">
                    @if(auth()->user()->hasRole($roles[1]->name) || auth()->user()->hasRole($roles->first()->name))
                        <a href="{{ route('classes.create') }}" class="btn btn-primary btn-sm">
                            <span class="d-none d-sm-inline">New Class</span>
                            <i class="fas fa-plus me-1"></i>
                        </a>
                    @endif
                </div>
            </div>

            @if(Session('successAlert'))
                <div class="alert alert-success alert-dismissible fade show mt-2" role="alert">
                    {{ Session('successAlert') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            @if(Session('errorAlert'))
                <div class="alert alert-danger alert-dismissible fade show mt-2" role="alert">
                    {{ Session('errorAlert') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <div class="row mt-3">
                <div class="col-12 d-flex flex-column flex-md-row align-items-stretch align-items-md-center justify-content-between gap-2">
                    <div class="d-flex flex-grow-1 gap-2" style="max-width: 400px;">
                        <form action="{{ route('classes.search') }}" method="GET" class="d-flex flex-grow-1 input-group">
                            <input type="text" name="search_data" id="search_data" class="form-control" placeholder="Search..." value="{{ request('search_data') }}">
                            <button class="btn btn-secondary" type="submit" title="Search">
                                <i class="fas fa-search"></i>
                            </button>
                        </form>
                        <a href="{{ route('classes.index') }}" class="btn btn-secondary" title="Show All">
                            <i class="fas fa-sync-alt"></i>
                        </a>
                    </div>
                    @if(auth()->user()->hasRole($roles[1]->name) || auth()->user()->hasRole($roles->first()->name))
                        <div class="d-flex flex-wrap justify-content-md-end gap-2">
                            <form action="{{ route('classes.import') }}" method="POST" enctype="multipart/form-data" class="d-flex align-items-center gap-2">
                                @csrf
                                <div class="input-group input-group-sm" style="width: 150px;">
                                    <input type="file" name="classes" class="form-control form-control-sm" required>
                                </div>
                                <button type="submit" class="btn btn-primary btn-sm" title="Import">
                                    <i class="fa-solid fa-upload"></i>
                                    <span class="d-none d-sm-inline">Import</span>
                                </button>
                            </form>
                            <a href="{{ route('classes.export') }}" class="btn btn-primary btn-sm" title="Export" onclick="return confirm('Export classes data as an excel file?')">
                                <i class="fa-solid fa-download"></i>
                                <span class="d-none d-sm-inline">Export</span>
                            </a>
                            <form action="{{ route('classes.destroy-all') }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete all classes?')">
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
                            <th scope="col">Course Name</th>
                            <th scope="col">Room Name</th>
                            <th scope="col">Start Date</th>
                            <th scope="col">End Date</th>
                            <th scope="col">Time</th>
                            @if(auth()->user()->hasRole($roles[1]->name) || auth()->user()->hasRole($roles->first()->name))
                                <th scope="col">Actions</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody>
                        @if($classes->isNotEmpty())
                            @foreach($classes as $class)
                                <tr>
                                    <td>{{ $class->id }}</td>
                                    <td>{{ $class->course ? $class->course->name : 'no course' }}</td>
                                    <td>{{ $class->room ? $class->room->name : 'no room' }}</td>
                                    <td>{{ $class->start_date }}</td>
                                    <td>{{ $class->end_date }}</td>
                                    <td>{{ $class->time }}</td>
                                    @if(auth()->user()->hasRole($roles[1]->name) || auth()->user()->hasRole($roles->first()->name))
                                        <td>
                                            <div class="d-flex justify-content-center gap-2">
                                                <a href="{{ route('classes.edit', $class->id) }}" class="btn btn-sm btn-success">
                                                    <i class="fas fa-edit"></i>
                                                    <span class="d-none d-sm-inline">Edit</span>
                                                </a>
                                                <form action="{{ route('classes.destroy', $class->id) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this class?')">
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
                                <td colspan="{{ auth()->user()->hasRole($roles[1]->name) || auth()->user()->hasRole($roles->first()->name) ? 7 : 6 }}" class="text-center">
                                    No classes found
                                </td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>

        <div class="card-footer bg-transparent border-0 pt-0">
            <div class="container">
                {{ $classes->links('pagination::bootstrap-5') }}
            </div>
        </div>
    </div>
</div>
@endsection