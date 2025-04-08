@extends('layouts.app')
@section('title', 'Enrollments')
@section('content')
    <div class="container d-flex align-items-center justify-content-between">
        <h2 class="text-uppercase">Enrollment list</h2>
        <div class="d-flex align-items-center justify-content-center gap-2">
          @if(auth()->user()->hasRole($roles[1]->name) || auth()->user()->hasRole($roles->first()->name))
          <a href="{{ route('enrollments.create') }}" class="btn btn-primary my-2"><i class="fas fa-plus"></i> Add new</a>
          <form action="{{route('enrollments.import')}}" method="POST" enctype="multipart/form-data">
              @csrf
              <input type="file" name="enrollments" id="enrollments" class="form-control-sm" required>
              <button type="submit" class="btn btn-primary my-2" title="Import"><i class="fa-solid fa-upload"></i></button>
          </form>
          <a href="{{ route('enrollments.export') }}" class="btn btn-primary my-2" title="Export" onclick="return confirm('Export enrollments data as an excel file?')"><i class="fa-solid fa-download"></i></a>
          @endif
      </div>
    </div>
    @if(session('successAlert'))
            <div class="alert alert-success alert-dismissible fade show mt-3" role="alert">
                {{ session('successAlert') }}
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
                  <form action="{{route('enrollments.search')}}" method="GET">
                      @csrf
                      <div class="input-group">
                          <input type="text" name="search_data" id="search_data" class="form-control" placeholder="Search ...." aria-label="Search" value="{{ request('search_data') }}">
                          <button class="btn btn-outline-secondary" type="submit"><i class="fas fa-search"></i></button>
                      </div>
                  </form>
              </div>
              <div class="col-2 text-end">
                  <form action="{{ route('enrollments.index') }}" method="GET" class="d-inline">
                      @csrf
                      <button type="submit" class="btn btn-secondary" title="Show All"><i class="fas fa-sync"></i></button>
                  </form>
              </div>
              <div class="col-2 text-end">
                @if(auth()->user()->hasRole($roles[1]->name) || auth()->user()->hasRole($roles->first()->name))
                <form action="{{ route('enrollments.destroy-all') }}" method="POST" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete all enrollments?')"><i class="fas fa-trash"></i></button>
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
              <th scope="col">Student_Name</th>
              <th scope="col">Course_Name</th>
              <th scope="col">Enrollment_Date</th>
              @if(auth()->user()->hasRole($roles[1]->name) || auth()->user()->hasRole($roles->first()->name))
              <th scope="col">Actions</th>
              @endif
            </tr>
            </thead>
            <tbody>
            @if($enrollments->isEmpty())
              <tr>
                <td colspan="5" class="text-center"> No data found </td>
              </tr>
            @else
              @foreach ($enrollments as $enrollment)
              <tr>
                <td> {{ $enrollment->id }} </td>
                <td> {{ $enrollment->student->name }} </td>
                <td> {{ $enrollment->course->name }} </td>
                <td> {{ $enrollment->date }} </td>
                @if(auth()->user()->hasRole($roles[1]->name) || auth()->user()->hasRole($roles->first()->name))
                <td>
                  <div>
                    <a href="{{ route('enrollments.edit', $enrollment->id) }}" class="btn btn-sm btn-success me-2"> Edit <i class="fa-solid fa-pen-to-square"></i> </a>
                    <form action="{{ route('enrollments.destroy', $enrollment->id) }}" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this row?')"> Delete <i class="fas fa-trash"></i> </button>
                    </form>
                  </div>
                </td>
                @endif
              </tr>
              @endforeach
              @endif
            </tbody>
        </table>
    </div>
    {{$enrollments->links('pagination::bootstrap-5') }}
@endsection