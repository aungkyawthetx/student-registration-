@extends('layouts.app')

@section('title', 'Class')

@section('content')
<div class="card shadow-sm">
    <div class="card-header bg-white border-bottom">
        <div class="container d-flex justify-content-between align-items-center mt-1">
            <h2 class="card-title d-inline mb-0">Class List</h2>
            <a href="{{ route('classes.create') }}" class="btn btn-primary">
                <i class="fas fa-plus me-1"></i> Add New
            </a>
        </div>

        @if(Session('successAlert'))
            <div class="container mt-3">
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ Session('successAlert') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            </div>
        @elseif (Session('errorAlert'))
            <div class="container mt-3">
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ Session('errorAlert') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            </div>
        @endif
    </div>

    <div class="card-body">
      <div class="table-responsive container">
        <table class="table table-striped table-hover align-middle text-center">
          <thead class="table-light">
              <tr>
                  <th>ID</th>
                  <th>Room Name</th>
                  <th>Date</th>
                  <th>Start Time</th>
                  <th>End Time</th>
                  <th>End Date</th>
                  <th>Actions</th>
              </tr>
          </thead>
          <tbody>
              @foreach ($classes as $class)
              <tr>
                <td>{{ $class->id }}</td>
                <td>{{ $class->room ? $class->room->name : 'No Room' }}</td>
                <td>{{ $class->date }}</td>
                <td>{{ $class->start_time }}</td>
                <td>{{ $class->end_time }}</td>
                <td>{{ $class->end_date }}</td>
                <td>
                    <div class="d-flex justify-content-center gap-2">
                        <a href="{{ route('classes.edit', $class->id) }}" class="btn btn-sm btn-success" title="Edit">
                            <i class="fa-solid fa-pen-to-square me-1"></i> Edit
                        </a>
                        <form action="{{ route('classes.destroy', $class->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this row?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger" title="Delete">
                                <i class="fa-solid fa-trash me-1"></i> Delete
                            </button>
                        </form>
                    </div>
                </td>
              </tr>
              @endforeach
          </tbody>
        </table>
      </div>
    </div>
    <div class="card-footer bg-transparent border-0 pt-0">
      <div class="container">
        {{ $classes->links('pagination::bootstrap-5') }}
      </div>
    </div>
</div>
@endsection
