@extends('layouts.app')
@section('title', 'Students List')
@section('content')
<div class="container">
    <h2 class="d-inline">Student List</h2>
    <a href="{{ route('students.create') }}" class="btn btn-primary my-2 float-end"><i class="fas fa-plus"></i> Add new</a>
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
          <th scope="col">Gender</th>
          <th scope="col">NRC</th>
          <th scope="col">DOB</th>
          <th scope="col">Email</th>
          <th scope="col">Phone</th>
          <th scope="col">Address</th>
          <th scope="col">Parent Info</th>
        </tr>
        </thead>
        <tbody>
        @foreach($students as $student)
          <tr>
            <td>
                <div class="d-flex">
                    <a href="{{ route('students.edit', $student->id) }}" class="btn btn-sm btn-primary m-1"><i class="fas fa-edit"></i></a>
                    <form action="{{ route('students.destroy', $student->id) }}" method="POST" class="d-inline m-1">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></button>
                    </form>
                </div>
            </td>
            <th scope="row">{{$student->id}}</th>
            <td>{{$student->name}}</td>
            <td>{{$student->gender}}</td>
            <td>{{$student->nrc}}</td>
            <td>{{$student->dob}}</td>
            <td>{{$student->email}}</td>
            <td>{{$student->phone}}</td>
            <td>{{$student->address}}</td>
            <td>{{$student->parent_info}}</td>
          </tr>
        @endforeach
        </tbody>
    </table>
</div>
{{ $students->links('pagination::bootstrap-5') }}
@endsection