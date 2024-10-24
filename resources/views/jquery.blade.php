@extends('layout.main')
<script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
@section('content')

<div class="container">
    <!-- Success Message -->
    {{-- <div id="successMessage" class="alert alert-success alert-dismissible fade show z-50" role="alert" style="display: none;">
        <strong id="msgTitle"></strong> <span id="successText"></span>
        <button type="button" class="btn-close" id="closeAlertBtn" aria-label="Close"></button>
    </div> --}}
    <div id="successMessage" class="alert alert-success alert-dismissible fade show position-fixed w-25" role="alert" style=" display: none; top: 5%; right: 0%; transform: translateX(-0%); z-index: 2050;">
        <strong id="msgTitle"></strong> <span id="successText"></span>
        <button type="button" class="btn-close" id="closeAlertBtn" aria-label="Close"></button>
    </div>


    <!-- Error Message -->
    <div id="errorMessage" class="alert alert-danger alert-dismissible fade show position-fixed w-25" role="alert" style="display: none; top: 5%; right: 0%; transform: translateX(-0%); z-index: 2050;">
        <strong>Error:</strong>
        <ul id="errorList"></ul>
        <button type="button" class="btn-close" id="closeErrorAlertBtn" aria-label="Close"></button>
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

{{-- search box and button  --}}
<div class="container">
    <div class="input-group mb-3 w-25">
        <input type="text" class="form-control" id="searchInput" placeholder="Search...">
    </div>
</div>

{{-- Table Data --}}
{{-- <table>
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
        <tr id="noData" style="display: none">
            <td colspan="7">Data Not found</td>
        </tr>
    </tbody>
</table> --}}
@include('components.table')
<div class="container my-3">
    {{-- {!! $data->appends(Request::all())->links() !!} --}}
</div>
@endsection

{{-- add and update function  --}}
<script>
    $(document).ready(function () {


        // handle image upload
        $('#image').change(function(e) {
            var reader = new FileReader();
            reader.onload = function(e) {
                $('#currentImage').show();
                $('#currentImage').attr('src', e.target.result);
            }
            reader.readAsDataURL(this.files[0]);
        });

        // handle showSuccessMessage function
        function showSuccessMessage(message) {
        $('#successText').text(message);
        $('#successMessage').show();
    }

    // handle closeSuccessMessage function
    $('#closeAlertBtn').click(function() {
        $('#successMessage').hide();
    });

    // handle closeErrorAlert function
    $('#closeErrorAlertBtn').click(function() {
        $('#errorMessage').hide();
    })

        // handle search by name email or phone
        $('#searchInput').on('keyup', function () {
            var value = $(this).val().toLowerCase();
            var visibleRows = 0;
            $('tbody tr').filter(function () {
                var isVisible = $(this).text().toLowerCase().indexOf(value) > -1;
                $(this).toggle(isVisible);
                if (isVisible) {
                    visibleRows++;
                }
                if (visibleRows === 0) {
                    $('#noData').show();
                } else {
                    $('#noData').hide();
                }
            });
        })

        // Function to open the modal for adding a new user
        $('#addNewBtn').on('click', function () {
            $('#modalTitle').text('Add New Item');
            $('#submitBtn').text('Add');
            $('#myForm')[0].reset();
            $('#userId').val('');
            $('#previousImage').hide();
            $('#currentImage').hide();
            $('#districtDiv').hide();
            $('#municipalityDiv').hide();
            $('#exampleModal').modal('show');
        });

        // Function to open the modal for updating an existing user
        $('.editBtn').on('click', function () {
            var id = $(this).data('id');
            $.ajax({
                url: '/jquery/edit/' + id,
                method: 'GET',
                success: function (response) {
                    $('#districtDiv').hide();
                    $('#municipalityDiv').hide();
                    $('#modalTitle').text('Update Item');
                    $('#submitBtn').text('Update');
                    $('#name').val(response.name);
                    $('#email').val(response.email);
                    $('#phone').val(response.phone);
                    $('#address').val(response.address);
                    $('#previousImage').show();
                    $('#previousImage').attr('src', '/uploads/test/' + response.image);
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
            var url = (id) ? '/jquery/update/' + id : 'jquery/store';
            var method = (id) ? 'POST' : 'POST';

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
                        $('#successMessage').addClass('alert-success');
                        $('#successMessage').removeClass('alert-danger');
                        $('#msgTitle').text('Success');
                        showSuccessMessage(response.message);
                        $('#exampleModal').modal('hide');
                        $('#myForm')[0].reset();
                    }
                    else{
                        $('#successMessage').removeClass('alert-success');
                        $('#successMessage').addClass('alert-danger');
                        $('#msgTitle').text('Error');
                        showSuccessMessage(response.error);
                    }
                },
                error: function (xhr) {
                    if (xhr.responseJSON.errors) {
                        $('#errorMessage').show();
                        $('#errorList').empty();
                        var errors = xhr.responseJSON.errors;
                        $.each(errors, function (key, value) {
                            $('#errorList').append('<li>' + value[0] + '</li>');
                        });
                        // $('#exampleModal').modal('hide');
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
                    // location.reload();
                },
                error: function (error) {
                    console.error(error);
                }
            });
        });
    });
</script>
