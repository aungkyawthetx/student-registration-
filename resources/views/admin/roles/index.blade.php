@extends('layouts.app')
@section('title', 'Roles List')
@section('content')
<div class="container d-flex justify-content-between align-items-center">
    <h2 class="d-inline">Roles List</h2>
    <div class="d-flex align-items-center justify-content-center gap-2">
        @if(auth()->user()->hasRole($roles[1]->name) || auth()->user()->hasRole($roles->first()->name))
        {{-- <a href="{{ route('roles.create') }}" class="btn btn-primary my-2"><i class="fas fa-plus"></i> Add new</a> --}}
        <form action="{{route('roles.import')}}" method="POST" enctype="multipart/form-data">
            @csrf
            <input type="file" name="roles" id="roles" class="form-control-sm" required>
            <button type="submit" class="btn btn-primary my-2" title="Import"><i class="fa-solid fa-upload"></i></button>
        </form>
        <a href="{{ route('roles.export') }}" class="btn btn-primary my-2" title="Export" onclick="return confirm('Export roles data as an excel file?')"><i class="fa-solid fa-download"></i></a>
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
            <form action="{{route('roles.search')}}" method="GET">
                @csrf
                <div class="input-group">
                    <input type="text" name="search_data" id="search_data" class="form-control" placeholder="Search ...." aria-label="Search" value="{{ request('search_data') }}">
                    <button class="btn btn-outline-secondary" type="submit"><i class="fas fa-search"></i></button>
                </div>
            </form>
        </div>
        <div class="col-2 text-end">
            <form action="{{ route('roles.index') }}" method="GET" class="d-inline">
                @csrf
                <button type="submit" class="btn btn-secondary" title="Show All"><i class="fas fa-sync"></i></button>
            </form>
        </div>
        {{-- <div class="col-2 text-end">
            @if(auth()->user()->hasRole($roles[1]->name) || auth()->user()->hasRole($roles->first()->name))
            <form action="{{ route('roles.destroy-all') }}" method="POST" class="d-inline">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete all roles?')"><i class="fas fa-trash"></i></button>
            </form>
            @endif
        </div> --}}
    </div>
</div>
<div class="table-responsive container my-3">
    <table class="table table-hover table-bordered table-striped text-center">
        <thead>
        <tr>
        @if(auth()->user()->hasRole($roles->first()->name))
          <th scope="col"></th>
        @endif
          <th scope="col">ID</th>
          <th scope="col">Name</th>
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
                @if(auth()->user()->hasRole($roles->first()->name))
                <td>
                    <div class="d-flex">
                        <a href="{{ route('roles.edit', $role->id) }}" class="btn btn-sm btn-primary m-1"><i class="fas fa-edit"></i></a>
                        {{-- <form action="{{ route('roles.destroy', $role->id) }}" method="POST" class="d-inline m-1">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete?')"><i class="fas fa-trash"></i></button>
                        </form> --}}
                    </div>
                </td>
                @endif
            </tr>
            @endforeach
        @else
            <tr>
                <td colspan="4" class="text-center">No data found</td>
            </tr>
        @endif
        </tbody>
    </table>
</div>
{{ $roles->links('pagination::bootstrap-5') }}
@endsection
