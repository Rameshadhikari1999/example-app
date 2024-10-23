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

    {{-- search box with button  --}}
    <div class="container">
        <form action="/search" method="GET">
            <div class="w-100 flex items-center mb-3">
                <input type="text" class="form-control w-50" name="search" id="search" placeholder="Search.....">
                <button type="submit" class="btn btn-primary">Search</button>
                <a href="/" class="btn btn-danger">Reset</a>
            </div>
        </form>
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
            @if($data->count() == 0)
                <tr>
                    <td colspan="7">No Data Found</td>
                </tr>
            @endif
        </tbody>
    </table>
@endsection



