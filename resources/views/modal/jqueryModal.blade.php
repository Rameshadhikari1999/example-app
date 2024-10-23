@php
    use App\Models\State;
    $states = State::all();
@endphp

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="myForm" enctype="multipart/form-data">
                @csrf
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="modalTitle"></h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="userId" name="id">
                    <div class="mb-3">
                        <label for="name" class="form-label">Name</label>
                        <input type="text" name="name" class="form-control" id="name">
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" name="email" class="form-control" id="email">
                    </div>
                    <div class="mb-3">
                        <label for="phone" class="form-label">Phone</label>
                        <input type="number" name="phone" class="form-control" id="phone">
                    </div>
                    <div class="mb-3">
                        <label for="address" class="form-label">Address</label>
                        <input type="text" name="address" class="form-control" id="address">
                    </div>
                    {{-- select state  --}}
                    <div class="mb-3">
                        <label for="image" class="form-label">Select State</label>
                        <select name="state_id" id="state" class="form-select">
                            <option value="">Select State</option>
                            @foreach ($states as $state)
                                <option value="{{ $state->id }}">{{ $state->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    {{-- select district  --}}
                    <div class="mb-3" id="districtDiv" style="display: none">
                        <label for="image" class="form-label">Select District</label>
                        <select name="district_id" id="district" class="form-select">
                            <option value="">Select District</option>
                        </select>
                    </div>

                    {{-- select municipality  --}}
                    <div class="mb-3" id="municipalityDiv" style="display: none">
                        <label for="image" class="form-label">Select Municipality</label>
                        <select name="municipality_id" id="municipality" class="form-select">
                            <option value="">Select Municipality</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <img src="" name="previousImage" id="previousImage" alt="" width="50px" height="50px" style="display: none">
                    </div>
                    <div class="mb-3">
                        <label for="image" class="form-label">Image</label>
                        <input type="file" name="image" class="form-control" id="image">
                    </div>
                    <div class="mb-3">
                        <img src="" name="currentImage" id="currentImage" alt="" width="50px" height="50px" style="display: none">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" id="submitBtn" class="btn btn-primary">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
$(document).ready(function () {
    $('#state').on('change', function () {
        var stateId = $(this).val();
        $.ajax({
            url: '/getDistricts/' + stateId,
            type: 'GET',
            success: function (data) {
                $('#districtDiv').show();
                $('#district').empty();
                $('#district').append('<option value="">Select District</option>');
                $.each(data, function (index, district) {
                    $('#district').append('<option value="' + district.id + '">' + district.name + '</option>');
                });
            }
        });
    });

    $('#district').on('change', function () {
        var districtId = $(this).val();
        $.ajax({
            url: '/getMunicipalities/' + districtId,
            type: 'GET',
            success: function (data) {
                $('#municipalityDiv').show();
                $('#municipality').empty();
                $('#municipality').append('<option value="">Select Municipality</option>');
                $.each(data, function (index, municipality) {
                    $('#municipality').append('<option value="' + municipality.id + '">' + municipality.name + '</option>');
                });
            }
        });
    });
});
</script>


