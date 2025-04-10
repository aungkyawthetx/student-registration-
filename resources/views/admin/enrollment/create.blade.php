@extends('layouts.app')
@section('title', 'New Enrollment')
@section('content')
  <div class="card shadow-sm">
    <div class="card-header bg-transparent border-bottom">
      <div class="d-flex align-items-center justify-content-between">
        <h4 class="card-title d-inline mb-0">New Enrollment</h4>
        <a href="{{ route('enrollments.index') }}" class="btn btn-dark"> <i class="fa-solid fa-chevron-left"></i> Back</a>
      </div>
    </div>
    <div class="card-body">
      <form action="{{ route('enrollments.store') }}" method="POST">
          @csrf
          <div class="mb-3">
              <label class="form-label"> <i class="fa-solid fa-users"></i> Students</label>
              <select name="student_id" class="form-select @error('student_id') is-invalid @enderror">
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
              <label class="form-label">Classes</label>
              <select name="class_id" class="form-select @error('class_id') is-invalid @enderror">
                  <option value=""> Select Class </option>
                  @foreach($classes as $class)
                      <option value="{{ $class->id }}">{{ $class->course->name }}</option>
                  @endforeach
              </select>
              @error('class_id')
              <small class="text-danger ms-2 my-0 py-0"> classes field is required </small>
              @enderror
          </div>
          <div class="mb-2">
              <label class="form-label">Enrollment Date</label>
              <input type="date" name="enrollment_date" class="form-control @error('enrollment_date') is-invalid @enderror" value="{{ old('enrollment_date', date('Y-m-d')) }}">
              @error('enrollment_date')
              <small class="text-danger ms-2 my-0 py-0"> date field is required </small>
              @enderror
          </div>
          <button type="submit" class="btn btn-primary rounded-1 float-end">Submit</button>
      </form>
    </div>
  </div>
@endsection