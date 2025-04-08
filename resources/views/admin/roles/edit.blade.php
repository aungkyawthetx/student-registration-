@extends('layouts.app')
@section('title', 'Edit Role')
@section('content')
    <div class="card shadow-sm">
        <div class="card-header bg-white border-bottom d-flex justify-content-between align-items-center">
            <h4 class="card-title mb-0">Edit Role</h4>
            <a href="{{ route('roles.index') }}" class="btn btn-dark"> <i class="fa-solid fa-chevron-left"></i> Back</a>
        </div>
        <div class="card-body">
            <form action="{{ route('roles.update', $role->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="mb-3">
                    <label for="name" class="form-label ms-2"><i class="fas fa-tag"></i> Name</label>
                    <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" placeholder="Enter role name" value="{{ old('name', $role->name) }}">
                    @error('name')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div>
                    <label for="description" class="form-label ms-2"><i class="fas fa-align-left"></i> Description</label>
                    <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" placeholder="Enter role description">{{ old('description', $role->description) }}</textarea>
                    @error('description')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
            </form>
        </div>
        <div class="card-footer bg-transparent pt-0 border-0">
            <button type="submit" class="btn btn-primary"> Save</button>
        </div>
    </div>
@endsection
