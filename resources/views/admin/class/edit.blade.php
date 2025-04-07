@extends('layouts.app')
@section('title', 'Update Class')
@section('content')
  
  <div class="card shadow bg-light border-0">
      <div class="card-header d-flex align-items-center justify-content-between">
          <h4 class="text-uppercase"> Update class </h4>
          <a href="{{ route('classes.index') }}" class="btn btn-dark fw-bold float-end"> <i class="fa-solid fa-chevron-left"></i> Back</a>
      </div>
      <div class="card-body">
          <form action="{{ route('classes.update', $class->id) }}" method="POST">
              @csrf
              @method('PUT')
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
                    <label for="start_time" class="form-label ms-2 fw-bold"> <i class="fa-solid fa-clock text-success"></i> Start Time</label>
                    <input type="text" class="form-control @error('start_time') is-invalid @enderror" name="start_time" placeholder="Enter Start-Time" value="{{$class->start_time ?? old('start_time') }}">
                    @error('start_time')
                        <span class="text-danger"><small>{{ $message }}</small></span>
                    @enderror
                  </div>

                  <div class="mb-3">
                    <label for="end_time" class="form-label ms-2 fw-bold"> <i class="fa-solid fa-clock text-warning"></i> End Time</label>
                    <input type="text" class="form-control @error('end_time') is-invalid @enderror" name="end_time" placeholder="Enter End-Time" value="{{$class->end_time ?? old('end_time') }}">
                    @error('end_time')
                        <span class="text-danger"><small>{{ $message }}</small></span>
                    @enderror
                  </div>

                  <div class="mb-3">
                    <label for="date" class="form-label fw-bold ms-2"> <i class="fa-solid fa-calendar text-primary"></i> Date</label>
                    <input type="date" class="form-control @error('date') is-invalid @enderror" name="date" placeholder="Enter Date" value="{{$class->date ?? old('date') }}">
                    @error('date')
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
              <button type="submit" class="btn btn-primary float-end"> Update <i class="fa-solid fa-arrow-up-from-bracket"></i> </button>
          </form>
      </div>
  </div>
@endsection