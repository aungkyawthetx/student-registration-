@extends('layouts.app')

@section('title', 'Students List')

@section('content')
<div class="card shadow-sm">
    <div class="card-header bg-white border-bottom">
        <div class="container d-flex justify-content-between align-items-center mt-1">
            <h2 class="d-inline mb-0 card-title">Student List</h2>
            @if(auth()->user()->hasRole('Admin') || auth()->user()->hasRole('Super admin'))
                <a href="{{ route('students.create') }}" class="btn btn-primary">
                    <i class="fas fa-user-plus me-1"></i> Add Student
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
                    <form action="{{ route('students.search') }}" method="GET" class="w-100 input-group">
                        <input type="text" name="search_data" id="search_data" class="form-control" placeholder="Search..." value="{{ request('search_data') }}">
                        <button class="btn btn-secondary" type="submit" title="Search">
                            <i class="fas fa-search"></i>
                        </button>
                    </form>
                    <form action="{{ route('students.index') }}" method="GET">
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
                        <th class="text-nowrap">Gender</th>
                        <th class="text-nowrap">NRC</th>
                        <th class="text-nowrap">DOB</th>
                        <th class="text-nowrap">Email</th>
                        <th class="text-nowrap">Phone</th>
                        <th class="text-nowrap">Address</th>
                        <th class="text-nowrap">Parent Info</th>
                        @if(auth()->user()->hasRole('Admin') || auth()->user()->hasRole('Super admin'))
                            <th class="text-nowrap">Actions</th>
                        @endif
                    </tr>
                </thead>
                <tbody>
                    @if($students->isNotEmpty())
                        @foreach($students as $student)
                            <tr>
                                <td>{{ $student->id }}</td>
                                <td>{{ $student->name }}</td>
                                <td>{{ $student->gender }}</td>
                                <td>{{ $student->nrc }}</td>
                                <td>{{ $student->dob }}</td>
                                <td>{{ $student->email }}</td>
                                <td>{{ $student->phone }}</td>
                                <td>{{ $student->address }}</td>
                                <td>{{ $student->parent_info }}</td>
                                @if(auth()->user()->hasRole('Admin') || auth()->user()->hasRole('Super admin'))
                                    <td>
                                        <div class="d-flex justify-content-center gap-2">
                                            <a href="{{ route('students.edit', $student->id) }}" class="btn btn-sm btn-success">
                                                <i class="fa-solid fa-pen-to-square me-1"></i> Edit
                                            </a>
                                            <form action="{{ route('students.destroy', $student->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this row?')">
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
                            <td colspan="10" class="text-center text-muted">No data found</td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>

    <div class="card-footer border-0 bg-transparent pt-0">
        <div class="container">
            {{ $students->links('pagination::bootstrap-5') }}
        </div>
    </div>
</div>
@endsection
