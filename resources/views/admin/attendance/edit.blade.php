@extends('layouts.app')
@section('title', 'Attendance Edit')
@section('content')
  <div class="card shadow-sm">
      <div class="card-header bg-transparent border-bottom d-flex align-items-center justify-content-between">
          <h4 class="card-title mb-0"> Edit Attendance </h4>
          <a href="{{ route('attendances.index') }}" class="btn btn-dark"> <i class="fa-solid fa-chevron-left"></i> Back</a>
      </div>
      <div class="card-body">
        <form action="{{ route('attendances.update',$attendance->id ) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="mb-3">
              <label for="class_name" class="form-label ms-2"><i class="fa-solid fa-book"></i> Class</label>
              <select class="form-select @error('class_name') is-invalid @enderror" name="class_name">
                <option value="" selected disabled> Class</option>
                <option value="{{ $attendance->class_id }}" selected>
                  {{ $attendance->class->name }}
                </option>
              </select>
              @error('class_name')
                <span class="text-danger"><small>{{ $message }}</small></span>
              @enderror
            </div>
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
              <label for="attendance_date" class="form-label ms-2"><i class="fa-solid fa-calendar-week"></i> Attendance Date</label>
              <input type="date" class="form-control @error('attendance_date') is-invalid @enderror" name="attendance_date" value="{{ old('attendance_date', $attendance->attendance_date) }}">
              @error('attendance_date')
                <span class="text-danger"><small>{{ $message }}</small></span>
              @enderror
            </div>
            <div class="mb-2">
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
            <button type="submit" class="btn btn-primary float-end"> Update <i class="fa-solid fa-arrow-up-from-bracket"></i> </button>
        </form>
      </div>
  </div>
@endsection