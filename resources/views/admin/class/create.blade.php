@extends('layouts.app')
@section('title', 'New Class')
@section('content')
  
  <div class="card shadow-sm">
      <div class="card-header bg-transparent border-bottom d-flex align-items-center justify-content-between">
          <h4 class="card-title mb-0 d-inline"> New Class </h4>
          <a href="{{ route('classes.index') }}" class="btn btn-dark float-end text-uppercase"> <i class="fa-solid fa-chevron-left"></i> Back</a>
      </div>
      <div class="card-body">
        <form action="{{ route('classes.store') }}" method="POST">
            @csrf
            {{-- <div class="mb-3">
              <label for="class_name" class="form-label ms-2"> >> Class Name</label>
              <input type="text" name="class_name" class="form-control @error('class_name') is-invalid @enderror" placeholder="Enter Class Name">
              @error('class_name')
                <span class="text-danger"><small>{{ $message }}</small></span>
              @enderror
            </div> --}}

            <div class="mb-3">
              <label for="courseId" class="form-label ms-2"><i class="fa-solid fa-book"></i> Course</label>
              <select class="form-select @error('course_id') is-invalid @enderror" name="course_id">
                <option value="" disabled selected>Choose Course</option>
                @foreach($courses as $course)
                  <option value="{{ $course->id }}">
                    {{ $course->name }}
                  </option>
                @endforeach
              </select>
              @error('course_id')
                <span class="text-danger"><small>{{ $message }}</small></span>
              @enderror
            </div>
            <div class="mb-3">
              <label for="roomId" class="form-label ms-2"> <i class="fa-solid fa-door-closed"></i> Room</label>
              <select class="form-select @error('room_id') is-invalid @enderror" name="room_id">
                <option value="" disabled selected>Choose Room</option>
                @foreach($rooms as $room)
                  <option value="{{ $room->id }}">
                    {{ $room->name }}
                  </option>
                @endforeach
              </select>
              @error('room_id')
                <span class="text-danger"><small>{{ $message }}</small></span>
              @enderror
            </div>
            <div class="mb-3">
              <label for="start_date" class="form-label ms-2"> <i class="fa-solid fa-calendar"></i> Start Date</label>
              <input type="date" class="form-control @error('start_date') is-invalid @enderror" name="start_date" placeholder="Enter Start Date" value="{{ old('start_date') }}">
              @error('start_date')
                  <span class="text-danger"><small>{{ $message }}</small></span>
              @enderror
            </div>
            <div class="mb-2">
              <label for="end_date" class="form-label ms-2"> <i class="fa-solid fa-calendar"></i> End Date</label>
              <input type="date" class="form-control @error('end_date') is-invalid @enderror" name="end_date" placeholder="Enter End Date" value="{{ old('end_date') }}">
              @error('end_date')
                  <span class="text-danger"><small>{{ $message }}</small></span>
              @enderror
            </div>
            <div class="mb-3">
              <label for="time" class="form-label ms-2"> <i class="fa-solid fa-clock"></i> Time</label>
              <input type="text" class="form-control @error('time') is-invalid @enderror" name="time" placeholder="Enter Time" value="{{ old('time') }}">
              @error('time')
                  <span class="text-danger"><small>{{ $message }}</small></span>
              @enderror
            </div>
            <button type="submit" class="btn btn-primary float-end text-uppercase"> Add Class </button>
        </form>
      </div>
  </div>
@endsection