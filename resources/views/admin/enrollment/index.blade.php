@extends('layouts.app')
@section('title', 'Enrollments')
@section('content')
    <div class="container d-flex align-items-center justify-content-between">
        <h2 class="text-uppercase">Enrollment list</h2>
        <a href="{{ route('enrollments.create') }}" class="btn btn-primary rounded-1"> New Enroll <i class="fa-solid fa-plus"></i> </a>
    </div>
    @if(session('successAlert'))
            <div class="alert alert-success alert-dismissible fade show mt-3" role="alert">
                {{ session('successAlert') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
    <div class="table-responsive container my-3">
        <table class="table table-hover table-bordered table-striped text-center">
            <thead>
            <tr>
              <th scope="col">ID</th>
              <th scope="col">Student_Name</th>
              <th scope="col">Course_Name</th>
              <th scope="col">Enrollment_Date</th>
              <th scope="col">Actions</th>
            </tr>
            </thead>
            <tbody>
              @foreach ($enrollments as $enrollment)
              <tr>
                <td> {{ $enrollment->id }} </td>
                <td> {{ $enrollment->student->name }} </td>
                <td> {{ $enrollment->course->name }} </td>
                <td> {{ $enrollment->date }} </td>
                <td>
                  <div>
                    <a href="{{ route('enrollments.edit', $enrollment->id) }}" class="btn btn-sm btn-success me-2"> Edit <i class="fa-solid fa-pen-to-square"></i> </a>
                    <form action="{{ route('enrollments.destroy', $enrollment->id) }}" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this row?')"> Delete <i class="fas fa-trash"></i> </button>
                    </form>
                  </div>
                </td>
              </tr>
              @endforeach
            </tbody>
        </table>
    </div>
    {{$enrollments->links('pagination::bootstrap-5') }}
@endsection