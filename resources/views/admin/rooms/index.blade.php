@extends('layouts.app')
@section('title', 'Rooms List')
@section('content')
<div class="container">
    <h2 class="d-inline">Room List</h2>
    <a href="{{ route('rooms.create') }}" class="btn btn-primary my-2 float-end"><i class="fas fa-plus"></i> Add new</a>
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show mt-3" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
</div>
<div class="table-responsive container my-3">
    <table class="table table-hover table-bordered table-striped">
        <thead>
        <tr>
          <th scope="col"></th>
          <th scope="col">ID</th>
          <th scope="col">Building</th>
          <th scope="col">Name</th>
        </tr>
        </thead>
        <tbody>
        @foreach($rooms as $room)
          <tr>
            <td>
                <div class="d-flex">
                    <a href="{{ route('rooms.edit', $room->id) }}" class="btn btn-sm btn-primary m-1"><i class="fas fa-edit"></i></a>
                    <form action="{{ route('rooms.destroy', $room->id) }}" method="POST" class="d-inline m-1">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></button>
                    </form>
                </div>
            </td>
            <th scope="row">{{$room->id}}</th>
            <td>{{$room->building}}</td>
            <td>{{$room->name}}</td>
          </tr>
        @endforeach
        </tbody>
    </table>
</div>
{{ $rooms->links('pagination::bootstrap-5') }}
@endsection
