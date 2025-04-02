@extends('layouts.app')
@section('title', 'Courses List')
@section('content')
<div class="container">
    <h2 class="d-inline">Courses List</h2>
    <a href="{{ route('courses.create') }}" class="btn btn-primary my-2 float-end"><i class="fas fa-plus"></i> Add new</a>
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
          <th scope="col">Duration</th>
          <th scope="col">Start Date</th>
          <th scope="col">End Date</th>
          <th scope="col">Fees</th>
        </tr>
        </thead>
        <tbody>
        @foreach($courses as $course)
          <tr>
            <td>
                <div class="d-flex">
                    <a href="{{ route('courses.edit', $course->id) }}" class="btn btn-sm btn-primary m-1"><i class="fas fa-edit"></i></a>
                    <form action="{{ route('courses.destroy', $course->id) }}" method="POST" class="d-inline m-1">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></button>
                    </form>
                </div>
            </td>
            <th scope="row">{{$course->id}}</th>
            <td>{{$course->name}}</td>
            <td>{{$course->duration}}</td>
            <td>{{$course->start_date}}</td>
            <td>{{$course->end_date}}</td>
            <td>{{$course->fees}}</td>
          </tr>
        @endforeach
        </tbody>
    </table>
</div>
{{ $courses->links('pagination::bootstrap-5') }}
@endsection
