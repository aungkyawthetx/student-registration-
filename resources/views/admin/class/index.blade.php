@extends('layouts.app')
@section('title', 'Class')
@section('content')
  <div class="container d-flex align-items-center justify-content-between">
    <h2 class="d-inline text-uppercase"> class list</h2>
    <a href="{{ route('classes.create') }}" class="btn btn-primary my-2 float-end"> Add New <i class="fas fa-plus"></i> </a>
  </div>
  @if(Session('successAlert'))
        <div class="alert alert-success alert-dismissible fade show mt-3" role="alert">
            {{ Session('successAlert') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @elseif (Session('errorAlert'))
        <div class="alert alert-danger alert-dismissible fade show">
          {{ Session('errorAlert') }}
          <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif
  <div class="table-responsive container my-3">
    <table class="table table-hover table-bordered table-striped text-center">
      <thead>
        <tr>
          <th scope="col">ID</th>
          <th scope="col">Room Name</th>
          <th scope="col">Date</th>
          <th scope="col">Start Time</th>
          <th scope="col">End Time</th>
          <th scope="col">End Date</th>
          <th scope="col">Actions</th>
        </tr>
      </thead>
      <tbody>
        @foreach ($classes as $class)
        <tr>
          <td> {{ $class->id }} </td>
          <td> {{ $class->room ? $class->room->name : 'no room' }} </td>
          <td> {{ $class->start_time }} </td>
          <td> {{ $class->end_time }} </td>
          <td> {{ $class->date }} </td>
          <td> {{ $class->end_date }} </td>
          <td>
            <div>
              <a href="{{ route('classes.edit', $class->id) }}" class="btn btn-sm btn-success me-2" title="Edit">Edit <i class="fa-solid fa-pen-to-square"></i> </a>
              <form action="{{ route('classes.destroy', $class->id) }}" method="POST" class="d-inline">
                  @csrf
                  @method('DELETE')
                  <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this row?')" title="Delete"> Delete <i class="fa-solid fa-trash"></i> </button>
              </form>
          </div>
          </td>
        </tr>
        @endforeach
      </tbody>
    </table>
    {{ $classes->links('pagination::bootstrap-5') }}
  </div>
@endsection