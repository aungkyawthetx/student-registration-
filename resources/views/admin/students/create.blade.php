@extends('layouts.app')
@section('title', 'Add New Student')
@section('content')
    <div class="card shadow-sm my-2">
        <div class="card-header bg-transparent border-bottom">
            <div class="container d-flex justify-content-between align-items-center mt-1">
                <h4 class="text-uppercase">new student </h4>
                <a href="{{ route('students.index') }}" class="btn btn-dark"> <i class="fa-solid fa-chevron-left"></i> Back</a>
            </div>
            
        </div>
        <div class="card-body">
            <form action="{{ route('students.store') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="name" class="form-label ms-2"><i class="fas fa-user"></i> Name</label>
                    <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" placeholder="Enter student name" value="{{ old('name') }}">
                    @error('name')
                        <span class="text-danger"><small>{{ $message }}</small></span>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="gender" class="form-label ms-2"><i class="fas fa-venus-mars"></i> Gender</label>
                    <div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input @error('gender') is-invalid @enderror" type="radio" id="gender_male" name="gender" value="male" {{ old('gender') == 'male' ? 'checked' : '' }}>
                            <label class="form-check-label" for="gender_male">Male</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input @error('gender') is-invalid @enderror" type="radio" id="gender_female" name="gender" value="female" {{ old('gender') == 'female' ? 'checked' : '' }}>
                            <label class="form-check-label" for="gender_female">Female</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input @error('gender') is-invalid @enderror" type="radio" id="gender_other" name="gender" value="other" {{ old('gender') == 'other' ? 'checked' : '' }}>
                            <label class="form-check-label" for="gender_other">Other</label>
                        </div>
                    </div>
                    @error('gender')
                        <span class="text-danger"><small>{{ $message }}</small></span>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="nrc" class="form-label ms-2"><i class="fas fa-id-card"></i> NRC</label>
                    <input type="text" class="form-control @error('nrc') is-invalid @enderror" id="nrc" name="nrc" placeholder="Enter NRC number" value="{{ old('nrc') }}">
                    @error('nrc')
                        <span class="text-danger"><small>{{ $message }}</small></span>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="dob" class="form-label ms-2"><i class="fas fa-calendar-alt"></i> Date of Birth</label>
                    <input type="date" class="form-control @error('dob') is-invalid @enderror" id="dob" name="dob" value="{{ old('dob') }}">
                    @error('dob')
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
                <div class="mb-3">
                    <label for="phone" class="form-label ms-2"><i class="fas fa-phone"></i> Phone</label>
                    <input type="text" class="form-control @error('phone') is-invalid @enderror" id="phone" name="phone" placeholder="Enter phone number" value="{{ old('phone') }}">
                    @error('phone')
                        <span class="text-danger"><small>{{ $message }}</small></span>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="address" class="form-label ms-2"><i class="fas fa-map-marker-alt"></i> Address</label>
                    <textarea class="form-control @error('address') is-invalid @enderror" id="address" name="address" rows="3" placeholder="Enter address">{{ old('address') }}</textarea>
                    @error('address')
                        <span class="text-danger"><small>{{ $message }}</small></span>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="parent_info" class="form-label ms-2"><i class="fas fa-users"></i> Parent Information</label>
                    <textarea class="form-control @error('parent_info') is-invalid @enderror" id="parent_info" name="parent_info" rows="5" placeholder="Enter parent information">{{ old('parent_info') }}</textarea>
                    @error('parent_info')
                        <span class="text-danger"><small>{{ $message }}</small></span>
                    @enderror
                </div>
                <button type="submit" class="btn btn-primary"> Add <i class="fas fa-user-plus me-1"></i> </button>
            </form>
        </div>
    </div>
@endsection