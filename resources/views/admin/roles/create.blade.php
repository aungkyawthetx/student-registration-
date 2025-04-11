@extends('layouts.app')
@section('title', 'Add New Role')
@section('content')
    <div class="card">
        <div class="card-header bg-transparent">
            <h4>Add New Role</h4>
        </div>
        <div class="card-body">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show mt-2" role="alert">
                    {{ session('successAlert') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show mt-2" role="alert">
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            <form action="{{ route('roles.store') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="name" class="form-label ms-2"><i class="fas fa-user-tag"></i> Role Name</label>
                    <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" placeholder="Enter role name" value="{{ old('name') }}">
                    @error('name')
                        <span class="text-danger"><small>{{ $message }}</small></span>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="description" class="form-label ms-2"><i class="fas fa-align-left"></i> Description</label>
                    <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" placeholder="Enter role description">{{ old('description') }}</textarea>
                    @error('description')
                        <span class="text-danger"><small>{{ $message }}</small></span>
                    @enderror
                </div>
                <button type="submit" class="btn btn-primary"><i class="fas fa-plus"></i> Add</button>
            </form>
        </div>
    </div>
@endsection
