@extends('layouts.app')
@section('title', 'Add New Course')
@section('content')
    <div class="card shadow-sm">
        <div class="card-header bg-transparent border-bottom d-flex align-items-center justify-content-between">
            <h4 class="card-title mb-0 d-inline">New Course</h4>
            <a href="{{ route('courses.index') }}" class="btn btn-dark"> <i class="fa-solid fa-chevron-left"></i> Back</a>
        </div>
        <div class="card-body">
            <form action="{{ route('courses.store') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="name" class="form-label ms-2"><i class="fas fa-book"></i> Course Name</label>
                    <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" placeholder="Enter course name">
                    @error('name')
                        <span class="text-danger"><small>{{ $message }}</small></span>
                    @enderror
                </div>
                <div class="mb-2">
                    <label for="fees" class="form-label ms-2"><i class="fas fa-dollar-sign"></i> Fees</label>
                    <input type="number" class="form-control @error('fees') is-invalid @enderror" id="fees" name="fees" placeholder="Enter course fees">
                    @error('fees')
                        <span class="text-danger"><small>{{ $message }}</small></span>
                    @enderror
                </div>
                <button type="submit" class="btn btn-primary float-end"><i class="fas fa-plus"></i> Add</button>
            </form>
        </div>
    </div>
@endsection
