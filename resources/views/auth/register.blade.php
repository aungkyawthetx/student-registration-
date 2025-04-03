@extends('layouts.auth')
@section('title', 'Register')
@section('auth-title', 'Create an account')
@section('content')
<form action="{{ route('register.store') }}" method="POST">
    @csrf
    <div class="mb-3">
        <label for="name" class="form-label"><i class="fas fa-user"></i> Name</label>
        <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" placeholder="Enter your name" value="{{ old('name') }}">
        @error('name')
            <span class="text-danger"><small>{{ $message }}</small></span>
        @enderror
    </div>
    <div class="mb-3">
        <label for="email" class="form-label"><i class="fas fa-envelope"></i> Email</label>
        <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" placeholder="Enter your email" value="{{ old('email') }}">
        @error('email')
            <span class="text-danger"><small>{{ $message }}</small></span>
        @enderror
    </div>
    <div class="mb-3">
        <label for="password" class="form-label"><i class="fas fa-lock"></i> Password</label>
        <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password" placeholder="Enter your password">
        @error('password')
            <span class="text-danger"><small>{{ $message }}</small></span>
        @enderror
    </div>
    <div class="mb-3">
        <label for="password_confirmation" class="form-label"><i class="fas fa-lock"></i> Confirm Password</label>
        <input type="password" class="form-control @error('password_confirmation') is-invalid @enderror" id="password_confirmation" name="password_confirmation" placeholder="Confirm your password">
        @error('password_confirmation')
            <span class="text-danger"><small>{{ $message }}</small></span>
        @enderror
    </div>
    <div class="mb-3">
        <a href="{{route('login')}}" class="text-body">>> Login here</a>
    </div>
    <button type="submit" class="btn btn-primary w-100 text-uppercase fw-bold">Register</button>
</form>
@endsection