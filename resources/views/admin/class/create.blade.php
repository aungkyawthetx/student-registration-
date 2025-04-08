@extends('layouts.app')
@section('title', 'New Class')
@section('content')
  
  <div class="card shadow border-0">
      <div class="card-header d-flex align-items-center justify-content-between">
          <h4 class="text-uppercase"> new class </h4>
          <a href="{{ route('classes.index') }}" class="btn btn-dark float-end text-uppercase"> <i class="fa-solid fa-chevron-left"></i> Back</a>
      </div>
      <div class="card-body">
          <form action="{{ route('classes.store') }}" method="POST">
              @csrf
                  <div class="mb-3">
                    <label for="roomId" class="form-label ms-2 fw-bold"> <i class="fa-solid fa-door-closed text-primary"></i> Room</label>
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
                    <label for="start_time" class="form-label ms-2 fw-bold"> <i class="fa-solid fa-clock text-success"></i> Start Time</label>
                    <input type="text" class="form-control @error('start_time') is-invalid @enderror" name="start_time" placeholder="Enter Start-Time" value="{{ old('start_time') }}">
                    @error('start_time')
                        <span class="text-danger"><small>{{ $message }}</small></span>
                    @enderror
                  </div>
                  <div class="mb-3">
                    <label for="end_time" class="form-label ms-2 fw-bold"> <i class="fa-solid fa-clock text-warning"></i> End Time</label>
                    <input type="text" class="form-control @error('end_time') is-invalid @enderror" name="end_time" placeholder="Enter End-Time" value="{{ old('end_time') }}">
                    @error('end_time')
                        <span class="text-danger"><small>{{ $message }}</small></span>
                    @enderror
                  </div>
                  <div class="mb-3">
                    <label for="date" class="form-label fw-bold ms-2"> <i class="fa-solid fa-calendar text-success"></i> Date</label>
                    <input type="date" class="form-control @error('date') is-invalid @enderror" name="date" placeholder="Enter Date" value="{{ old('date') }}">
                    @error('date')
                        <span class="text-danger"><small>{{ $message }}</small></span>
                    @enderror
                  </div>
                  <div class="mb-3">
                    <label for="end_date" class="form-label fw-bold ms-2"> <i class="fa-solid fa-calendar text-warning"></i> End Date</label>
                    <input type="date" class="form-control @error('end_date') is-invalid @enderror" name="end_date" placeholder="Enter End Date" value="{{ old('end_date') }}">
                    @error('end_date')
                        <span class="text-danger"><small>{{ $message }}</small></span>
                    @enderror
                  </div>
              <button type="submit" class="btn btn-primary float-end text-uppercase"> Add Class </button>
          </form>
      </div>
  </div>
@endsection