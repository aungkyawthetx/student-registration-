@extends('layouts.app')
@section('title', 'Edit Course')
@section('content')
    <div class="card shadow-sm">
        <div class="card-header bg-transparent border-bottom d-flex align-items-center justify-content-between">
            <h4 class="card-title mb-0 d-inline">Edit Course</h4>
            <a href="{{ route('courses.index') }}" class="btn btn-dark"> <i class="fa-solid fa-chevron-left"></i> BACK </a>
        </div>
        <div class="card-body">
            <form action="{{ route('courses.update', $course->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="mb-3">
                    <label for="name" class="form-label ms-2"><i class="fas fa-book"></i> Course Name</label>
                    <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" placeholder="Enter course name" value="{{ old('name', $course->name) }}">
                    @error('name')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="duration" class="form-label ms-2"><i class="fas fa-clock"></i> Duration</label>
                    <input type="text" class="form-control @error('duration') is-invalid @enderror" id="duration" name="duration" placeholder="Enter course duration" value="{{ old('duration', $course->duration) }}">
                    @error('duration')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="start_date" class="form-label ms-2"><i class="fas fa-calendar-alt"></i> Start Date</label>
                    <input type="date" class="form-control @error('start_date') is-invalid @enderror" id="start_date" name="start_date" value="{{ old('start_date', $course->start_date) }}">
                    @error('start_date')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="end_date" class="form-label ms-2"><i class="fas fa-calendar-alt"></i> End Date</label>
                    <input type="date" class="form-control @error('end_date') is-invalid @enderror" id="end_date" name="end_date" value="{{ old('end_date', $course->end_date) }}">
                    @error('end_date')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="fees" class="form-label ms-2"><i class="fas fa-dollar-sign"></i> Fees</label>
                    <input type="number" class="form-control @error('fees') is-invalid @enderror" id="fees" name="fees" placeholder="Enter course fees" value="{{ old('fees', $course->fees) }}">
                    @error('fees')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
                <button type="submit" class="btn btn-primary float-end"> Update <i class="fa-solid fa-arrow-up-from-bracket"></i> </button>
            </form>
        </div>
    </div>
@endsection
