@extends('layouts.app')
@section('title', 'Users List')
@section('content')
<div class="container d-flex justify-content-between align-items-center">
    <h2 class="d-inline">Users List</h2>
    @if(auth()->user()->hasRole('Admin') || auth()->user()->hasRole('Super Admin'))
    <a href="{{ route('users.create') }}" class="btn btn-primary my-2"><i class="fas fa-plus"></i> Add new</a>
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
<div class="container">
    <div class="row my-3">
        <div class="col-10">
            <form action="{{route('users.search')}}" method="GET">
                @csrf
                <div class="input-group">
                    <input type="text" name="search_data" id="search_data" class="form-control" placeholder="Search ...." aria-label="Search" value="{{ request('search_data') }}">
                    <button class="btn btn-outline-secondary" type="submit"><i class="fas fa-search"></i></button>
                </div>
            </form>
        </div>
        <div class="col-2 text-end">
            <form action="{{ route('users.index') }}" method="GET" class="d-inline">
                @csrf
                <button type="submit" class="btn btn-secondary" title="Show All"><i class="fas fa-sync"></i></button>
            </form>
        </div>
    </div>
</div>
<div class="table-responsive container my-3">
    <table class="table table-hover table-bordered table-striped">
        <thead>
        <tr>
            @if(auth()->user()->hasRole('Admin') || auth()->user()->hasRole('Super Admin'))
          <th scope="col"></th>
          @endif
          <th scope="col">ID</th>
          <th scope="col">Name</th>
          <th scope="col">Email</th>
          <th scope="col">Role</th>
        </tr>
        </thead>
        <tbody>
        @if($users->isNotEmpty())
            @foreach($users as $user)
              <tr>
                @if(auth()->user()->hasRole('Admin') || auth()->user()->hasRole('Super Admin'))
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
            <td>{{$user->role ? $user->role->name : 'N/A' }}</td>
              </tr>
            @endforeach
        @else
            <tr>
            <td colspan="5" class="text-center">No data found</td>
            </tr>
        @endif
        </tbody>
    </table>
</div>
{{ $users->links('pagination::bootstrap-5') }}
@endsection
