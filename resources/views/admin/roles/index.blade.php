@extends('layouts.app')

@section('title', 'Roles List')

@section('content')
<div class="container my-4">
    <div class="card shadow-sm rounded">
        <div class="card-header container bg-transparent border-bottom">
            <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-3">
                <h2 class="card-title mb-0">Roles List</h2>
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

            <div class="row mt-3">
                <div class="col-12 d-flex flex-column flex-md-row align-items-stretch align-items-md-center justify-content-between gap-2">
                    <div class="d-flex flex-grow-1 gap-2" style="max-width: 400px;">
                        <form action="{{ route('roles.search') }}" method="GET" class="d-flex flex-grow-1 input-group">
                            <input type="text" name="search_data" id="search_data" class="form-control" placeholder="Search..." value="{{ request('search_data') }}">
                            <button class="btn btn-secondary" type="submit" title="Search">
                                <i class="fas fa-search"></i>
                            </button>
                        </form>
                        <a href="{{ route('roles.index') }}" class="btn btn-secondary" title="Show All">
                            <i class="fas fa-sync-alt"></i>
                        </a>
                    </div>
                    @if(auth()->user()->hasRole($roles[1]->name) || auth()->user()->hasRole($roles->first()->name))
                        <a href="{{ route('roles.export') }}" class="btn btn-primary" title="Export" onclick="return confirm('Export roles data as an excel file?')">
                            <i class="fa-solid fa-download"></i>
                            <span class="d-none d-sm-inline">Export</span>
                        </a>
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
                            <th scope="col">Description</th>
                            @if(auth()->user()->hasRole($roles->first()->name))
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
                                    @if(auth()->user()->hasRole($roles->first()->name))
                                        <td>
                                            <div class="d-flex justify-content-center gap-2">
                                                <a href="{{ route('roles.edit', $role->id) }}" class="btn btn-sm btn-success">
                                                    <i class="fas fa-edit"></i>
                                                    <span class="d-none d-sm-inline">Edit</span>
                                                </a>
                                            </div>
                                        </td>
                                    @endif
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="{{ auth()->user()->hasRole($roles->first()->name) ? 4 : 3 }}" class="text-center">
                                    No roles found
                                </td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>

        <div class="card-footer bg-transparent border-0 pt-0">
            <div class="container">
                {{ $roles->links('pagination::bootstrap-5') }}
            </div>
        </div>
    </div>
</div>
@endsection