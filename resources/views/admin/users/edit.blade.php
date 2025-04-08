@extends('layouts.app')
@section('title', 'Edit User')
@section('content')
    <div class="card shadow-sm">
        <div class="card-header bg-white border-bottom d-flex align-items-center justify-content-between">
            <h4>Edit User</h4>
            <a href="{{ route('users.index') }}" class="btn btn-dark">Back</a>
        </div>
        <div class="card-body">
            <form action="{{ route('users.update', $user->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="mb-3">
                    <label for="name" class="form-label ms-2"><i class="fas fa-user"></i> Name</label>
                    <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" placeholder="Enter user name" value="{{ old('name', $user->name) }}">
                    @error('name')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label ms-2"><i class="fas fa-envelope"></i> Email</label>
                    <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" placeholder="Enter email address" value="{{ old('email', $user->email) }}">
                    @error('email')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="role" class="form-label ms-2"><i class="fas fa-user-tag"></i> Role</label>
                    <select class="form-control @error('role') is-invalid @enderror" id="role" name="role">
                        <option value="" disabled>Select Role</option>
                        @foreach($roles as $role)
                            <option value="{{ $role->id }}" {{ old('role', $user->role_id) == $role->id ? 'selected' : '' }}>
                                {{ $role->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('role')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
                <button type="submit" class="btn btn-primary"> Save </button>
            </form>
        </div>
    </div>
@endsection
