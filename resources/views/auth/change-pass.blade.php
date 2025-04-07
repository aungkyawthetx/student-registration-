@extends('layouts.auth')
@section('title', 'Reset password')
@section('auth-title', 'Reset Password')
@section('content')
<form action="{{route('store-pass')}}" method="POST">
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
    <input type="hidden" name="token" value="{{ $token }}">
    <input type="hidden" name="email" value="{{ request('email') }}">
    <div class="mb-3">
        <label for="password" class="form-label"><i class="fas fa-lock"></i> New Password</label>
        <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password" placeholder="Enter your new password">
        @error('password')
            <span class="text-danger"><small>{{ $message }}</small></span>
        @enderror
    </div>
    <div class="mb-3">
        <label for="confirm_password" class="form-label"><i class="fas fa-lock"></i> Confirm Password</label>
        <input type="password" class="form-control @error('confirm_password') is-invalid @enderror" id="confirm_password" name="confirm_password" placeholder="Enter your new password again.">
        @error('confirm_password')
            <span class="text-danger"><small>{{ $message }}</small></span>
        @enderror
    </div>
    <button type="submit" class="btn btn-primary w-100 text-uppercase fw-bold">Change Password</button>
</form>
@endsection