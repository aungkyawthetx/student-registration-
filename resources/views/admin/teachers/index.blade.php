@extends('layouts.app')
@section('title', 'Teachers List')
@section('content')
<div class="container d-flex justify-content-between align-items-center">
    <h2 class="d-inline">Teachers List</h2>
    @if(auth()->user()->hasRole('Admin') || auth()->user()->hasRole('Super admin'))
    <a href="{{ route('teachers.create') }}" class="btn btn-primary my-2"><i class="fas fa-plus"></i> Add new</a>
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
    </div>
</div>
<div class="table-responsive container my-3">
    <table class="table table-hover table-bordered table-striped">
        <thead>
        <tr>
            @if(auth()->user()->hasRole('Admin') || auth()->user()->hasRole('Super admin'))
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
                @if(auth()->user()->hasRole('Admin') || auth()->user()->hasRole('Super admin'))
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
