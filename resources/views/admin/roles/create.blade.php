@extends('layouts.app')
@section('title', 'Add New Role')
@section('content')
    <div class="card shadow-sm">
        <div class="card-header bg-white border-bottom d-flex justify-content-between align-items-center">
            <h4 class="card-title mb-0">Add New Role</h4>
            <a href="{{ route('roles.index') }}" class="btn btn-dark"> <i class="fa-solid fa-chevron-left"></i> Back</a>
        </div>
        <div class="card-body">
            <form action="{{ route('roles.store') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="name" class="form-label ms-2"><i class="fas fa-user-tag"></i> Role Name</label>
                    <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" placeholder="Enter role name" value="{{ old('name') }}">
                    @error('name')
                        <span class="text-danger"><small>{{ $message }}</small></span>
                    @enderror
                </div>
                <div>
                    <label for="description" class="form-label ms-2"><i class="fas fa-align-left"></i> Description</label>
                    <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" placeholder="Enter role description">{{ old('description') }}</textarea>
                    @error('description')
                        <span class="text-danger"><small>{{ $message }}</small></span>
                    @enderror
                </div>
            </form>
        </div>
        <div class="card-footer bg-transparent pt-0 border-0">
            <button type="submit" class="btn btn-primary"><i class="fas fa-plus"></i> Add</button>
        </div>
    </div>
@endsection
