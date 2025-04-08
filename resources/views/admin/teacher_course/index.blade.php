@extends('layouts.app')
@section('title', 'Teacher Courses')
@section('content')
  <div class="container d-flex align-items-center justify-content-between">
    <h2 class="d-inline text-uppercase"> Teachers' courses</h2>
    <div class="d-flex align-items-center justify-content-center gap-2">
      @if(auth()->user()->hasRole($roles[1]->name) || auth()->user()->hasRole($roles->first()->name))
      <a href="{{ route('teachercourses.create') }}" class="btn btn-primary my-2"><i class="fas fa-plus"></i> Add new</a>
      <form action="{{route('teachercourses.import')}}" method="POST" enctype="multipart/form-data">
          @csrf
          <input type="file" name="teachercourses" id="teachercourses" class="form-control-sm" required>
          <button type="submit" class="btn btn-primary my-2" title="Import"><i class="fa-solid fa-upload"></i></button>
      </form>
      <a href="{{ route('teachercourses.export') }}" class="btn btn-primary my-2" title="Export" onclick="return confirm('Export teacher courses data as an excel file?')"><i class="fa-solid fa-download"></i></a>
      @endif
  </div>
  </div>
  @if(Session('success'))
    <div class="alert alert-success alert-dismissible fade show mt-3" role="alert">
        {{ Session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
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
            <form action="{{route('teachercourses.search')}}" method="GET">
                @csrf
                <div class="input-group">
                    <input type="text" name="search_data" id="search_data" class="form-control" placeholder="Search ...." aria-label="Search" value="{{ request('search_data') }}">
                    <button class="btn btn-outline-secondary" type="submit"><i class="fas fa-search"></i></button>
                </div>
            </form>
        </div>
        <div class="col-2 text-end">
            <form action="{{ route('teachercourses.index') }}" method="GET" class="d-inline">
                @csrf
                <button type="submit" class="btn btn-secondary" title="Show All"><i class="fas fa-sync"></i></button>
            </form>
        </div>
        <div class="col-2 text-end">
          @if(auth()->user()->hasRole($roles[1]->name) || auth()->user()->hasRole($roles->first()->name))
          <form action="{{ route('teachercourses.destroy-all') }}" method="POST" class="d-inline">
              @csrf
              @method('DELETE')
              <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete all teacher courses?')"><i class="fas fa-trash"></i></button>
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
          <th scope="col">Teacher_Name</th>
          <th scope="col">Course</th>
          @if(auth()->user()->hasRole($roles[1]->name) || auth()->user()->hasRole($roles->first()->name))
          <th scope="col">Actions</th>
          @endif
        </tr>
      </thead>
      <tbody>
        @if($teacher_courses->isEmpty())
        <tr>
          <td colspan="4" class="text-center"> No data found </td>
        </tr>
        @else
        @foreach ($teacher_courses as $teacher_course)
        <tr>
          <td> {{ $teacher_course->id ?? 'null' }} </td>
          <td> {{ $teacher_course->teacher->name ?? 'no teacher' }} </td>
          <td> {{ $teacher_course->course->name ?? 'no couse' }} </td>
          @if(auth()->user()->hasRole($roles[1]->name) || auth()->user()->hasRole($roles->first()->name))
          <td>
            <div>
              <a href="{{ route('teachercourses.edit', $teacher_course->id) }}" class="btn btn-sm btn-success me-2"> Edit <i class="fa-solid fa-pen-to-square"></i> </a>
              <form action="{{ route('teachercourses.destroy', $teacher_course->id) }}" method="POST" class="d-inline">
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
    {{ $teacher_courses->links('pagination::bootstrap-5') }}
  </div>
@endsection