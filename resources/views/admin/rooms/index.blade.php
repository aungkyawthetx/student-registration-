@extends('layouts.app')

@section('title', 'Rooms List')

@section('content')
<div class="card shadow-sm">
    <div class="card-header bg-white border-bottom">
        <div class="container d-flex justify-content-between align-items-center mt-1">
            <h2 class="d-inline mb-0">Rooms List</h2>
            @if(auth()->user()->hasRole('Admin') || auth()->user()->hasRole('Super admin'))
                <a href="{{ route('rooms.create') }}" class="btn btn-primary">
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
                <div class="col-md-6 col-lg-4 d-flex gap-2">
                    <form action="{{ route('rooms.search') }}" method="GET" class="mb-2 w-100 input-group">
                        @csrf
                        <div class="input-group">
                            <input type="text" name="search_data" id="search_data" class="form-control" placeholder="Search..." value="{{ request('search_data') }}">
                            <button class="btn btn-secondary" type="submit" title="Search">
                                <i class="fas fa-search"></i>
                            </button>
                        </div>
                    </form>

                    <form action="{{ route('rooms.index') }}" method="GET">
                        <button type="submit" class="btn btn-secondary w-100" title="Show All">
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
                        <th>ID</th>
                        <th>Building</th>
                        <th>Name</th>
                        @if(auth()->user()->hasRole('Admin') || auth()->user()->hasRole('Super admin'))
                            <th>Actions</th>
                        @endif
                    </tr>
                </thead>
                <tbody>
                    @if($rooms->isNotEmpty())
                        @foreach($rooms as $room)
                            <tr>
                                <td>{{ $room->id }}</td>
                                <td>{{ $room->building }}</td>
                                <td>{{ $room->name }}</td>
                                @if(auth()->user()->hasRole('Admin') || auth()->user()->hasRole('Super admin'))
                                    <td>
                                        <div class="d-flex justify-content-center gap-2">
                                            <a href="{{ route('rooms.edit', $room->id) }}" class="btn btn-sm btn-success">
                                                <i class="fa-solid fa-pen-to-square me-1"></i> Edit
                                            </a>
                                            <form action="{{ route('rooms.destroy', $room->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this row?')">
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
                            <td colspan="4" class="text-center text-muted">No data found</td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>

    <div class="card-footer border-0 bg-transparent pt-0">
        <div class="container">
            {{ $rooms->links('pagination::bootstrap-5') }}
        </div>
    </div>
</div>
@endsection