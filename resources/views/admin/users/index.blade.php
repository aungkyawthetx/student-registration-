@extends('layouts.app')

@section('title', 'Users List')

@section('content')
<div class="container d-flex justify-content-between align-items-center">
    <h2 class="d-inline">Users List</h2>
    <div class="d-flex align-items-center justify-content-center gap-2">
        @if(auth()->user()->hasRole($roles[1]->name) || auth()->user()->hasRole($roles->first()->name))
        <a href="{{ route('users.create') }}" class="btn btn-primary my-2"><i class="fas fa-plus"></i> Add new</a>
        <form action="{{route('users.import')}}" method="POST" enctype="multipart/form-data" class="">
            @csrf
            <input type="file" name="users" id="users" class="form-control-sm" required>
            <button type="submit" class="btn btn-primary my-2" title="Import"><i class="fa-solid fa-upload"></i></button>
        </form>
        <a href="{{ route('users.export') }}" class="btn btn-primary my-2" title="Export" onclick="return confirm('Export users data as an excel file?')"><i class="fa-solid fa-download"></i></a>
        @endif
    </div>
</div>
<div class="container">
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show mt-3" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show mt-3" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
</div>
<div class="container">
    <div class="row my-3">
        <div class="col-8">
            <form action="{{route('users.search')}}" method="GET">
                @csrf
                <div class="input-group">
                    <input type="text" name="search_data" id="search_data" class="form-control" placeholder="Search ...." aria-label="Search" value="{{ request('search_data') }}">
                    <button class="btn btn-outline-secondary" type="submit"><i class="fas fa-search"></i></button>
                </div>
            </form>
        </div>
        <div class="col-2">
            <form action="{{ route('users.index') }}" method="GET" class="d-inline">
                @csrf
                <button type="submit" class="btn btn-secondary" title="Show All"><i class="fas fa-sync"></i></button>
            </form>
        </div>
        <div class="col-2 text-end">
            @if(auth()->user()->hasRole($roles[1]->name) || auth()->user()->hasRole($roles->first()->name))
            <form action="{{ route('users.destroy-all', Auth()->user()->id) }}" method="POST" class="d-inline">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete all users (except current account)?')"><i class="fas fa-trash"></i></button>
            </form>
            @endif
        </div>
    </div>
</div>
<div class="table-responsive container my-3">
    <table class="table table-hover table-bordered table-striped">
        <thead>
        <tr>
        @if(auth()->user()->hasRole($roles[1]->name) || auth()->user()->hasRole($roles->first()->name))
          <th scope="col"></th>
          @endif
          <th scope="col">ID</th>
          <th scope="col">Name</th>
          <th scope="col">Email</th>
          @if(auth()->user()->hasRole($roles->first()->name))
          <th scope="col">Password</th>
          @endif
          <th scope="col">Role</th>
        </tr>
        </thead>
        <tbody>
        @if($users->isNotEmpty())
            @foreach($users as $user)
              <tr>
                @if(auth()->user()->hasRole($roles[1]->name) || auth()->user()->hasRole($roles->first()->name))
            <td>
                <div class="d-flex">
                <a href="{{ route('users.edit', $user->id) }}" class="btn btn-sm btn-primary m-1"><i class="fas fa-edit"></i></a>
                <form action="{{ route('users.destroy', $user->id) }}" method="POST" class="d-inline m-1">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete?')"><i class="fas fa-trash"></i></button>
                </form>
                </div>
            </td>
            @endif
            <th scope="row">{{$user->id}}</th>
            <td>{{$user->name}}</td>
            <td>{{$user->email}}</td>
            @if(auth()->user()->hasRole($roles->first()->name))
            <td>
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#viewPasswordModal{{ $user->id }}">
                <i class="fas fa-edit"></i>
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