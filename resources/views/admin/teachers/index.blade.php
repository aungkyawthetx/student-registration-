@extends('layouts.app')
@section('title', 'Teachers List')
@section('content')
<div class="container d-flex align-items-center justify-content-between">
    <h2 class="d-inline text-uppercase">Teachers List</h2>
    <a href="{{ route('teachers.create') }}" class="btn btn-primary my-2"> Add New <i class="fas fa-plus"></i> </a>
</div>
@if(session('success'))
        <div class="alert alert-success alert-dismissible fade show mt-3" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
<div class="table-responsive container my-3">
    <table class="table table-hover table-bordered table-striped">
        <thead>
            <tr>
                <th scope="col">ID</th>
                <th scope="col">Name</th>
                <th scope="col">Course</th>
                <th scope="col">Email</th>
                <th scope="col">Phone</th>
                <th scope="col">Actions</th>
            </tr>
        </thead>
        <tbody>
        @foreach($teachers as $teacher)
            <tr>
                <td scope="row">{{$teacher->id}}</td>
                <td>{{$teacher->name}}</td>
                <td>{{$teacher->subject}}</td>
                <td>{{$teacher->email}}</td>
                <td>{{$teacher->phone}}</td>
                <td>
                    <div>
                        <a href="{{ route('teachers.edit', $teacher->id) }}" class="btn btn-sm btn-success me-2"> Edit <i class="fas fa-edit"></i></a>
                        <form action="{{ route('teachers.destroy', $teacher->id) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this row?')"> Delete <i class="fas fa-trash"></i></button>
                        </form>
                    </div>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
{{ $teachers->links('pagination::bootstrap-5') }}
@endsection
