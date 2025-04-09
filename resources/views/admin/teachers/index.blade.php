@extends('layouts.app')

@section('title', 'Teachers List')

@section('content')
<div class="container my-4">
    <div class="card shadow-sm rounded">
        <div class="card-header container bg-transparent border-bottom">
            <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-3">
                <h2 class="card-title mb-0">Teachers List</h2>
                <div class="d-flex flex-wrap align-items-center gap-2">
                    @if(auth()->user()->hasRole($roles[1]->name) || auth()->user()->hasRole($roles->first()->name))
                        <a href="{{ route('teachers.create') }}" class="btn btn-primary btn-sm">
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

            <div class="row my-2">
                <div class="col-12 col-md-6 col-lg-4 d-flex gap-2 mb-2 mb-md-0">
                    <form action="{{ route('teachers.search') }}" method="GET" class="w-100 input-group">
                        <input type="text" name="search_data" id="search_data" class="form-control form-control-sm" placeholder="Search..." value="{{ request('search_data') }}">
                        <button class="btn btn-secondary btn-sm" type="submit" title="Search">
                            <i class="fas fa-search"></i>
                        </button>
                    </form>
                    <form action="{{ route('teachers.index') }}" method="GET">
                        <button type="submit" class="btn btn-secondary btn-sm" title="Show All">
                            <i class="fas fa-sync-alt"></i>
                        </button>
                    </form>
                </div>
                <div class="col-12 col-md-6">
                    @if(auth()->user()->hasRole($roles[1]->name) || auth()->user()->hasRole($roles->first()->name))
                        <div class="d-flex flex-wrap justify-content-md-end gap-2">
                            <form action="{{ route('teachers.import') }}" method="POST" enctype="multipart/form-data" class="d-flex align-items-center gap-2">
                                @csrf
                                <div class="input-group input-group-sm" style="width: 150px;">
                                    <input type="file" name="teachers" class="form-control form-control-sm" required>
                                </div>
                                <button type="submit" class="btn btn-primary btn-sm" title="Import">
                                    <i class="fa-solid fa-upload"></i>
                                    <span class="d-none d-sm-inline">Import</span>
                                </button>
                            </form>
                            <a href="{{ route('teachers.export') }}" class="btn btn-primary btn-sm" title="Export" onclick="return confirm('Export teachers data as an excel file?')">
                                <i class="fa-solid fa-download"></i>
                                <span class="d-none d-sm-inline">Export</span>
                            </a>
                            <form action="{{ route('teachers.destroy-all') }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete all teachers?')">
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
                            <th scope="col">Name</th>
                            <th scope="col">Subject</th>
                            <th scope="col">Email</th>
                            <th scope="col">Phone</th>
                            @if(auth()->user()->hasRole($roles[1]->name) || auth()->user()->hasRole($roles->first()->name))
                                <th scope="col">Actions</th>
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
                                    @if(auth()->user()->hasRole($roles[1]->name) || auth()->user()->hasRole($roles->first()->name))
                                        <td>
                                            <div class="d-flex justify-content-center gap-2">
                                                <a href="{{ route('teachers.edit', $teacher->id) }}" class="btn btn-sm btn-success">
                                                    <i class="fas fa-edit"></i>
                                                    <span class="d-none d-sm-inline">Edit</span>
                                                </a>
                                                <form action="{{ route('teachers.destroy', $teacher->id) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this teacher?')">
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
                                <td colspan="{{ auth()->user()->hasRole($roles[1]->name) || auth()->user()->hasRole($roles->first()->name) ? 6 : 5 }}" class="text-center">No data found</td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>

        <div class="card-footer bg-transparent border-0 pt-0">
            <div class="container">
                {{ $teachers->links('pagination::bootstrap-5') }}
            </div>
        </div>
    </div>
</div>
@endsection