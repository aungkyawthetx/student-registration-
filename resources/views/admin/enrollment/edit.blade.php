@extends('layouts.app')
@section('title', 'Edit Enrollment')
@section('content')
  <div class="card border-0 shadow">
    <div class="card-header">
      <h4 class="text-uppercase card-title"> Edit Enrollment</h4>
    </div>
    <div class="card-body">
      <form action="{{ route('enrollments.update', $enrollment->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="mb-3">
          <label class="form-label ms-2"> <i class="fa-solid fa-user"></i> Student_Name</label>
          <select name="student_name" class="form-select @error('student_id') is-invalid @enderror">
            @foreach($students as $student)
              <option value="{{ $student->id }}" {{ old('student_name', $enrollment->student->id) == $student->id ? 'selected' : '' }}>
                {{ $student->name }}
              </option>
            @endforeach
          </select>
          @error('student_name')
          <small class="text-danger ms-2 my-0 py-0"> student field is required </small>
          @enderror
        </div>
        <div class="mb-3">
          <label class="form-label ms-2"> <i class="fa-solid fa-book-open"></i> Course_Name</label>
          <select name="course_name" class="form-select @error('course_id') is-invalid @enderror">
            @foreach($courses as $course)
              <option value="{{ $course->id }}" {{ old('course_name', $enrollment->course->id) == $course->id ? 'selected' : '' }}>
                {{ $course->name }}
              </option>
            @endforeach
          </select>
          @error('course_name')
          <small class="text-danger ms-2 my-0 py-0"> course field is required </small>
          @enderror
        </div>
        <div class="mb-3">
          <label class="form-label ms-2">Enrollment Date</label>
          <input type="date" name="enrollment_date" class="form-control @error('enrollment_date') is-invalid @enderror" value="{{ $enrollment->date }}">
          @error('enrollment_date')
          <small class="text-danger ms-2 my-0 py-0"> date field is required </small>
          @enderror
        </div>
        <button type="submit" class="btn btn-primary rounded-1 float-end">Update</button>
      </form>
    </div>
  </div>
@endsection