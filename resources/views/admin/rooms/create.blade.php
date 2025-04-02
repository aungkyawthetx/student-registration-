@extends('layouts.app')
@section('title', 'Add New Room')
@section('content')
    <div class="card">
        <div class="card-header">
            <h4>Add New Room</h4>
        </div>
        <div class="card-body">
            <form action="{{ route('rooms.store') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="building" class="form-label ms-2"><i class="fas fa-building"></i> Building</label>
                    <input type="text" class="form-control @error('building') is-invalid @enderror" id="building" name="building" placeholder="Enter building name" value="{{ old('building') }}">
                    @error('building')
                        <span class="text-danger"><small>{{ $message }}</small></span>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="name" class="form-label ms-2"><i class="fas fa-door-closed"></i> Room Name</label>
                    <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" placeholder="Enter room name" value="{{ old('name') }}">
                    @error('name')
                        <span class="text-danger"><small>{{ $message }}</small></span>
                    @enderror
                </div>
                <button type="submit" class="btn btn-primary"><i class="fas fa-plus"></i> Add</button>
            </form>
        </div>
    </div>
@endsection
