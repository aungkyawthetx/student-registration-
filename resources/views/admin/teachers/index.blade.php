@extends('layouts.app')
@section('title', 'Teachers List')
@section('content')
<div class="container">
    <h2 class="d-inline">Teachers List</h2>
    <a href="{{ route('teachers.create') }}" class="btn btn-primary my-2 float-end"><i class="fas fa-plus"></i> Add new</a>
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show mt-3" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
</div>
<div class="table-responsive container my-3">
    <table class="table table-hover table-bordered table-striped">
        <thead>
        <tr>
          <th scope="col"></th>
          <th scope="col">ID</th>
          <th scope="col">Name</th>
          <th scope="col">Subject</th>
          <th scope="col">Email</th>
          <th scope="col">Phone</th>
        </tr>
        </thead>
        <tbody>
        @foreach($teachers as $teacher)
          <tr>
            <td>
                <div class="d-flex">
                    <a href="{{ route('teachers.edit', $teacher->id) }}" class="btn btn-sm btn-primary m-1"><i class="fas fa-edit"></i></a>
                    <form action="{{ route('teachers.destroy', $teacher->id) }}" method="POST" class="d-inline m-1">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></button>
                    </form>
                </div>
            </td>
            <th scope="row">{{$teacher->id}}</th>
            <td>{{$teacher->name}}</td>
            <td>{{$teacher->subject}}</td>
            <td>{{$teacher->email}}</td>
            <td>{{$teacher->phone}}</td>
          </tr>
        @endforeach
        </tbody>
    </table>
</div>
{{ $teachers->links('pagination::bootstrap-5') }}
@endsection
