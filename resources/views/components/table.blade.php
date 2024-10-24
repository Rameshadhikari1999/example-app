<div class="container">
    <table class="table">
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
            @foreach ($data as $row)
                {{-- <tr>
                    @foreach ($row as $key => $value)
                        <td>{{ $value }}</td>
                    @endforeach
                </tr> --}}
                <tr>
                    <td>{{ $row->id }}</td>
                    <td>{{ $row->name }}</td>
                    <td>{{ $row->email }}</td>
                    <td>{{ $row->phone }}</td>
                    <td>{{ $row->address }}</td>
                    <td>
                        @if($row->image)
                            <img src="{{ asset('uploads/test/'.$row->image) }}" alt="image" width="50px" height="50px">
                        @endif
                    </td>
                    <td>
                        <button type="button" class="btn btn-primary editBtn" data-id="{{ $row->id }}" data-bs-toggle="modal" data-bs-target="#exampleModal">Edit</button>
                        <button type="button" class="btn btn-danger deleteBtn" data-id="{{ $row->id }}" data-bs-toggle="modal" data-bs-target="#conformModal">Delete</button>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
