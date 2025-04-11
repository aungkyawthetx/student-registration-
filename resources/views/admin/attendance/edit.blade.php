@extends('layouts.app')
@section('title', 'Attendance Edit')
@section('content')
  <div class="card shadow-sm">
      <div class="card-header bg-transparent border-bottom d-flex align-items-center justify-content-between">
          <h4 class="card-title mb-0"> Edit Attendance </h4>
          <a href="{{ route('attendances.index') }}" class="btn btn-dark"> <i class="fa-solid fa-chevron-left"></i> Back</a>
      </div>
      <div class="card-body">
        <form action="{{ route('attendances.update', $attendance->id) }}" method="POST">
            @csrf
            @method('PUT')

            {{-- Class --}}
            <div class="mb-3">
              <label for="class_id">Class</label>
              <select name="class_id" id="class_id" class="form-control" required>
                  <option value=""> Choose Class</option>
                  @foreach ($classes as $class)
                      <option value="{{ $class->id }}" {{ $attendance->class_id == $class->id ? 'selected' : '' }}>
                        {{ $class->course->name }} - {{ \Carbon\Carbon::parse($class->class_date)->format('Y-m-d') }}
                      </option>
                  @endforeach
              </select>
          </div>
          

            {{-- Student --}}
            <div class="mb-3">
              <label for="student_id" class="form-label ms-2"><i class="fas fa-user"></i> Student Name</label>
              <select class="form-select @error('student_id') is-invalid @enderror" name="student_id">
                <option value="" disabled {{ old('student_id', $attendance->student_id) ? '' : 'selected' }}>Select Student</option>
                <option value="{{ $attendance->student_id }}" selected>
                  {{ $attendance->student->name }}
                </option>
              </select>
              @error('student_id')
                <span class="text-danger"><small>{{ $message }}</small></span>
              @enderror
            </div>

            {{-- Attendance Date --}}
            <div class="mb-3">
              <label for="date" class="form-label ms-2"><i class="fa-solid fa-calendar-week"></i> Attendance Date</label>
              <input type="date" class="form-control @error('date') is-invalid @enderror" name="date" value="{{ old('date', $attendance->attendance_date) }}">
              @error('date')
                <span class="text-danger"><small>{{ $message }}</small></span>
              @enderror
            </div>

            {{-- Status --}}
            <div class="mb-2">
              <label for="status" class="form-label ms-2"><i class="fa-solid fa-door-closed"></i> Attendance Status</label>
              <select class="form-select @error('status') is-invalid @enderror" name="status">
                <option value="" disabled {{ old('status', $attendance->attendance_status) ? '' : 'selected' }}>Select Status</option>
                <option value="P" {{ old('status', $attendance->attendance_status) == 'P' ? 'selected' : '' }}>P</option>
                <option value="A" {{ old('status', $attendance->attendance_status) == 'A' ? 'selected' : '' }}>A</option>
                <option value="L" {{ old('status', $attendance->attendance_status) == 'L' ? 'selected' : '' }}>L</option>
              </select>
              @error('status')
                <span class="text-danger"><small>{{ $message }}</small></span>
              @enderror
            </div>

            <button type="submit" class="btn btn-primary float-end">
              Update <i class="fa-solid fa-arrow-up-from-bracket"></i>
            </button>
        </form>
      </div>
  </div>
@endsection