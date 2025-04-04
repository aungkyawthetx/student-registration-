@extends('layouts.app')
@section('title', 'Teacher Courses')
@section('content')
  <div class="container d-flex align-items-center justify-content-between">
    <h2 class="d-inline text-uppercase"> Teachers and Courses</h2>
    <a href="{{ route('teachercourses.create') }}" class="btn btn-primary my-2"> Add New </a>
  </div>
  @if(Session('success'))
    <div class="alert alert-success alert-dismissible fade show mt-3" role="alert">
        {{ Session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
  @endif
  <div class="table-responsive container my-3">
    <table class="table table-hover table-bordered table-striped text-center">
      <thead>
        <tr>
          <th scope="col">ID</th>
          <th scope="col">Teacher_Name</th>
          <th scope="col">Course</th>
          <th scope="col">Actions</th>
        </tr>
      </thead>
      <tbody>
        @foreach ($teacher_courses as $teacher_course)
        <tr>
          <td> {{ $teacher_course->id ?? 'null' }} </td>
          <td> {{ $teacher_course->teacher->name ?? 'no teacher' }} </td>
          <td> {{ $teacher_course->course->name ?? 'no couse' }} </td>
          <td>
            <div>
              <a href="{{ route('teachercourses.edit', $teacher_course->id) }}" class="btn btn-sm btn-success me-2"> Edit <i class="fa-solid fa-pen-to-square"></i> </a>
              <form action="{{ route('teachercourses.destroy', $teacher_course->id) }}" method="POST" class="d-inline">
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
    {{ $teacher_courses->links('pagination::bootstrap-5') }}
  </div>
@endsection