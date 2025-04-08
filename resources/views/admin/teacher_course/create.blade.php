@extends('layouts.app')
@section('title', 'New Teacher and Course')
@section('content')
  <div class="card shadow-sm">
    <div class="card-header bg-white border-bottom">
       <div class="d-flex align-items-center justify-content-between">
        <h4 class="card-title"> New Teacher and Course</h4>
        <a href="{{ route('teachercourses.index') }}" class="btn btn-dark"> <i class="fa-solid fa-chevron-left"></i> BACK </a>
       </div>
    </div>
    <div class="card-body">
      <form action="{{ route('teachercourses.store') }}" method="POST">
        @csrf
        <div class="mb-3">
          <label for="teacher_name" class="form-label ms-2 @error('teacher_name') is-invalid @enderror"><i class="fas fa-user"></i> Teachers </label>
          <select class="form-select" id="teacher_id" name="teacher_name">
            <option value="" disabled selected> Select Teacher</option>
            @foreach($teachers as $teacher)
              <option value="{{ $teacher->id }}">
                {{ $teacher->name }}
              </option>
            @endforeach
          </select>
          @error('teacher_name')
            <span class="text-danger"> {{ $message }} </span>
          @enderror
        </div>

        <div>
          <label for="course_name" class="form-label ms-2 @error('course_name') is-invalid @enderror"><i class="fas fa-book"></i> Courses </label>
          <select class="form-select" id="course_id" name="course_name">
            <option value="" disabled selected>Select Course</option>
            @foreach($courses as $course)
              <option value="{{ $course->id }}">
                {{ $course->name }}
              </option>
            @endforeach
          </select>
          @error('course_name')
            <span class="text-danger"> {{ $message }} </span>
          @enderror
        </div>
      </form>
    </div>
    <div class="card-footer bg-transparent border-0 pt-0">
      <button type="submit" class="btn btn-primary float-end"><i class="fas fa-plus"></i> Add </button>
    </div>
  </div>
@endsection
