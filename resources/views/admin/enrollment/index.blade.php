@extends('layouts.app')
@section('title', 'Enrollments')
@section('content')
  <div class="card shadow-sm">
    <div class="card-header bg-white border-bottom">
      <div class="container d-flex justify-content-between align-items-center mt-1">
        <h2 class="d-inline mb-0">Enrollment List</h2>
        <a href="{{ route('enrollments.create') }}" class="btn btn-primary rounded-1"> Add New <i class="fa-solid fa-plus"></i> </a>
      </div>
      @if(session('successAlert'))
        <div class="alert alert-success alert-dismissible fade show mt-3" role="alert">
          {{ session('successAlert') }}
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
      @endif
    </div>
    <div class="card-body">
      <div class="table-responsive container">
        <table class="table table-striped table-hover align-middle text-center">
            <thead>
            <tr>
              <th scope="col">ID</th>
              <th scope="col">Student Name</th>
              <th scope="col">Course Name</th>
              <th scope="col">Enrollment Date</th>
              <th scope="col">Actions</th>
            </tr>
            </thead class="table-light">
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
    </div>
    <div class="card-footer border-0 bg-transparent pt-0">
      <div class="container">
        {{$enrollments->links('pagination::bootstrap-5') }}
      </div>
    </div>
  </div>
@endsection