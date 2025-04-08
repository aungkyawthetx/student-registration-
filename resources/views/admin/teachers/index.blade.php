@extends('layouts.app')
@section('title', 'Teachers List')
@section('content')
<div class="container d-flex justify-content-between align-items-center">
    <h2 class="d-inline">Teachers List</h2>
    <div class="d-flex align-items-center justify-content-center gap-2">
        @if(auth()->user()->hasRole($roles[1]->name) || auth()->user()->hasRole($roles->first()->name))
        <a href="{{ route('teachers.create') }}" class="btn btn-primary my-2"><i class="fas fa-plus"></i> Add new</a>
        <form action="{{route('teachers.import')}}" method="POST" enctype="multipart/form-data">
            @csrf
            <input type="file" name="teachers" id="teachers" class="form-control-sm" required>
            <button type="submit" class="btn btn-primary my-2" title="Import"><i class="fa-solid fa-upload"></i></button>
        </form>
        <a href="{{ route('teachers.export') }}" class="btn btn-primary my-2" title="Export" onclick="return confirm('Export teachers data as an excel file?')"><i class="fa-solid fa-download"></i></a>
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
            <form action="{{route('teachers.search')}}" method="GET">
                @csrf
                <div class="input-group">
                    <input type="text" name="search_data" id="search_data" class="form-control" placeholder="Search ...." aria-label="Search" value="{{ request('search_data') }}">
                    <button class="btn btn-outline-secondary" type="submit"><i class="fas fa-search"></i></button>
                </div>
            </form>
        </div>
        <div class="col-2 text-end">
            <form action="{{ route('teachers.index') }}" method="GET" class="d-inline">
                @csrf
                <button type="submit" class="btn btn-secondary" title="Show All"><i class="fas fa-sync"></i></button>
            </form>
        </div>
        <div class="col-2 text-end">
            @if(auth()->user()->hasRole($roles[1]->name) || auth()->user()->hasRole($roles->first()->name))
            <form action="{{ route('teachers.destroy-all') }}" method="POST" class="d-inline">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete all teachers?')"><i class="fas fa-trash"></i></button>
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
          <th scope="col">Subject</th>
          <th scope="col">Email</th>
          <th scope="col">Phone</th>
        </tr>
        </thead>
        <tbody>
        @if($teachers->isNotEmpty())
            @foreach($teachers as $teacher)
              <tr>
                @if(auth()->user()->hasRole($roles[1]->name) || auth()->user()->hasRole($roles->first()->name))
                <td>
                    <div class="d-flex">
                    <a href="{{ route('teachers.edit', $teacher->id) }}" class="btn btn-sm btn-primary m-1"><i class="fas fa-edit"></i></a>
                    <form action="{{ route('teachers.destroy', $teacher->id) }}" method="POST" class="d-inline m-1">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete?')"><i class="fas fa-trash"></i></button>
                    </form>
                    </div>
                </td>
                @endif
            <th scope="row">{{$teacher->id}}</th>
            <td>{{$teacher->name}}</td>
            <td>{{$teacher->subject}}</td>
            <td>{{$teacher->email}}</td>
            <td>{{$teacher->phone}}</td>
              </tr>
            @endforeach
        @else
            <tr>
            <td colspan="6" class="text-center">No data found</td>
            </tr>
        @endif
        </tbody>
    </table>
</div>
{{ $teachers->links('pagination::bootstrap-5') }}
@endsection
