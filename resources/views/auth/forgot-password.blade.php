@extends('layouts.auth')
@section('title', 'Forgot Password')
@section('auth-title', 'Reset Password')
@section('content')
<form action="{{ route('reset-pass') }}" method="POST">
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
    <div class="mb-3 d-flex justify-content-between align-items-center">
        <a href="{{route('login')}}" class="text-body">>> Back to login</a>
    </div>
    <button type="submit" class="btn btn-primary w-100 text-uppercase fw-bold">Reset password</button>
</form>
@endsection