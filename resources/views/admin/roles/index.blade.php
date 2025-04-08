@extends('layouts.app')
@section('title', 'Roles List')

@section('content')
<div class="card shadow-sm">
    <div class="container card-header border-bottom bg-white">
        <div class="d-flex justify-content-between align-items-center">
            <h2 class="card-title d-inline mb-0">Roles List</h2>
            @if(auth()->user()->hasRole('Super admin'))
                <a href="{{ route('roles.create') }}" class="btn btn-primary my-2">
                    <i class="fas fa-plus me-1"></i> Add new
                </a>
            @endif
        </div>
        <div class="container">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show mt-3" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
        </div>

        <div class="row">
            <div class="col-md-6 col-lg-4 mb-2 d-flex gap-2">
                <form action="{{ route('roles.search') }}" method="GET" class="input-group">
                    @csrf
                    <input type="text" name="search_data" id="search_data" class="form-control rounded" placeholder="Search..." value="{{ request('search_data') }}">
                    <button class="btn btn-secondary" type="submit" title="Search">
                        <i class="fas fa-search"></i>
                    </button>
                </form>
                <form action="{{ route('roles.index') }}" method="GET" class="d-inline">
                    @csrf
                    <button type="submit" class="btn btn-secondary" title="Reset Filter">
                        <i class="fas fa-sync"></i>
                    </button>
                </form>
            </div>
        </div>
    </div>
    <div class="card-body">
        <div class="table-responsive container">
            <table class="table table-striped table-hover align-middle text-center">
                <thead class="table-light">
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col">Role Name</th>
                        <th scope="col">Description</th>
                        @if(auth()->user()->hasRole('Super admin'))
                            <th scope="col">Actions</th>
                        @endif
                    </tr>
                </thead>
                <tbody>
                    @if($roles->isNotEmpty())
                        @foreach($roles as $role)
                            <tr>
                                <td>{{ $role->id }}</td>
                                <td>{{ $role->name }}</td>
                                <td>{{ $role->description }}</td>
                                @if(auth()->user()->hasRole('Super admin'))
                                    <td>
                                        <a href="{{ route('roles.edit', $role->id) }}" class="btn btn-sm btn-success me-2">
                                            Edit <i class="fa-solid fa-pen-to-square ms-1"></i>
                                        </a>
                                        <form action="{{ route('roles.destroy', $role->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger" 
                                                    onclick="return confirm('Are you sure you want to delete this role?')">
                                                Delete <i class="fas fa-trash ms-1"></i>
                                            </button>
                                        </form>
                                    </td>
                                @endif
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="{{ auth()->user()->hasRole('Super admin') ? 4 : 3 }}" class="text-center">
                                No roles found
                            </td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>
    <div class="card-footer bg-transparent pt-0 border-0">
        <div class="container">
            {{ $roles->links('pagination::bootstrap-5') }}
        </div>
    </div>
</div>
@endsection