@extends('layouts.app')

@section('title', 'Teachers List')

@section('content')
<div class="card shadow-sm">
    <div class="card-header bg-white border-bottom">
        <div class="container d-flex justify-content-between align-items-center mt-1">
            <h2 class="d-inline mb-0">Teachers List</h2>
            @if(auth()->user()->hasRole('Admin') || auth()->user()->hasRole('Super admin'))
                <a href="{{ route('teachers.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus me-1"></i> Add New
                </a>
            @endif
        </div>

        @if(session('success'))
            <div class="container mt-3">
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            </div>
        @endif

        <div class="container mt-2">
            <div class="row">
                <div class="col-md-6 col-lg-4 mb-2 d-flex gap-2">
                    <form action="{{ route('teachers.search') }}" method="GET" class="w-100 input-group">
                        <input type="text" name="search_data" id="search_data" class="form-control" placeholder="Search..." value="{{ request('search_data') }}">
                        <button class="btn btn-secondary" type="submit" title="Search">
                            <i class="fas fa-search"></i>
                        </button>
                    </form>
                    <form action="{{ route('teachers.index') }}" method="GET">
                        <button type="submit" class="btn btn-secondary" title="Show All">
                            <i class="fas fa-sync-alt"></i>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="card-body">
        <div class="table-responsive container">
            <table class="table table-striped table-hover align-middle text-center">
                <thead class="table-light">
                    <tr>
                        <th class="text-nowrap">ID</th>
                        <th class="text-nowrap">Name</th>
                        <th class="text-nowrap">Subject</th>
                        <th class="text-nowrap">Email</th>
                        <th class="text-nowrap">Phone</th>
                        @if(auth()->user()->hasRole('Admin') || auth()->user()->hasRole('Super admin'))
                            <th class="text-nowrap">Actions</th>
                        @endif
                    </tr>
                </thead>
                <tbody>
                    @if($teachers->isNotEmpty())
                        @foreach($teachers as $teacher)
                            <tr>
                                <td>{{ $teacher->id }}</td>
                                <td>{{ $teacher->name }}</td>
                                <td>{{ $teacher->subject }}</td>
                                <td>{{ $teacher->email }}</td>
                                <td>{{ $teacher->phone }}</td>
                                @if(auth()->user()->hasRole('Admin') || auth()->user()->hasRole('Super admin'))
                                    <td>
                                        <div class="d-flex justify-content-center gap-2">
                                            <a href="{{ route('teachers.edit', $teacher->id) }}" class="btn btn-sm btn-success">
                                                <i class="fa-solid fa-pen-to-square me-1"></i> Edit
                                            </a>
                                            <form action="{{ route('teachers.destroy', $teacher->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this row?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger">
                                                    <i class="fas fa-trash me-1"></i> Delete
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                @endif
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="6" class="text-center text-muted">No data found</td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>

    <div class="card-footer border-0 bg-transparent pt-0">
        <div class="container">
            {{ $teachers->links('pagination::bootstrap-5') }}
        </div>
    </div>
</div>
@endsection
