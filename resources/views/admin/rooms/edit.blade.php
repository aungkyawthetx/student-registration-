@extends('layouts.app')
@section('title', 'Edit Room')
@section('content')
    <div class="card shadow-sm">
        <div class="card-header bg-white border-bottom d-flex align-items-center justify-content-between">
            <h4 class="card-title mb-0">Edit Room</h4>
            <a href="{{ route('rooms.index') }}" class="btn btn-dark"> <i class="fa-solid fa-chevron-left"></i> BACK </a>
        </div>
        <div class="card-body">
            <form action="{{ route('rooms.update', $room->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="mb-3">
                    <label for="building" class="form-label ms-2"><i class="fas fa-building"></i> Building</label>
                    <input type="text" class="form-control @error('building') is-invalid @enderror" id="building" name="building" placeholder="Enter building name" value="{{ old('building', $room->building) }}">
                    @error('building')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="name" class="form-label ms-2"><i class="fas fa-door-closed"></i> Room Name</label>
                    <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" placeholder="Enter room name" value="{{ old('name', $room->name) }}">
                    @error('name')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
                <button type="submit" class="btn btn-primary float-end"> Update <i class="fa-solid fa-arrow-up-from-bracket"></i> </button>
            </form>
        </div>
    </div>
@endsection
