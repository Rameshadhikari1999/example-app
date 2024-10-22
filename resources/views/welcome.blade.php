{{-- @include('layout.header')
<body> --}}
    @extends('layout.main')


    {{-- Success MSG --}}
    @section('content')
    <div class="container">
        @if (Session::has('success'))
            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                <strong>Success:</strong> {{ Session::get('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
    </div>

    {{-- Error MSG --}}
    <div class="container">
        @if ($errors->any())
            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                <strong>Error:</strong>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
    </div>


    {{-- include Modal  --}}
    @include('modal.modal')

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
                        <a class="edit" href="/edit/{{ $user->id }}">Edit</a>
                        <a class="delete" href="/delete/{{ $user->id }}">Delete</a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection



