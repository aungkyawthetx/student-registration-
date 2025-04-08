@extends('layouts.app')
@section('title', 'New Attendance')
@section('content')
  
  <div class="card shadow-sm">
    <div class="card-header bg-white border-bottom d-flex align-items-center justify-content-between">
        <h4 class="card-title mb-0"> New Attendance </h4>
        <a href="{{ route('attendances.index') }}" class="btn btn-dark"> <i class="fa-solid fa-chevron-left"></i> Back</a>
    </div>
    <div class="card-body">
      <form action="{{ route('attendances.store') }}" method="POST">
        @csrf
        <div class="mb-3">
          <label for="student_name" class="form-label ms-2"><i class="fas fa-user"></i> Student_Name</label>
          <select class="form-select @error('student_name') is-invalid @enderror" name="student_name">
            <option value="" selected disabled> Name</option>
            @foreach($students as $student)
              <option value="{{ $student->id }}" {{ old('student_name') == $student->id ? 'selected' : '' }}>
                {{ $student->name }}
              </option>
            @endforeach
          </select>
          @error('student_name')
            <span class="text-danger"><small>{{ $message }}</small></span>
          @enderror
        </div>

        <div class="mb-3">
          <label for="course_name" class="form-label ms-2"><i class="fa-solid fa-book"></i> Course</label>
          <select class="form-select @error('course_name') is-invalid @enderror" name="course_name">
            <option value="" selected disabled> Course</option>
            @foreach($courses as $course)
              <option value="{{ $course->id }}" {{ old('course_name') == $course->id ? 'selected' : '' }}>
                {{ $course->name }}
              </option>
            @endforeach
          </select>
          @error('course_name')
            <span class="text-danger"><small>{{ $message }}</small></span>
          @enderror
        </div>

        <div class="mb-3">
          <label for="attendance_date" class="form-label ms-2"><i class="fa-solid fa-calendar-week"></i> Attendance Date</label>
          <input type="date" class="form-control @error('attendance_date') is-invalid @enderror" name="attendance_date" value="{{ old('attendance_date') }}">
          @error('attendance_date')
            <span class="text-danger"><small>{{ $message }}</small></span>
          @enderror
        </div>

        <div class="mb-3">
          <label for="room_name" class="form-label ms-2"><i class="fa-solid fa-door-closed"></i> Room</label>
          <select class="form-select @error('room_name') is-invalid @enderror" name="room_name">
            <option value="" selected disabled> Room</option>
            @foreach($rooms as $room)
              <option value="{{ $room->id }}" {{ old('room_name') == $room->id ? 'selected' : '' }}>
                {{ $room->name }}
              </option>
            @endforeach
          </select>
          @error('room_name')
            <span class="text-danger"><small>{{ $message }}</small></span>
          @enderror
        </div>
        <div>
          <label for="status" class="form-label ms-2"><i class="fa-solid fa-door-closed"></i> Attendance Status</label>
          <select class="form-select @error('status') is-invalid @enderror" name="status">
            <option value="" selected disabled> Status</option>
              <option {{ old('status') }} value="P"> P (present) </option>
              <option {{ old('status') }} value="A"> A (absent) </option>
              <option {{ old('status') }} value="L"> L (late) </option>
          </select>
          @error('status')
            <span class="text-danger"><small>{{ $message }}</small></span>
          @enderror
        </div>
      </form>
    </div>
    <div class="card-footer border-0 bg-transparent pt-0">
      <button type="submit" class="btn btn-primary float-end"> Submit </button>
    </div>
  </div>
@endsection