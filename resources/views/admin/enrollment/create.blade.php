@extends('layouts.app')
@section('title', 'New Enrollment')
@section('content')
  <div class="card bg-light border-0 shadow">
    <div class="card-header">
      <h4 class="text-uppercase card-title">New enrollment</h4>
    </div>
    <div class="card-body">
      <form action="{{ route('enrollments.store') }}" method="POST">
          @csrf
          <div class="mb-3">
              <label class="form-label"> <i class="fa-solid fa-users"></i> Students</label>
              <select name="student_id" class="form-control @error('student_id') is-invalid @enderror">
                  <option value="">Select Student </option>
                  @foreach($students as $student)
                      <option value="{{ $student->id }}">{{ $student->name }}</option>
                  @endforeach
              </select>
              @error('student_id')
              <small class="text-danger ms-2 my-0 py-0"> student field is required </small>
              @enderror
          </div>
          <div class="mb-3">
              <label class="form-label">Courses</label>
              <select name="course_id" class="form-control @error('course_id') is-invalid @enderror">
                  <option value=""> Select Course </option>
                  @foreach($courses as $course)
                      <option value="{{ $course->id }}">{{ $course->name }}</option>
                  @endforeach
              </select>
              @error('course_id')
              <small class="text-danger ms-2 my-0 py-0"> courses field is required </small>
              @enderror
          </div>
          <div class="mb-3">
              <label class="form-label">Enrollment Date</label>
              <input type="date" name="enrollment_date" class="form-control @error('enrollment_date') is-invalid @enderror">
              @error('enrollment_date')
              <small class="text-danger ms-2 my-0 py-0"> date field is required </small>
              @enderror
          </div>
          <button type="submit" class="btn btn-primary rounded-1 float-end">Submit</button>
      </form>
    </div>
  </div>
@endsection