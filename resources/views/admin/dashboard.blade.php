@extends('layouts.app')
@section('title', 'Student Registration System')
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
    <h2>Dashboard</h2>

    <div class="row mt-4 mb-2">
        <!-- Total Students -->
        <div class="col-md-4">
            <div class="card text-white bg-primary border-0 mb-3">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h5 class="card-title">Total Students</h5>
                            <h2 class="mb-0">{{ $studentCount }}</h2>
                        </div>
                        <i class="fas fa-users fa-3x"></i>
                    </div>
                    <a href="{{ route('students.index') }}" class="text-white small">View All</a>
                </div>
            </div>
        </div>
    
        <!-- Teachers -->
        <div class="col-md-4">
            <div class="card text-white bg-success border-0 mb-3">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h5 class="card-title">Total Teachers</h5>
                            <h2 class="mb-0">{{ $teacherCount }}</h2>
                        </div>
                        <i class="fas fa-chalkboard-teacher fa-3x"></i>
                    </div>
                    <a href="{{ route('teachers.index') }}" class="text-white small">View All</a>
                </div>
            </div>
        </div>
    
        <!-- Classes -->
        <div class="col-md-4">
            <div class="card text-white bg-info border-0 mb-3">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h5 class="card-title">Total Classes</h5>
                            <h2 class="mb-0">{{ $classCount }}</h2>
                        </div>
                        <i class="fas fa-school fa-3x"></i>
                    </div>
                    <a href="{{ route('classes.index') }}" class="text-white small">View All</a>
                </div>
            </div>
        </div>
    </div>

    <div class="row mb-4">
        <div class="col-12 col-md-6">
            <div class="card mb-3">
                <div class="card-header bg-secondary text-light">
                    <h5>Students Per Class</h5>
                </div>
                <div class="card-body">
                    <canvas id="studentsPerClassChart" height="200" style="display: block;"></canvas>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-6">
            <div class="card">
                <div class="card-header bg-secondary text-light">
                    <h5>Monthly Registrations</h5>
                </div>
                <div class="card-body">
                    <canvas id="monthlyRegistrationsChart" height="200" style="display: block;"></canvas>
                </div>
            </div>
        </div>
    </div>

    <div class="card mb-3 border-1">
        <div class="card-header">
            <h5>Quick Actions</h5>
        </div>
        <div class="card-body">
            <div class="row text-center">
                <div class="col-md-4 mb-3">
                    <a href="{{ route('students.create') }}" class="btn btn-outline-primary btn-block">
                        <i class="fas fa-user-plus"></i> Add Student
                    </a>
                </div>
                <div class="col-md-4 mb-3">
                    <a href="{{ route('teachers.create') }}" class="btn btn-outline-success btn-block">
                        <i class="fas fa-chalkboard-teacher"></i> Add Teacher
                    </a>
                </div>
                <div class="col-md-4 mb-3">
                    <a href="{{ route('classes.create') }}" class="btn btn-outline-info btn-block">
                        <i class="fas fa-school"></i> Add Class
                    </a>
                </div>
            </div>
        </div>
    </div>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const ctx = document.getElementById('studentsPerClassChart').getContext('2d');
        const chart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: {!! json_encode($studentsPerClass->pluck('course.name')) !!},
                datasets: [{
                    label: 'Number of Students',
                    data: {!! json_encode($studentsPerClass->pluck('students_count')) !!},
                    backgroundColor: 'rgba(54, 162, 235, 0.5)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 1
                }]  
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true,
                        title: {
                            display: true,
                            text: 'Number of Students',
                            color: 'rgba(54, 162, 235, 0.8)'
                        },
                        ticks: {
                            stepSize: 1,
                            color: 'rgba(54, 162, 235, 1)'
                        }
                    },
                    x: {
                        title: {
                            display: true,
                            text: 'Course Name',
                            color: 'rgba(54, 162, 235, 0.8)'
                        },
                        ticks:{
                            color: 'rgba(54, 162, 235, 1)'
                        }
                    }
                },
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                return `${context.parsed.y} students`;
                            }
                        }
                    }
                }
            }
        });
        const monthlyRegistrationsCtx = document.getElementById('monthlyRegistrationsChart').getContext('2d');
        const monthlyRegistrationsChart = new Chart(monthlyRegistrationsCtx, {
            type: 'line',
            data: {
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
                datasets: [{
                    label: 'Student Registrations',
                    data: {!! json_encode($monthlyRegistrations) !!},
                    fill: false,
                    borderColor: 'rgb(75, 192, 192)',
                    tension: 0.1
                }]
            },
            options: {
                responsive: true,
                plugins:{
                    legend:{
                        labels:{
                            color:'rgb(75, 192, 192)'
                        }
                    }
                },
                scales: {
                    x: {
                        ticks: {
                            color: 'rgb(75, 192, 192)'
                        }
                    },
                    y: {
                        ticks: {
                            stepSize: 1,
                            color: 'rgb(75, 192, 192)'
                        }
                    }
                }
            }
        }); 
    });
    </script>
@endsection