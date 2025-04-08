@extends('layouts.app')

@section('title', 'Users List')

@section('content')
<div class="card shadow-sm">
    <div class="card-header bg-white border-bottom">
        <div class="container d-flex justify-content-between align-items-center mt-1">
            <h2 class="card-title mb-0">Users List</h2>
            @if(auth()->user()->hasRole('Admin') || auth()->user()->hasRole('Super admin'))
            <a href="{{ route('users.create') }}" class="btn btn-primary">
                <i class="fas fa-plus me-1"></i> New User
            </a>
            @endif
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

        <div class="container mt-2">
            <div class="row">
                <div class="col-md-6 col-lg-4 mb-2 d-flex gap-2">
                    <form action="{{ route('users.search') }}" method="GET" class="w-100 input-group">
                        @csrf
                        <div class="input-group">
                            <input type="text" name="search_data" id="search_data" class="form-control" placeholder="Search..." value="{{ request('search_data') }}">
                            <button class="btn btn-secondary" type="submit"><i class="fas fa-search"></i></button>
                        </div>
                    </form>
                    <form action="{{ route('users.index') }}" method="GET" class="d-inline">
                        @csrf
                        <button type="submit" class="btn btn-secondary" title="Reset Filters"><i class="fas fa-sync"></i></button>
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
                        <th>Name</th>
                        <th>Email</th>
                        @if(auth()->user()->hasRole('Super admin'))
                        <th>Password</th>
                        @endif
                        <th>Role</th>
                        @if(auth()->user()->hasRole('Admin') || auth()->user()->hasRole('Super admin'))
                        <th>Actions</th>
                        @endif
                    </tr>
                </thead>
                <tbody>
                    @forelse($users as $user)
                    <tr>
                        <td>{{ $user->id }}</td>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>

                        @if(auth()->user()->hasRole('Super admin'))
                        <td>
                            <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#viewPasswordModal{{ $user->id }}">
                                <i class="fas fa-key"></i>
                            </button>

                            <!-- Password Modal -->
                            <div class="modal fade" id="viewPasswordModal{{ $user->id }}" tabindex="-1" aria-labelledby="viewPasswordLabel{{ $user->id }}" aria-hidden="true">
                                <div class="modal-dialog">
                                    <form method="POST" action="{{ route('verify-password-view') }}">
                                        @csrf
                                        <input type="hidden" name="user_id" value="{{ $user->id }}">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Verify Your Password</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                            </div>
                                            <div class="modal-body">
                                                <input type="password" name="password" class="form-control" placeholder="Enter your password" required>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="submit" class="btn btn-primary">Verify</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </td>
                        @endif

                        <td>{{ $user->role ? $user->role->name : 'N/A' }}</td>

                        @if(auth()->user()->hasRole('Admin') || auth()->user()->hasRole('Super admin'))
                        <td>
                            <div class="d-flex justify-content-center gap-2">
                                <a href="{{ route('users.edit', $user->id) }}" class="btn btn-sm btn-success" title="Edit">
                                    <i class="fas fa-pen-to-square me-1"></i> Edit
                                </a>
                                <form action="{{ route('users.destroy', $user->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this row?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" title="Delete">
                                        <i class="fas fa-trash me-1"></i> Delete
                                    </button>
                                </form>
                            </div>
                        </td>
                        @endif
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center">No data found</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    <div class="card-footer bg-transparent border-0 pt-0">
        <div class="container">
            {{ $users->links('pagination::bootstrap-5') }}
        </div>
    </div>
</div>
@endsection