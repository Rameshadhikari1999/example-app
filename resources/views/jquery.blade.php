@extends('layout.main')
<script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
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
    <button type="button" id="addNewBtn" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
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
                    <button type="button" class="btn btn-primary editBtn" data-id="{{ $user->id }}" data-bs-toggle="modal" data-bs-target="#exampleModal">Edit</button>
                    <button type="button" class="btn btn-danger deleteBtn" data-id="{{ $user->id }}" data-bs-toggle="modal" data-bs-target="#conformModal">Delete</button>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
@endsection

{{-- add and update function  --}}
<script>
    $(document).ready(function () {

        // Function to open the modal for adding a new user
        $('#addNewBtn').on('click', function () {
            $('#modalTitle').text('Add New Item');
            $('#submitBtn').text('Add');
            $('#myForm')[0].reset();
            $('#userId').val('');
            $('#exampleModal').modal('show');
        });

        // Function to open the modal for updating an existing user
        $('.editBtn').on('click', function () {
            var id = $(this).data('id');
            $.ajax({
                url: '/jquery/edit/' + id,
                method: 'GET',
                success: function (response) {
                    $('#modalTitle').text('Update Item');
                    $('#submitBtn').text('Update');
                    $('#name').val(response.name);
                    $('#email').val(response.email);
                    $('#phone').val(response.phone);
                    $('#address').val(response.address);
                    $('#userId').val(response.id);
                    $('#exampleModal').modal('show');
                }
            });
        });

        // Function to handle form submission for both Add and Update
        $('#submitBtn').click(function (e) {
            e.preventDefault();

            var form = $('#myForm')[0];
            var formData = new FormData(form);
            var id = $('#userId').val();

            var url = (id) ? '/jquery/update/' + id : 'jquery/store'; // Add if ID is empty, else Update
            var method = (id) ? 'POST' : 'POST'; // Use POST for both, but adjust server logic for update

            $.ajax({
                url: url,
                method: method,
                data: formData,
                processData: false,
                contentType: false,
                dataType: "json",
                success: function (response) {
                    $('#errorList').empty();
                    $('#errorMessage').hide();

                    if (response.message) {
                        $('#successText').text(response.message);
                        $('#successMessage').show();

                        $('#exampleModal').modal('hide');
                        $('#myForm')[0].reset();
                        location.reload(); // Reload the page to reflect changes
                    }
                },
                error: function (xhr) {
                    if (xhr.responseJSON.errors) {
                        $('#errorMessage').show();
                        var errors = xhr.responseJSON.errors;
                        $.each(errors, function (key, value) {
                            $('#errorList').append('<li>' + value[0] + '</li>');
                        });
                    } else {
                        console.log(xhr.responseText);
                    }
                }
            });
        });
    });
</script>



{{-- delete function  --}}
<script>
    $(document).ready(function () {
        var userId;

        $('.deleteBtn').on('click', function () {
            userId = $(this).data('id');
        });


        $('#confirmDeleteBtn').on('click', function () {
            // console.log(userId, 'user id');
            $.ajax({
                url: "{{ url('/jquery/delete/') }}/" + userId,
                method: 'DELETE',
                data: {
                    "_token": "{{ csrf_token() }}"
                },
                success: function (response) {

                    $('#conformModal').modal('hide');
                    $('#successMessage').show();
                    $('#successText').text(response.message);
                    location.reload();
                },
                error: function (error) {
                    console.error(error);
                }
            });
        });
    });
</script>
