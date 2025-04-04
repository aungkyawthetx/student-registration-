@extends('layouts.app')
@section('title', 'Edit Teacher and Course')
@section('content')
  <div class="card border-0 shadow bg-light">
    <div class="card-header d-flex align-items-center justify-content-between">
        <h4 class="text-uppercase"> Edit Teacher and Course</h4>
        <a href="{{ route('teachercourses.index') }}" class="btn btn-dark"> <i class="fa-solid fa-chevron-left"></i> BACK </a>
    </div>
    <div class="card-body">
      <form action="{{ route('teachercourses.update', $teacher_course->id) }}" method="POST">
          @csrf
          @method('PUT')
          <div class="mb-3">
            <label for="teacher_name" class="form-label ms-2 @error('teacher_name') is-invalid @enderror"><i class="fas fa-user"></i> Teacher </label>
            <select class="form-select" id="teacher_id" name="teacher_name">
              <option value="" disabled> Select Teacher</option>
              @foreach($teachers as $teacher)
                <option value="{{ $teacher->id }}" {{ $teacher->id == $teacher_course->teacher_id ? 'selected' : '' }}>
                  {{ $teacher->name }}
                </option>
              @endforeach
            </select>
            @error('teacher_name')
              <span class="text-danger"> {{ $message }} </span>
            @enderror
          </div>

          <div class="mb-3">
            <label for="course_name" class="form-label ms-2 @error('course_name') is-invalid @enderror"><i class="fas fa-book"></i> Course </label>
            <select class="form-select" id="course_id" name="course_name">
              <option value="" disabled>Select Course</option>
              @foreach($courses as $course)
                <option value="{{ $course->id }}" {{ $course->id == $teacher_course->course_id ? 'selected' : '' }}>
                  {{ $course->name }}
                </option>
              @endforeach
            </select>
            @error('course_name')
              <span class="text-danger"> {{ $message }} </span>
            @enderror
          </div>
          <button type="submit" class="btn btn-primary float-end"> Update <i class="fa-solid fa-arrow-up-from-bracket"></i> </button>
      </form>
    </div>
  </div>
@endsection
