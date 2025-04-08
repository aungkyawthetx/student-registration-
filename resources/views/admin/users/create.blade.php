@extends('layouts.app')

@section('title', 'Add New User')

@section('content')
<div class="card shadow-sm">
    <div class="card-header bg-white border-bottom d-flex align-items-center justify-content-between">
        <h4 class="card-title d-inline mb-0">Add New User</h4>
        <a href="{{ route('users.index') }}" class="btn btn-dark"> <i class="fa-solid fa-chevron-left"></i> Back</a>
    </div>

    <div class="card-body">
        <form action="{{ route('users.store') }}" method="POST">
            @csrf

            <div class="mb-3">
                <label for="name" class="form-label"><i class="fas fa-user me-1"></i> Name</label>
                <input type="text" 
                       class="form-control @error('name') is-invalid @enderror" 
                       id="name" 
                       name="name" 
                       placeholder="Enter user name" 
                       value="{{ old('name') }}">
                @error('name')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="email" class="form-label"><i class="fas fa-envelope me-1"></i> Email</label>
                <input type="email" 
                       class="form-control @error('email') is-invalid @enderror" 
                       id="email" 
                       name="email" 
                       placeholder="Enter user email" 
                       value="{{ old('email') }}">
                @error('email')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="password" class="form-label"><i class="fas fa-lock me-1"></i> Password</label>
                <input type="password" 
                       class="form-control @error('password') is-invalid @enderror" 
                       id="password" 
                       name="password" 
                       placeholder="Enter password">
                @error('password')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="password_confirmation" class="form-label"><i class="fas fa-lock me-1"></i> Confirm Password</label>
                <input type="password" 
                       class="form-control @error('password_confirmation') is-invalid @enderror" 
                       id="password_confirmation" 
                       name="password_confirmation" 
                       placeholder="Confirm password">
                @error('password_confirmation')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div>
                <label for="role" class="form-label"><i class="fas fa-user-tag me-1"></i> Role</label>
                <select class="form-select @error('role') is-invalid @enderror" 
                        id="role" 
                        name="role">
                    <option value="" disabled selected>Select Role</option>
                    @foreach($roles as $role)
                        <option value="{{ $role->id }}" {{ old('role') == $role->id ? 'selected' : '' }}>
                            {{ $role->name }}
                        </option>
                    @endforeach
                </select>
                @error('role')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </form>
    </div>
    <div class="card-footer bg-transparent border-0 pt-0">
        <button type="submit" class="btn btn-primary float-end"> Add User </button>
    </div>
</div>
@endsection
