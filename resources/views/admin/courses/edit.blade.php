@extends('layouts.app')
@section('title', 'Edit Course')
@section('content')
    <div class="card shadow-sm">
        <div class="card-header bg-transparent border-bottom d-flex align-items-center justify-content-between">
            <h4 class="card-title mb-0 d-inline">Edit Course</h4>
            <a href="{{ route('courses.index') }}" class="btn btn-dark"> <i class="fa-solid fa-chevron-left"></i> BACK </a>
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
