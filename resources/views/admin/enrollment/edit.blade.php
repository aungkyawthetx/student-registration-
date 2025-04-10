@extends('layouts.app')
@section('title', 'Edit Enrollment')
@section('content')
  <div class="card shadow-sm">
    <div class="card-header bg-transparent border-bottom d-flex align-items-center justify-content-between">
      <h4 class="card-title d-inline mb-0"> Edit Enrollment</h4>
      <a href="{{ route('enrollments.index') }}" class="btn btn-dark"> <i class="fa-solid fa-chevron-left"></i> Back</a>
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
          <label class="form-label ms-2"> <i class="fa-solid fa-book-open"></i> Class Name</label>
          <select name="class_name" class="form-select @error('class_id') is-invalid @enderror">
            @foreach($classes as $class)
              <option value="{{ $class->id }}" {{ old('class_name', $enrollment->class->id) == $class->id ? 'selected' : '' }}>
                {{ $class->name }}
              </option>
            @endforeach
          </select>
          @error('class_name')
          <small class="text-danger ms-2 my-0 py-0"> class field is required </small>
          @enderror
        </div>
        <div class="mb-2">
          <label class="form-label ms-2">Enrollment Date</label>
          <input type="date" name="enrollment_date" class="form-control @error('enrollment_date') is-invalid @enderror" value="{{ $enrollment->date }}">
          @error('enrollment_date')
          <small class="text-danger ms-2 my-0 py-0"> date field is required </small>
          @enderror
        </div>
        <button type="submit" class="btn btn-primary rounded-1 float-end"> Update <i class="fa-solid fa-arrow-up-from-bracket"></i> </button>
      </form>
    </div>
  </div>
@endsection