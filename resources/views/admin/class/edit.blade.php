@extends('layouts.app')
@section('title', 'Edit Class')
@section('content')
  
  <div class="card shadow-sm">
    <div class="card-header border-bottom bg-transparent d-flex align-items-center justify-content-between">
        <h4 class="card-title mb-0 d-inline"> Edit Class </h4>
        <a href="{{ route('classes.index') }}" class="btn btn-dark fw-bold float-end"> <i class="fa-solid fa-chevron-left"></i> Back</a>
    </div>
    <div class="card-body">
      <form action="{{ route('classes.update', $class->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="mb-3">
          <label for="courseId" class="form-label ms-2 fw-bold"><i class="fa-solid fa-book"></i>Course</label>
          <select class="form-select @error('course_id') is-invalid @enderror" name="course_id">
            <option value="" disabled>Select a Course</option>
            @foreach($courses as $course)
              <option value="{{ $course->id }}" {{ $course->id == old('course_id', $class->course_id) ? 'selected' : '' }}>
                {{ $course->name }}
              </option>
            @endforeach
          </select>
          @error('course_id')
            <span class="text-danger"><small>{{ $message }}</small></span>
          @enderror
        </div>
        <div class="mb-3">
          <label for="courseId" class="form-label ms-2 fw-bold"><i class="fa-solid fa-book"></i>Course</label>
          <select class="form-select @error('course_id') is-invalid @enderror" name="course_id">
            <option value="" disabled>Select a Course</option>
            @foreach($courses as $course)
              <option value="{{ $course->id }}" {{ $course->id == old('course_id', $class->course_id) ? 'selected' : '' }}>
                {{ $course->name }}
              </option>
            @endforeach
          </select>
          @error('course_id')
            <span class="text-danger"><small>{{ $message }}</small></span>
          @enderror
        </div>
        <div class="mb-3">
          <label for="roomId" class="form-label ms-2 fw-bold"> <i class="fa-solid fa-door-closed"></i> Room</label>
          <select class="form-select @error('room_id') is-invalid @enderror" name="room_id">
            <option value="" disabled>Select a Room</option>
            @foreach($rooms as $room)
              <option value="{{ $room->id }}" {{ $room->id == old('room_id', $class->room_id) ? 'selected' : '' }}>
                {{ $room->name }}
              </option>
            @endforeach
          </select>
          @error('room_id')
            <span class="text-danger"><small>{{ $message }}</small></span>
          @enderror
        </div>
        <div class="mb-3">
          <label for="start_date" class="form-label fw-bold ms-2"> <i class="fa-solid fa-calendar text-primary"></i> Start Date</label>
          <input type="date" class="form-control @error('start_date') is-invalid @enderror" name="start_date" placeholder="Enter Start Date" value="{{$class->date ?? old('start_date') }}">
          @error('start_date')
              <span class="text-danger"><small>{{ $message }}</small></span>
          @enderror
        </div>
        <div class="mb-3">
          <label for="end_date" class="form-label fw-bold ms-2"> <i class="fa-solid fa-calendar text-warning"></i> End Date</label>
          <input type="date" class="form-control @error('date') is-invalid @enderror" name="end_date" placeholder="Enter End Date" value="{{$class->end_date ?? old('end_date') }}">
          @error('end_date')
              <span class="text-danger"><small>{{ $message }}</small></span>
          @enderror
        </div>
        <div class="mb-3">
          <label for="time" class="form-label ms-2 fw-bold"> <i class="fa-solid fa-clock text-success"></i> Time</label>
          <input type="text" class="form-control @error('time') is-invalid @enderror" name="time" placeholder="Enter Time" value="{{$class->time ?? old('time') }}">
          @error('time')
              <span class="text-danger"><small>{{ $message }}</small></span>
          @enderror
        </div>
        <div class="mb-3">
          <label for="time" class="form-label ms-2 fw-bold"> <i class="fa-solid fa-clock text-success"></i> Time</label>
          <input type="text" class="form-control @error('time') is-invalid @enderror" name="time" placeholder="Enter Time" value="{{$class->time ?? old('time') }}">
          @error('time')
              <span class="text-danger"><small>{{ $message }}</small></span>
          @enderror
        </div>
        <button type="submit" class="btn btn-primary float-end"> Update <i class="fa-solid fa-arrow-up-from-bracket"></i> </button>
      </form>
    </div>
  </div>
@endsection