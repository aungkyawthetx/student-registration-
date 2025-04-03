@extends('layouts.auth')
@section('title', 'Login')
@section('auth-title', 'Log in to your account')
@section('content')
<form action="{{ route('login.store') }}" method="POST">
    @csrf
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show mt-3" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show mt-3" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
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
        <a href="{{route('register')}}" class="text-body">>> Create an account here</a>
    </div>
    <button type="submit" class="btn btn-primary w-100 text-uppercase fw-bold">Login</button>
</form>
@endsection