@extends('layouts.app')

@section('styles')
<!-- SmartWizard CSS -->
{{-- <link href="https://cdn.jsdelivr.net/npm/smartwizard@6/dist/css/smart_wizard_all.min.css" rel="stylesheet" type="text/css" /> --}}

<!-- Include FilePond Core CSS -->
<link rel="stylesheet" href="https://unpkg.com/filepond@4.32.1/dist/filepond.min.css" />

<!-- Include FilePond Plugin CSS for Image Preview -->
<link rel="stylesheet" href="https://unpkg.com/filepond-plugin-image-preview@4.6.11/dist/filepond-plugin-image-preview.min.css" />
<link rel="stylesheet" href="{{ asset('assets/parsley-plugin/style.css') }}">
{{-- <style>
    body {
        font-size: 12px !important;
    }
    .log_btn {
        background-color: #05445E;
        transition: 0.7s;
        color: #fff;
    }
    .log_btn:hover {
        background-color: #189AB4;
        color: #fff;
    }
    .sw-theme-arrows>.nav .nav-link.active {
        --sw-anchor-active-primary-color: #5bc0de;
    }
    .sw-theme-arrows > .nav .nav-link.default {
        cursor: pointer;
    }
    .sw>.nav .nav-link:active, .sw>.nav .nav-link:focus, .sw>.nav .nav-link:hover {
        text-decoration: none;
    }
    .sw-theme-arrows>.nav {
        overflow: hidden;
        border-bottom: 1px solid #eee;
    }
    .sw>.nav {
        display: flex;
        flex-wrap: wrap;
        list-style: none;
        padding-left: 0;
        margin-top: 0;
        margin-bottom: 0;
    }
    .sw.sw-justified>.nav>li {
        background-color: #F8F8F8;
    }
    .sw>.nav .nav-link {
        display: block;
        padding: .5rem 1rem;
        text-decoration: none;
    }
    .nav-link {
        display: block;
        padding: .5rem 1rem;
    }
    .list-group {
        height: 300px;
        background-color: skyblue;
        /* width: 200px; */
        overflow-y: scroll;
    }.sw-theme-arrows>.nav .nav-link.active {
        --sw-anchor-active-primary-color: #5bc0de;
    }
    .filepond--root {
        max-width: 80%;
    }
</style> --}}
@endsection

@section('content')

<form action="{{ route('update.detail.edit', $property->code) }}" method="post" data-parsley-validate enctype="multipart/form-data">
    @csrf

    <div class="mt-5">
        <div class="container">
            <div id="smartwizard" class="bg-white main2 sw sw-theme-arrows sw-justified" style="height: auto;">

                <ul class="nav">
                    <li class="nav-item">
                        <a class="nav-link active" href="#step-1">
                            <strong>Building Info</strong>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="#step-4">
                            <strong>Landlord Details</strong>
                        </a>
                    </li>
                </ul>

                <div class="tab-content" style="height: auto;">
                    <div id="step-1" class="tab-pane" role="tabpanel" aria-labelledby="step-1" style="position:     static; left: auto; display: block;">
                        <h3>Building Info</h3>
                        <div class="row">
                            <div class="col-6">
                                <label for="">Code</label>
                                <input type="text" class="form-control mb-3" placeholder="Code" id="code" name="code" required="" value="{{ $property->code }}" readonly>
                                <div id="outputC"></div>
                            </div>
                            <div class="col-6">
                                <label for="">District</label>
                                    <select name="district" id="district" class="form-control mb-3" autocomplete="off">
                                        <option selected disabled>District</option>
                                        @foreach ($districts as $district)
                                            <option value="{{ $district }}" {{ $property->district == $district ? 'selected' : '' }}>
                                                {{ $district }}
                                            </option>
                                        @endforeach
                                    </select>
                            </div>
                        </div>

                        <div>
                            <label for="">Building</label>
                            <input type="text" id="building" class="form-control mb-3" placeholder="Building name" name="building" autocomplete="off" required="" value="{{ $property->building }}">
                            <div id="outputB" class=""></div>
                        </div>
                        <div>
                            <label for="">Address</label>
                            <input type="text" id="address" class="form-control mb-3" placeholder="Address" name="street" value="{{ $property->street }}">
                        </div>
                        <div>
                            <label for="">Year</label>
                            <input type="text" id="year" class="form-control mb-3" placeholder="Year" name="year" value="{{ $property->year }}"> 
                        </div>


                        <div class="row">
                            <div class="col-6">
                                <label for="">Block</label>
                                <input type="text" class="form-control mb-3" placeholder="Block" name="block" autocomplete="off" value="{{ $property->block }}">
                            </div>
                            <div class="col-6">
                                <label for="">Floor</label>
                                <input type="text" class="form-control mb-3" placeholder="Floor" name="floor" autocomplete="off" value="{{ $property->floor }}">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-6">
                                <label for="">Flat</label>
                                <input type="text" class="form-control mb-3" placeholder="Flat" name="flat" autocomplete="off" value="{{ $property->flat }}">
                            </div>
                            <div class="col-6">
                                <label for="">Room Number</label>
                                <input type="number" class="form-control mb-3" placeholder="No of Rooms" name="no_rooms" id="no_rooms" value="{{ $property->no_room }}">
                            </div>
                        </div>
                        <div class="mt-2 mb-1">
                            <p class="mb-0">Room Display By</p>
                            <div class="custom-control custom-radio custom-control-inline">
                                <input type="radio" id="customRadioInline1" name="display" class="custom-control-input" value="alp" data-parsley-multiple="display" {{ $property->display_by == 'alp' ? 'checked' : '' }}>
                                <label class="custom-control-label" for="customRadioInline1">A,B,C,D...</label>
                            </div>
                            <div class="custom-control custom-radio custom-control-inline">
                                <input type="radio" id="customRadioInline2" name="display" class="custom-control-input" value="num" data-parsley-multiple="display" {{ $property->display_by == 'num' ? 'checked' : '' }}>
                                <label class="custom-control-label" for="customRadioInline2">1,2,3,4...</label>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-6">
                                <label for="">Cargo Lift</label>
                                <input type="text" class="form-control mb-3" placeholder="Cargo Lift" name="cargo_lift" id="cargo_lift" value="{{ $property->cargo_lift }}">
                            </div>
                            <div class="col-6">
                                <label for="">Customer Lift</label>
                                <input type="text" class="form-control mb-3" placeholder="Customer Lift" name="customer_lift" id="customer_lift" value="{{ $property->customer_lift }}">
                            </div>
                            <div class="col-6">
                                <label for="" class="d-block">24 hour</label>
                                <select id="" name="tf_hr" class="form-control mb-4">
                                    <option value="Yes" {{ $property->tf_hr == 'Yes' ? 'selected' : '' }}>Yes</option>
                                    <option value="No" {{ $property->tf_hr == 'No' ? 'selected' : '' }}>No</option>
                                </select>
                            </div>
                            <div class="col-6 mb-4">
                                <div class="form-group form-check">
                                    <input type="checkbox" class="form-check-input" name="individual" value="Yes" id="exampleCheck1" data-parsley-multiple="individual" {{ $property->individual == 'Yes' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="exampleCheck1">Individual</label>
                                </div>
                                <div class="form-group form-check">
                                    <input type="checkbox" class="form-check-input" name="separate" value="Yes" id="exampleCheck2" data-parsley-multiple="separate" {{ $property->separate == 'Yes' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="exampleCheck2">Separate</label>
                                </div>
                            </div>
                            <div class="col-6">
                                <label for="">Car Park</label>
                                <input type="text" class="form-control mb-3" placeholder="Car Park" name="car_park" id="car_park" autocomplete="off" value="{{ $property->car_park }}">
                            </div>
                            <div class="col-6">
                                <label for="">Number of Floors</label>
                                <input type="number" class="form-control mb-3" placeholder="Number of Floors" name="num_floors" id="num_floors" value="{{ $property->num_floors }}">
                            </div>
                            <div class="col-6">
                                <label for="">Ceiling height</label>
                                <input type="text" class="form-control mb-3" placeholder="Ceiling height" name="ceiling_height" id="ceiling_height" autocomplete="off" value="{{ $property->ceiling_height }}">
                            </div>
                            <div class="col-6">
                                <label for="">Air Conditioning System</label>
                                <input type="text" class="form-control mb-3" placeholder="Air Conditioning System" name="air_con_system" id="air_con_system" value="{{ $property->air_con_system }}">
                            </div>
                            <div class="col-6">
                                <label for="">Building Loading</label>
                                <input type="text" class="form-control mb-3" placeholder="Building Loading" name="building_loading" id="building_loading" autocomplete="off" value="{{ $property->building_loading }}">
                            </div>

                            <div class="col-12">
                                <label for="">Enter Password</label>
                                <input type="text" class="form-control mb-3" placeholder="Entry Password" name="entry_password" value="{{ $property->enter_password }}">
                            </div>
                            {{-- <div class="col-12 mb-2">
                                <textarea name="admin_comment" class="form-control" id="" cols="30" rows="3" placeholder="Admin Comment" readonly=""></textarea>
                            </div>
                            <div class="col-12 mt-2">
                                <textarea name="admin_comment" class="form-control" id="" cols="30" rows="3" placeholder="Admin Comment"></textarea>
                            </div> --}}
                            <div class="col-12 mt-2">
                                <button type="submit" name="submit" class="btn btn-block font-weight-bold log_btn btn-lg mt-4">SUBMIT</button>
                            </div>

                            <div class="col-12 mt-4">
                                <input id="tempId" name="tempId" type="hidden" value="{{ $tempId }}">
                                {{-- FIle Pond --}}
                                <input type="file" class="filepond" name="filepond" multiple />
                            </div>

                        </div>

                        <button type="submit" name="submit" class="btn btn-block font-weight-bold log_btn btn-lg mt-4">SUBMIT</button>
                    </div>
                    <div id="step-4" class="tab-pane" role="tabpanel" aria-labelledby="step-4" style="display: none;">
                        <h3>Landlord Details</h3>
                        <div class="row">
                            <div class="col-6">
                                <label for="">Contact 1</label>
                                <input type="text" class="form-control mb-3" placeholder="Contact 1" name="contact1" value="{{ $property->contact1 }}">
                            </div>
                            <div class="col-6">
                                <label for="">Number 1</label>
                                <input type="text" class="form-control mb-3" placeholder="Number 1" name="number1" value="{{ $property->number1 }}">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-6">
                                <label for="">Contact 2</label>
                                <input type="text" class="form-control mb-3" placeholder="Contact 2" name="contact2" value="{{ $property->contact2 }}">
                            </div>
                            <div class="col-6">
                                <label for="">Number 2</label>
                                <input type="text" class="form-control mb-3" placeholder="Number 2" name="number2" value="{{ $property->number2 }}">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-6">
                                <label for="">Contact 3</label>
                                <input type="text" class="form-control mb-3" placeholder="Contact 3" name="contact3" value="{{ $property->contact3 }}">
                            </div>
                            <div class="col-6">
                                <label for="">Number 3</label>
                                <input type="text" class="form-control mb-3" placeholder="Number 3" name="number3" value="{{ $property->number3 }}">
                            </div>
                        </div>
                        <label for="">Landlord Name</label>
                        <input type="text" class="form-control mb-3" placeholder="Landlord Name" name="landlord_name" value="{{ $property->landlord_name }}">

                        <label for="">Management Company</label>
                        <input type="text" class="form-control mb-3" placeholder="Management Company" name="management_company" value="{{ $property->management_company }}">

                        <label for="">Bank</label>
                        <input type="text" class="form-control mb-3" placeholder="Bank" name="bank" value="{{ $property->bank }}">

                        <label for="">Bank Account</label>
                        <input type="text" class="form-control mb-3" placeholder="Bank account" name="bank_account" value="{{ $property->bank_acc }}">

                        <label for="">Remark</label>
                        <textarea name="remark" class="form-control mb-3" placeholder="Remark" id="" cols="30" rows="5">{{ $property->remarks }}</textarea>
                        <button type="submit" name="submit" class="btn btn-block font-weight-bold log_btn btn-lg mt-4">SUBMIT</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- </form> -->
</form>

@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/smartwizard@6/dist/js/jquery.smartWizard.min.js" type="text/javascript"></script>

<!-- include FilePond library -->
<script src="https://unpkg.com/filepond/dist/filepond.min.js"></script>

<!-- include FilePond plugins -->
<script src="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.min.js"></script>

<!-- include FilePond jQuery adapter -->
<script src="https://unpkg.com/jquery-filepond/filepond.jquery.js"></script>
<script src="{{ asset('assets/parsley-plugin/script.js') }}"></script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const propertyCode = "{{ $property->code }}";
        const tempId = $('#tempId').val();
        const fileInput = document.querySelector('.filepond');

        let removedImageIds = [];
        const submitButtons = document.querySelectorAll('button[name="submit"]');

        FilePond.registerPlugin(FilePondPluginImagePreview);

        const pond = FilePond.create(fileInput, {
            allowMultiple: true,
            allowReorder: true,
            server: {
                process: {
                    url: '/upload-images',
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    ondata: (formData) => {
                        formData.append('temp_id', tempId);
                        return formData;
                    },
                    onerror: (response) => {
                        console.error('File upload error:', response);
                        alert('Failed to upload file. Please try again.');
                    }
                },
                revert: {
                    url: '/delete-image',
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    ondata: (formData) => {
                        formData.append('property_code', propertyCode);
                        return formData;
                    },
                    onerror: (response) => {
                        console.error('Error during file revert:', response);
                        alert('Failed to delete file. Please try again.');
                    }
                },
                load: (source, load) => {
                    fetch(source)
                        .then(response => response.blob())
                        .then(load);
                }
            }
        });

        let uploadingCount = 0;
        let fetchedCount = 0; 

        function updateSubmitButtons() {
            submitButtons.forEach(button => {
                if (uploadingCount > 0) {
                    button.disabled = true;
                    button.textContent = `Uploading. ${uploadingCount} left`;
                } else {
                    button.disabled = false;
                    button.textContent = 'SUBMIT';
                }
            });
        }

        fetch(`/get-property-images/${propertyCode}`)
            .then(response => response.json())
            .then(images => {
                fetchedCount = images.length;
                images.forEach(image => {
                    pond.addFile(image.source, { type: 'local' })
                        .catch(error => {
                            console.error('Error adding existing file:', error);
                        });
                        // console.log(image);
                });
            })
            .catch(error => {
                console.error('Error fetching images:', error);
            });

            

        pond.on('addfile', (error, file) => {
            if (!error && !file.serverId) { 
                uploadingCount++;
                updateSubmitButtons();
            }
        });

        pond.on('removefile', (error, file) => {
            if (!error) {
                let imageId = file.serverId;
                console.log(imageId);
                removedImageIds.push(imageId);
            }
        });

        $('form').on('submit', function () {
            $('<input>')
                .attr({
                    type: 'hidden',
                    name: 'removed_images',
                    value: JSON.stringify(removedImageIds)
                })
                .appendTo(this);
        });

        pond.on('processfile', () => {
            uploadingCount--;
            updateSubmitButtons();
        });

        pond.on('removefile', (error, file) => {
            if (!error && !file.serverId) { 
                if (uploadingCount > 0) {
                    uploadingCount--;
                }
                updateSubmitButtons();
            }
        });

        pond.on('processfileerror', () => {
            alert('An error occurred during file upload. Please check your files and try again.');
        });
    });

    $(document).ready(function() {
        var activeTab = localStorage.getItem('activeTab') || 0;

        $('#smartwizard').smartWizard({
            selected: parseInt(activeTab),
            theme: 'arrows',
            showStepURLhash: false,
            autoAdjustHeight: false,
            anchorSettings: {
                enableAllAnchors: true,
                anchorClickable: true 
            }
        });

        $('.sw>.nav .nav-link').on('click', function(e) {
            e.preventDefault();
            const stepIndex = $(this).parent().index();
            $('#smartwizard').smartWizard("goToStep", stepIndex);
        });

        var activeColor = '#5bc0de'; 
        var doneColor = '#5cb85c'; 
        var nonActiveTextColor = '#007bff';

        function updateTabColors() {
            $('#smartwizard .nav-link').each(function() {
                if ($(this).hasClass('done')) {
                    // Apply done color using CSS variable override
                    $(this).css({
                        'background-color': doneColor,
                        'color': 'white',
                        'border-left': 'none',
                        '--sw-anchor-done-primary-color': doneColor 
                    });
                } else if ($(this).hasClass('active')) {
                    $(this).css({
                        'background-color': activeColor,
                        // '--sw-anchor-active-primary-color': activeColor,
                        'color': 'white',
                        'border-left': 'none'
                    });
                } else {
                    $(this).css({
                        'background-color': 'transparent',
                        'color': nonActiveTextColor,
                        'border-left': 'none'
                    });
                    $(this).find('.sw-icon').css({
                        'color': 'transparent'
                    });
                }
            });
        }

        // Initial color update
        updateTabColors();

        // Update colors on step change
        $('#smartwizard').on("showStep", function(e, anchorObject, stepIndex) {
            localStorage.setItem('activeTab', stepIndex);
            updateTabColors(); // Apply colors each time the step changes
        });
    });

    $(document).ready(function() {
        $('#code').keyup(function() {
            let code = $(this).val();
            if (code != '') {
                $.ajax({
                    type: "POST",
                    url: "/check-code",
                    data: {
                        code: code,
                        _token: $('meta[name="csrf-token"]').attr('content')
                    },
                    dataType: "html",
                    success: function(data) {
                        $('#outputC').fadeIn();
                        $('#outputC').html(data);
                    }
                });
            } else {
                $('#outputC').fadeOut();
                $('#outputC').html("");
            }
        });

        $('#outputC').parent().on('click', 'li', function() {
            $('#code').val($(this).text());
            $('#outputC').fadeOut();
        });
    });

    $(document).ready(function() {
        $('#building').keyup(function () {
            let building = $(this).val();
            if (building !== '') {
                $.ajax({
                    type: "POST",
                    url: "{{ route('search.building') }}",
                    data: {
                        _token: '{{ csrf_token() }}',
                        building: building
                    },
                    success: function (data) {
                        $('#outputB').fadeIn();
                        $('#outputB').html(data);
                    }
                });
            } else {
                $('#outputB').fadeOut();
                $('#outputB').html("");
            }
        });

        $('#outputB').parent().on('click', 'li', function() {
            let text1 = $(this).text();
            $('#building').val(text1);
            $.ajax({
                type: "POST",
                url: "{{ route('get.building.info') }}", 
                data: {
                    _token: '{{ csrf_token() }}',
                    text1: text1
                },
                dataType: "json",
                success: function(data) {
                    // console.log(data);
                    if (data.address_chinese) {
                        $('#address').val(data.address_chinese);
                    }
                    if (data.year) {
                        $('#year').val(data.year);
                    }
                    if(data.propertyLatest.num_floors){
                        $('#num_floors').val(data.propertyLatest.num_floors);
                    }
                    if(data.propertyLatest.ceiling_height){
                        $('#ceiling_height').val(data.propertyLatest.ceiling_height);
                    }
                    if(data.propertyLatest.air_con_system){
                        $('#air_con_system').val(data.propertyLatest.air_con_system);
                    }
                    if(data.propertyLatest.building_loading){
                        $('#building_loading').val(data.propertyLatest.building_loading);
                    }
                    if(data.propertyLatest.car_park){
                        $('#car_park').val(data.propertyLatest.car_park);
                    }
                    if(data.propertyLatest.customer_lift){
                        $('#customer_lift').val(data.propertyLatest.customer_lift);
                    }
                    if(data.propertyLatest.cargo_lift){
                        $('#cargo_lift').val(data.propertyLatest.cargo_lift);
                    }
                },
                error: function() {
                    console.error('Building not found or error occurred');
                }
            });

            // Hide the dropdown after selection
            $('#outputB').fadeOut();
        });
    });
</script>
@endsection