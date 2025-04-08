@extends('layouts.app')
@section('title', 'Attendances')
@section('content')
  <div class="container d-flex align-items-center justify-content-between">
    <h2 class="d-inline text-uppercase"> attendances list</h2>
    <div class="d-flex align-items-center justify-content-center gap-2">
      @if(auth()->user()->hasRole($roles[1]->name) || auth()->user()->hasRole($roles->first()->name) || auth()->user()->hasRole($roles[3]->name))
      <a href="{{ route('attendances.create') }}" class="btn btn-primary my-2"><i class="fas fa-plus"></i> Add new</a>
      <form action="{{route('attendances.import')}}" method="POST" enctype="multipart/form-data">
          @csrf
          <input type="file" name="attendances" id="attendances" class="form-control-sm" required>
          <button type="submit" class="btn btn-primary my-2" title="Import"><i class="fa-solid fa-upload"></i></button>
      </form>
      <a href="{{ route('attendances.export') }}" class="btn btn-primary my-2" title="Export" onclick="return confirm('Export attendances data as an excel file?')"><i class="fa-solid fa-download"></i></a>
      @endif
  </div>
  </div>
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
<div class="container">
    <div class="row my-3">
        <div class="col-8">
            <form action="{{route('attendances.search')}}" method="GET">
                @csrf
                <div class="input-group">
                    <input type="text" name="search_data" id="search_data" class="form-control" placeholder="Search ...." aria-label="Search" value="{{ request('search_data') }}">
                    <button class="btn btn-outline-secondary" type="submit"><i class="fas fa-search"></i></button>
                </div>
            </form>
        </div>
        <div class="col-2 text-end">
            <form action="{{ route('attendances.index') }}" method="GET" class="d-inline">
                @csrf
                <button type="submit" class="btn btn-secondary" title="Show All"><i class="fas fa-sync"></i></button>
            </form>
        </div>
        <div class="col-2 text-end">
          @if(auth()->user()->hasRole($roles[1]->name) || auth()->user()->hasRole($roles->first()->name))
          <form action="{{ route('attendances.destroy-all') }}" method="POST" class="d-inline">
              @csrf
              @method('DELETE')
              <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete all attendances?')"><i class="fas fa-trash"></i></button>
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
          <th scope="col">Student Name</th>
          <th scope="col">Date</th>
          <th scope="col">Course Name</th>
          <th scope="col">Room</th>
          <th scope="col">Status</th>
          @if(auth()->user()->hasRole($roles[1]->name) || auth()->user()->hasRole($roles->first()->name) || auth()->user()->hasRole($roles[3]->name))
          <th scope="col">Actions</th>
          @endif
        </tr>
      </thead>
      <tbody>
        @if($attendances->isEmpty())
          <tr>
            <td colspan="7" class="text-center">No data found.</td>
          </tr>
        @else
        @foreach ($attendances as $attendance)
        <tr>
          <td> {{ $attendance->id }} </td>
          <td> {{ $attendance->student->name ?? 'no student' }} </td>
          <td> {{ $attendance->attendance_date }} </td>
          <td> {{ $attendance->course->name ?? 'no course' }} </td>
          <td> {{ $attendance->room->name ?? 'no room' }} </td>
          <td> {{ $attendance->attendance_status }} </td>
          @if(auth()->user()->hasRole($roles[1]->name) || auth()->user()->hasRole($roles->first()->name) || auth()->user()->hasRole($roles[3]->name))
          <td>
            <div>
              <a href="{{ route('attendances.edit',$attendance->id) }}" class="btn btn-sm btn-success me-2"> Edit <i class="fa-solid fa-pen-to-square"></i> </a>
              <form action="{{ route('attendances.destroy', $attendance->id) }}" method="POST" class="d-inline">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this row?')"> Delete <i class="fa-solid fa-trash"></i> </button>
              </form>
          </div>
          </td>
          @endif
        </tr>
        @endforeach
        @endif
      </tbody>
    </table>
    {{ $attendances->links('pagination::bootstrap-5') }}
  </div>
@endsection