@extends('layouts.app')
@section('title', 'Add New Teacher')
@section('content')
    <div class="card shadow-sm">
        <div class="card-header bg-transparent border-bottom d-flex align-items-center justify-content-between">
            <h4 class="card-title mb-0"> New Teacher</h4>
            <a href="{{ route('teachers.index') }}" class="btn btn-dark""> <i class="fa-solid fa-chevron-left"></i> BACK</a>
        </div>
        <div class="card-body">
            <form action="{{ route('teachers.store') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="name" class="form-label ms-2"><i class="fas fa-user"></i> Name</label>
                    <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" placeholder="Enter teacher name" value="{{ old('name') }}">
                    @error('name')
                        <span class="text-danger"><small>{{ $message }}</small></span>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="subject" class="form-label ms-2"><i class="fas fa-book"></i> Subject</label>
                    <input type="text" name="subject" class="form-control @error('subject') is-invalid @enderror" placeholder="Enter Subject Name" value="{{ old('subject') }}">
                    @error('subject')
                        <span class="text-danger"><small>{{ $message }}</small></span>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label ms-2"><i class="fas fa-envelope"></i> Email</label>
                    <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" placeholder="Enter email address" value="{{ old('email') }}">
                    @error('email')
                        <span class="text-danger"><small>{{ $message }}</small></span>
                    @enderror
                </div>
                <div class="mb-2">
                    <label for="phone" class="form-label ms-2"><i class="fas fa-phone"></i> Phone</label>
                    <input type="text" class="form-control @error('phone') is-invalid @enderror" id="phone" name="phone" placeholder="Enter phone number" value="{{ old('phone') }}">
                    @error('phone')
                        <span class="text-danger"><small>{{ $message }}</small></span>
                    @enderror
                </div>
                <button type="submit" class="btn btn-primary float-end"> Submit </button>
            </form>
        </div>
    </div>
@endsection
