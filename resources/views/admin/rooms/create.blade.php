@extends('layouts.app')
@section('title', 'Add New Room')
@section('content')
    <div class="card shadow-sm">
        <div class="card-header bg-white border-bottom d-flex align-items-center justify-content-between">
            <h4 class="card-title mb-0 d-inline"> New Room</h4>
            <a href="{{ route('rooms.index') }}" class="btn btn-dark"> <i class="fa-solid fa-chevron-left"></i> BACK</a>
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
                <div>
                    <label for="name" class="form-label ms-2"><i class="fas fa-door-closed"></i> Room Name</label>
                    <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" placeholder="Enter room name" value="{{ old('name') }}">
                    @error('name')
                        <span class="text-danger"><small>{{ $message }}</small></span>
                    @enderror
                </div>
            </form>
        </div>
        <div class="card-footer  border-0 bg-transparent pt-0">
            <button type="submit" class="btn btn-primary float-end"><i class="fas fa-plus"></i> Add</button>
        </div>
    </div>
@endsection
