@extends('layouts.app')

@section('title', 'Users List')

@section('content')
<div class="container my-4">
    <div class="card shadow-sm rounded">
        <div class="card-header container bg-transparent border-bottom">
            <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-3">
                <h2 class="card-title mb-0">Users List</h2>
                <div class="d-flex flex-wrap align-items-center gap-2">
                    @if(auth()->user()->hasRole($roles[1]->name) || auth()->user()->hasRole($roles->first()->name))
                        <a href="{{ route('users.create') }}" class="btn btn-primary btn-sm">
                            <span class="d-none d-sm-inline">New User</span>
                            <i class="fas fa-plus me-1"></i>
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
                    <form action="{{ route('users.search') }}" method="GET" class="w-100 input-group">
                        <input type="text" name="search_data" id="search_data" class="form-control form-control-sm" placeholder="Search..." value="{{ request('search_data') }}">
                        <button class="btn btn-secondary btn-sm" type="submit" title="Search">
                            <i class="fas fa-search"></i>
                        </button>
                    </form>
                    <form action="{{ route('users.index') }}" method="GET">
                        <button type="submit" class="btn btn-secondary btn-sm" title="Show All">
                            <i class="fas fa-sync-alt"></i>
                        </button>
                    </form>
                </div>
    
                <div class="col-12 col-md-6">
                    @if(auth()->user()->hasRole($roles[1]->name) || auth()->user()->hasRole($roles->first()->name))
                        <div class="d-flex flex-wrap justify-content-md-end gap-2">
                            <form action="{{ route('users.import') }}" method="POST" enctype="multipart/form-data" class="d-flex align-items-center gap-2">
                                @csrf
                                <div class="input-group input-group-sm" style="width: 150px;">
                                    <input type="file" name="users" class="form-control form-control-sm" required>
                                </div>
                                <button type="submit" class="btn btn-primary btn-sm" title="Import">
                                    <i class="fa-solid fa-upload"></i>
                                    <span class="d-none d-sm-inline">Import</span>
                                </button>
                            </form>
                            <a href="{{ route('users.export') }}" class="btn btn-primary btn-sm" title="Export" onclick="return confirm('Export users data as an excel file?')">
                                <i class="fa-solid fa-download"></i>
                                <span class="d-none d-sm-inline">Export</span>
                            </a>
                            <form action="{{ route('users.destroy-all', Auth()->user()->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete all users (except current account)?')">
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
                            <th scope="col">Email</th>
                            @if(auth()->user()->hasRole($roles->first()->name))
                                <th scope="col">Password</th>
                            @endif
                            <th scope="col">Role</th>
                            @if(auth()->user()->hasRole($roles[1]->name) || auth()->user()->hasRole($roles->first()->name))
                                <th scope="col">Actions</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody>
                        @if($users->isNotEmpty())
                            @foreach($users as $user)
                                <tr>
                                    <td>{{ $user->id }}</td>
                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->email }}</td>
                                    @if(auth()->user()->hasRole($roles->first()->name))
                                        <td>
                                            <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#viewPasswordModal{{ $user->id }}">
                                                <i class="fas fa-eye"></i>
                                                <span class="d-none d-sm-inline">View</span>
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
                                    @if(auth()->user()->hasRole($roles[1]->name) || auth()->user()->hasRole($roles->first()->name))
                                        <td>
                                            <div class="d-flex justify-content-center gap-2">
                                                <a href="{{ route('users.edit', $user->id) }}" class="btn btn-sm btn-success">
                                                    <i class="fas fa-edit"></i>
                                                    <span class="d-none d-sm-inline">Edit</span>
                                                </a>
                                                <form action="{{ route('users.destroy', $user->id) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this user?')">
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
                                <td colspan="{{ auth()->user()->hasRole($roles[1]->name) || auth()->user()->hasRole($roles->first()->name) ? (auth()->user()->hasRole($roles->first()->name) ? 6 : 5) : (auth()->user()->hasRole($roles->first()->name) ? 4 : 3) }}" class="text-center">
                                    No users found
                                </td>
                            </tr>
                        @endif
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
</div>
@endsection