@extends('layouts.app')
@section('title', 'Add New Teacher')
@section('content')
    <div class="card border-0 shadow bg-light">
        <div class="card-header d-flex align-items-center justify-content-between">
            <h4 class="text-uppercase"> new teacher</h4>
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
                    <label for="course" class="form-label ms-2"><i class="fas fa-book"></i> Course</label>
                    <select class="form-select @error('course') is-invalid @enderror" name="course">
                        <option value="" disabled selected>Select a course</option>
                        @foreach($courses as $course)
                            <option value="{{ $course->name }}" {{ old('course', $course->id) }}>
                                {{ $course->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('course')
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
                <button type="submit" class="btn btn-primary float-end"><i class="fas fa-user-plus"></i> Add </button>
            </form>
        </div>
    </div>
@endsection
