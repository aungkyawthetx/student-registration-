@extends('layouts.app')
@section('title', 'Attendances')
@section('content')
  <div class="container d-flex align-items-center justify-content-between">
    <h2 class="d-inline text-uppercase"> attendances list</h2>
    <a href="{{ route('attendances.create') }}" class="btn btn-primary my-2 rounded-1"> Add New <i class="fa-solid fa-plus"></i> </a>
  </div>
  @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show mt-3" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
  @endif
  <div class="table-responsive container my-3">
    <table class="table table-hover table-bordered table-striped text-center">
      <thead>
        <tr>
          <th scope="col">ID</th>
          <th scope="col">Student Name</th>
          <th scope="col">Date</th>
          <th scope="col">Course Name</th>
          <th scope="col">Room</th>
          <th scope="col">Status</th>
          <th scope="col">Actions</th>
        </tr>
      </thead>
      <tbody>
        @foreach ($attendances as $attendance)
        <tr>
          <td> {{ $attendance->id }} </td>
          <td> {{ $attendance->student->name ?? 'no student' }} </td>
          <td> {{ $attendance->attendance_date }} </td>
          <td> {{ $attendance->course->name ?? 'no course' }} </td>
          <td> {{ $attendance->room->name ?? 'no room' }} </td>
          <td> {{ $attendance->attendance_status }} </td>
          <td>
            <div>
              <a href="{{ route('attendances.edit',$attendance->id) }}" class="btn btn-sm btn-success me-2"> Edit <i class="fa-solid fa-pen-to-square"></i> </a>
              <form action="{{ route('attendances.destroy', $attendance->id) }}" method="POST" class="d-inline">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this row?')"> Delete <i class="fa-solid fa-trash"></i> </button>
              </form>
          </div>
          </td>
        </tr>
        @endforeach
      </tbody>
    </table>
    {{ $attendances->links('pagination::bootstrap-5') }}
  </div>
@endsection