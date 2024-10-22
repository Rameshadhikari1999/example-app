@extends('layout.main')

@section('content')

<div class="container">
    <!-- Success Message -->
    <div id="successMessage" class="alert alert-success alert-dismissible fade show" role="alert" style="display: none;">
        <strong>Success:</strong> <span id="successText"></span>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>

    <!-- Error Message -->
    <div id="errorMessage" class="alert alert-warning alert-dismissible fade show" role="alert" style="display: none;">
        <strong>Error:</strong>
        <ul id="errorList"></ul>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
</div>


{{-- include Modal  --}}
@include('modal.jqueryModal')
@include('modal.conform')

<div class="container">
    <h2>Using JQuery operations</h2>
</div>

{{-- Add Button --}}
<div class="btn-container">
    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
        Add
    </button>
</div>

{{-- Table Data --}}
<table>
    <thead>
        <tr>
            <th>S/N</th>
            <th>Name</th>
            <th>Email</th>
            <th>Phone</th>
            <th>Address</th>
            <th>Image</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($data as $user)
            <tr>
                <td>{{ $user->id }}</td>
                <td>{{ $user->name }}</td>
                <td>{{ $user->email }}</td>
                <td>{{ $user->phone }}</td>
                <td>{{ $user->address }}</td>
                <td>
                    @if($user->image)
                        <img src="{{ asset('uploads/test/'.$user->image) }}" alt="image" width="50px" height="50px">
                    @endif
                </td>
                <td>
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#editModal">Edit</button>
                    <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#conformModal">Delete</button>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
@endsection
