@extends('layouts.app')
@section('title', 'Change password')
@section('content')
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
<div class="card">
    <div class="card-header">
        <h4>Change Password</h4>
    </div>
    <div class="card-body">
        <form action="{{ route('store-password',$user->id ?? Auth::user()->id) }}" method="POST">
            @csrf
            @if(!auth()->user()->hasRole('Super admin'))
            <div class="mb-3">
                <label for="current_password" class="form-label"><i class="fas fa-lock"></i> Current Password</label>
                <input type="password" class="form-control" id="current_password" name="current_password" placeholder="Enter current password" required>
            </div>
            @endif
            <div class="mb-3">
                <label for="password" class="form-label"><i class="fas fa-lock"></i> New Password</label>
                <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password" placeholder="Enter new password">
                @error('password')
                    <span class="text-danger"><small>{{ $message }}</small></span>
                @enderror
            </div>
            <div class="mb-3">
                <label for="confirm_password" class="form-label"><i class="fas fa-lock"></i> Confirm Password</label>
                <input type="password" class="form-control @error('confirm_password') is-invalid @enderror" id="confirm_password" name="confirm_password" placeholder="Enter new password again.">
                @error('confirm_password')
                    <span class="text-danger"><small>{{ $message }}</small></span>
                @enderror
            </div>
            <button type="submit" class="btn btn-primary w-100 text-uppercase fw-bold">Change Password</button>
        </form>
    </div>
</div>
@endsection