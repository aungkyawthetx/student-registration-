@extends('layouts.app')
@section('title', 'Add New Course')
@section('content')
    <div class="card border-0 shadow bg-light">
        <div class="card-header d-flex align-items-center justify-content-between">
            <h4 class="text-uppercase">New Course</h4>
            <a href="{{ route('courses.index') }}" class="btn btn-dark"> <i class="fa-solid fa-chevron-left"></i> Back</a>
        </div>
        <div class="card-body">
            <form action="{{ route('courses.store') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="name" class="form-label ms-2"><i class="fas fa-book"></i> Course Name</label>
                    <input type="text" class="form-control" id="name" name="name" placeholder="Enter course name">
                </div>
                <div class="mb-3">
                    <label for="duration" class="form-label ms-2"><i class="fas fa-clock"></i> Duration</label>
                    <input type="text" class="form-control" id="duration" name="duration" placeholder="Enter course duration">
                </div>
                <div class="mb-3">
                    <label for="start_date" class="form-label ms-2"><i class="fas fa-calendar-alt"></i> Start Date</label>
                    <input type="date" class="form-control" id="start_date" name="start_date">
                </div>
                <div class="mb-3">
                    <label for="end_date" class="form-label ms-2"><i class="fas fa-calendar-alt"></i> End Date</label>
                    <input type="date" class="form-control" id="end_date" name="end_date">
                </div>
                <div class="mb-3">
                    <label for="fees" class="form-label ms-2"><i class="fas fa-dollar-sign"></i> Fees</label>
                    <input type="number" class="form-control" id="fees" name="fees" placeholder="Enter course fees">
                </div>
                <button type="submit" class="btn btn-primary float-end"><i class="fas fa-plus"></i> Add</button>
            </form>
        </div>
    </div>
@endsection
