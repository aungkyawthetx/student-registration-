@extends('layouts.app')
@section('title', 'Class')
@section('content')
  <div class="container d-flex align-items-center justify-content-between">
    <h2 class="d-inline text-uppercase"> class list</h2>
    <div class="d-flex align-items-center justify-content-center gap-2">
      @if(auth()->user()->hasRole($roles[1]->name) || auth()->user()->hasRole($roles->first()->name))
      <a href="{{ route('classes.create') }}" class="btn btn-primary my-2"><i class="fas fa-plus"></i> Add new</a>
      <form action="{{route('classes.import')}}" method="POST" enctype="multipart/form-data">
          @csrf
          <input type="file" name="classtimetables" id="classtimetables" class="form-control-sm" required>
          <button type="submit" class="btn btn-primary my-2" title="Import"><i class="fa-solid fa-upload"></i></button>
      </form>
      <a href="{{ route('classes.export') }}" class="btn btn-primary my-2" title="Export" onclick="return confirm('Export classes data as an excel file?')"><i class="fa-solid fa-download"></i></a>
      @endif
  </div>
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
    <div class="container">
      <div class="row my-3">
          <div class="col-8">
              <form action="{{route('classes.search')}}" method="GET">
                  @csrf
                  <div class="input-group">
                      <input type="text" name="search_data" id="search_data" class="form-control" placeholder="Search ...." aria-label="Search" value="{{ request('search_data') }}">
                      <button class="btn btn-outline-secondary" type="submit"><i class="fas fa-search"></i></button>
                  </div>
              </form>
          </div>
          <div class="col-2 text-end">
              <form action="{{ route('classes.index') }}" method="GET" class="d-inline">
                  @csrf
                  <button type="submit" class="btn btn-secondary" title="Show All"><i class="fas fa-sync"></i></button>
              </form>
          </div>
          <div class="col-2 text-end">
            @if(auth()->user()->hasRole($roles[1]->name) || auth()->user()->hasRole($roles->first()->name))
            <form action="{{ route('classes.destroy-all') }}" method="POST" class="d-inline">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete all classes?')"><i class="fas fa-trash"></i></button>
            </form>
            @endif
        </div>
      </div>
  </div>
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
          @if(auth()->user()->hasRole($roles[1]->name) || auth()->user()->hasRole($roles->first()->name))
          <th scope="col">Actions</th>
          @endif
        </tr>
      </thead>
      <tbody>
        @if($classes->isEmpty())
          <tr>
            <td colspan="7" class="text-center">No data found</td>
          </tr>
        @else
        @foreach ($classes as $class)
        <tr>
          <td> {{ $class->id }} </td>
          <td> {{ $class->room ? $class->room->name : 'no room' }} </td>
          <td> {{ $class->start_time }} </td>
          <td> {{ $class->end_time }} </td>
          <td> {{ $class->date }} </td>
          <td> {{ $class->end_date }} </td>
          @if(auth()->user()->hasRole($roles[1]->name) || auth()->user()->hasRole($roles->first()->name))
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
          @endif
        </tr>
        @endforeach
        @endif
      </tbody>
    </table>
    {{ $classes->links('pagination::bootstrap-5') }}
  </div>
@endsection