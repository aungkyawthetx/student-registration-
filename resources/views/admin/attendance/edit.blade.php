@extends('layouts.app')
@section('title', 'Attendance Edit')
@section('content')
  <div class="card shadow bg-light border-0">
      <div class="card-header d-flex align-items-center justify-content-between">
          <h4 class="text-uppercase"> Update attendance </h4>
          <a href="{{ route('attendances.index') }}" class="btn btn-dark"> <i class="fa-solid fa-chevron-left"></i> Back</a>
      </div>
      <div class="card-body">
          <form action="{{ route('attendances.update',$attendance->id ) }}" method="POST">
              @csrf
              @method('PUT')
              <div class="mb-3">
                <label for="student_name" class="form-label ms-2"><i class="fas fa-user"></i> Student_Name</label>
                <select class="form-select @error('student_name') is-invalid @enderror" name="student_name">
                  <option value="" selected disabled> Name</option>
                    <option value="{{ $attendance->student_id }}" selected>
                    {{ $attendance->student->name }}
                    </option>
                </select>
                @error('student_name')
                  <span class="text-danger"><small>{{ $message }}</small></span>
                @enderror
              </div>

              <div class="mb-3">
                <label for="course_name" class="form-label ms-2"><i class="fa-solid fa-book"></i> Course</label>
                <select class="form-select @error('course_name') is-invalid @enderror" name="course_name">
                  <option value="" selected disabled> Course</option>
                  <option value="{{ $attendance->course_id }}" selected>
                    {{ $attendance->course->name }}
                  </option>
                </select>
                @error('course_name')
                  <span class="text-danger"><small>{{ $message }}</small></span>
                @enderror
              </div>

              <div class="mb-3">
                <label for="attendance_date" class="form-label ms-2"><i class="fa-solid fa-calendar-week"></i> Attendance Date</label>
                <input type="date" class="form-control @error('attendance_date') is-invalid @enderror" name="attendance_date" value="{{ old('attendance_date', $attendance->attendance_date) }}">
                @error('attendance_date')
                  <span class="text-danger"><small>{{ $message }}</small></span>
                @enderror
              </div>

              <div class="mb-3">
                <label for="room_name" class="form-label ms-2"><i class="fa-solid fa-door-closed"></i> Room</label>
                <select class="form-select @error('room_name') is-invalid @enderror" name="room_name">
                  <option value="" selected disabled> Room</option>
                  <option value="{{ $attendance->room_id }}" selected>
                    {{ $attendance->room->name }}
                  </option>
                </select>
                @error('room_name')
                  <span class="text-danger"><small>{{ $message }}</small></span>
                @enderror
              </div>
              <div class="mb-3">
                <label for="status" class="form-label ms-2"><i class="fa-solid fa-door-closed"></i> Attendance Status</label>
                <select class="form-select @error('status') is-invalid @enderror" name="status">
                    <option value="" selected disabled> Status</option>
                    <option value="P" {{ old('status', $attendance->attendance_status) == 'P' ? 'selected' : '' }}> P </option>
                    <option value="A" {{ old('status', $attendance->attendance_status) == 'A' ? 'selected' : '' }}> A </option>
                    <option value="L" {{ old('status', $attendance->attendance_status) == 'L' ? 'selected' : '' }}> L </option>
                  </select>
                @error('status')
                  <span class="text-danger"><small>{{ $message }}</small></span>
                @enderror
              </div>
              <button type="submit" class="btn btn-primary float-end"> Submit </button>
          </form>
      </div>
  </div>
@endsection