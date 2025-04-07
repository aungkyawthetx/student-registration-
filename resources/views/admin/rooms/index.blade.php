@extends('layouts.app')
@section('title', 'Rooms List')
@section('content')
    <div class="container d-flex align-items-center justify-content-between">
        <h2 class="d-inline text-uppercase">Room list</h2>
        <a href="{{ route('rooms.create') }}" class="btn btn-primary"> Add New <i class="fas fa-plus"></i> </a>
    </div>
    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show mt-3" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif
    <div class="table-responsive container my-3">
        <table class="table table-hover table-bordered table-striped text-center">
            <thead>
            <tr>
                <th scope="col">ID</th>
                <th scope="col">Building</th>
                <th scope="col">Name</th>
                <th scope="col">Actions</th>
            </tr>
            </thead>
            <tbody>
            @foreach($rooms as $room)
            <tr>
                <td scope="row">{{$room->id}}</td>
                <td>{{$room->building}}</td>
                <td>{{$room->name}}</td>
                <td>
                    <div>
                        <a href="{{ route('rooms.edit', $room->id) }}" class="btn btn-sm btn-success me-2"> Edit <i class="fas fa-edit"></i></a>
                        <form action="{{ route('rooms.destroy', $room->id) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this row?')"> Delete <i class="fas fa-trash"></i></button>
                        </form>
                    </div>
                </td>
            </tr>
            @endforeach
            </tbody>
        </table>
    </div>
    {{ $rooms->links('pagination::bootstrap-5') }}
@endsection
