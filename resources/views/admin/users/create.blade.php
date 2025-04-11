@extends('layouts.app')
@section('title', 'Add New User')
@section('content')
    <div class="card">
        <div class="card-header bg-transparent">
            <h4>Add New User</h4>
        </div>
        <div class="card-body">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show mt-2" role="alert">
                    {{ session('successAlert') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show mt-2" role="alert">
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            <form action="{{ route('users.store') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="name" class="form-label ms-2"><i class="fas fa-user"></i> Name</label>
                    <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" placeholder="Enter user name" value="{{ old('name') }}">
                    @error('name')
                        <span class="text-danger"><small>{{ $message }}</small></span>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label ms-2"><i class="fas fa-envelope"></i> Email</label>
                    <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" placeholder="Enter user email" value="{{ old('email') }}">
                    @error('email')
                        <span class="text-danger"><small>{{ $message }}</small></span>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label ms-2"><i class="fas fa-lock"></i> Password</label>
                    <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password" placeholder="Enter password">
                    @error('password')
                        <span class="text-danger"><small>{{ $message }}</small></span>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="password_confirmation" class="form-label ms-2"><i class="fas fa-lock"></i> Confirm Password</label>
                    <input type="password" class="form-control @error('password_confirmation') is-invalid @enderror" id="password_confirmation" name="password_confirmation" placeholder="Confirm password">
                    @error('password_confirmation')
                        <span class="text-danger"><small>{{ $message }}</small></span>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="role" class="form-label ms-2"><i class="fas fa-user-tag"></i> Role</label>
                    <select class="form-control @error('role') is-invalid @enderror" id="role" name="role">
                        <option value="" disabled selected>Select Role</option>
                        @foreach($roles as $role)
                            <option value="{{ $role->id }}" {{ old('role') == $role->id ? 'selected' : '' }}>{{ $role->name }}</option>
                        @endforeach
                    </select>
                    @error('role')
                        <span class="text-danger"><small>{{ $message }}</small></span>
                    @enderror
                </div>
                <button type="submit" class="btn btn-primary"><i class="fas fa-plus"></i> Add</button>
            </form>
        </div>
    </div>
@endsection
