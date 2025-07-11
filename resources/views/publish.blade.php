@extends('layouts.app')

@section('styles')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<!-- Include FilePond Core CSS -->
<link rel="stylesheet" href="https://unpkg.com/filepond@4.32.1/dist/filepond.min.css" />
<!-- Include FilePond Plugin CSS for Image Preview -->
<link rel="stylesheet" href="https://unpkg.com/filepond-plugin-image-preview@4.6.11/dist/filepond-plugin-image-preview.min.css" />
{{-- <style>
    p {
        margin: 0;
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
    .share-list .img-overflow {
        overflow: hidden;
        height: 95px;
    }
    .share-list .img-overflow img {
        height: 100%;
    }
    .share-list img {
        margin-right: 10px;
    }
    .filepond--root {
        max-width: 80%;
    }
    .filepond--drop-label {
        display: none;
    }
    .pencil-wrapper {
        position: absolute;
        right: 24px;
        bottom: 85px;
        z-index: 1000;
        background-color: rgba(255, 255, 255, 0.8);
    }
    .file-border-wrapper {
        position: absolute;
        width: calc(100% - 17px);
        bottom: 10px;
        z-index: 1000;
    }
    .file-border-wrapper .file-label {
        width: calc(100% - 57px);
        margin-bottom: 7px;
    }
    .file-border-wrapper .file-note {
        width: calc(100% - 17px);
    }
    .file-border-wrapper .file-border {
        width: 24px;
        height: 24px;
    }
    input:focus {
        outline: none;
    }
    .form-check-width{
        width: 50%;
    }
</style> --}}
@endsection

@section('content')
<section>
    <div class="container">
        <div class="row">
            <div class="col-12">
                <a class="btn btn-block font-weight-bold log_btn btn-lg mt-4" href="{{ route('clear.share.list') }}">Clear share list and exit</a>
            </div>
        </div>
    </div>
</section>
<section>
    <div class="container">
        <h4>Useful Words</h4>
        <div class="row">
            <div class="col-12 mt-3 mb-3" id="all-controls">
                <select name="words[]" id="words" style="width: 100%; display: none;" multiple tabindex="-1"></select>
            </div>
        </div>
        <textarea id="test"></textarea>
        <ul class="nav nav-tabs" id="myTab" role="tablist">
            <li class="nav-item" id="photos-tab-container" style="display: none;">
                <a class="nav-link active" id="photos-tab" data-toggle="tab" href="#photos" role="tab" aria-controls="photos" aria-selected="true">Photos (<span id="img-count">0</span>)</a>
            </li>
            
            <li class="nav-item" id="listings-tab-container" style="display: none;">
                <a class="nav-link" id="listings-tab" data-toggle="tab" href="#listings" role="tab" aria-controls="listings" aria-selected="false">
                    Listings (<span id="property-count">0</span>)
                </a>
            </li>            
        </ul>
        <div class="tab-content" style="height: auto;">
            <div class="tab-pane active p-3" id="photos" role="tabpanel" aria-labelledby="photos-tab">
                <form id="images_form" action="{{ route('images.shared') }}" method="post">
                    @csrf
                    <input type="hidden" name="action_type" id="actionType">
                    <div class="row">
                        <div class="col-12">
                            <button type="submit" id="pdfButton" name="submit1" class="btn btn-block font-weight-bold log_btn btn-lg mt-4">PDF</button>
                        </div>
                        <div class="col-12">
                            <button type="submit" name="submit" class="btn btn-block font-weight-bold log_btn btn-lg mt-4">Share</button>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <textarea name="comment" class="form-control" id="comment" cols="30" rows="3" placeholder="Comment" spellcheck="false"></textarea>
                        </div>
                    </div>
                    <div class="alert alert-info mt-2" style="display: none" id="listViewAlert">
                        Comments will be visiable in list view use , (comma)  to seprate items for example option 1,option 2 is as:
                        <br>1. option 1<br>1. option 2
                    </div>
                    <div id="bbttnn2" class="d-none">
                        {{-- <p>Comment For <span style="color: blue">開聯A611</span></p>
                        <textarea class="form-control" name="individual_comment_開聯A611"></textarea>
                        <br>
                        <input type="hidden" name="codesArr" value="開聯A611"> --}}
                    </div>
                    <div class="row">
                        <div class="col-12 mt-3 mb-3" id="all-optional-controls">
                            Add Indivisual Comments <input type="checkbox" onchange="document.getElementById('bbttnn2').classList.toggle('d-none')" id="ind_comm_perm" name="ind_comm_perm" class="file-border ">
                            <br class="d-block d-md-none">
                            Add Other Info <input type="checkbox" onchange="document.getElementById('bbttnn').classList.toggle('d-none')" id="show_building_info" name="show_building_info" class="file-border ">
                            <br class="d-block d-md-none">
                            Building Name <input type="checkbox" id="show_building_name" value="0" name="show_building_name" class="file-border ">
                            <br class="d-block d-md-none">
                            Map <input type="checkbox" value="0" id="show_map" name="show_map" class="file-border ">
                            <br class="d-block d-md-none">
                            Show as Listing <input type="checkbox" value="0" id="show_as_list" name="show_as_list" class="file-border "/>
                        </div>
                        <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Select Columns</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">×</span>
                                    </button>
                                </div>
                                <div class="modal-body row px-5" id="checkboxContainer">
                                </div> 
                                <div class="d-flex justify-content-end p-4">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Ok</button>
                                </div>
                                <p id="colerror"></p>
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <button type="button" id="bbttnn" class="btn btn-primary d-none" data-toggle="modal" data-target="#exampleModal">
                                Add more info
                            </button>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12 mt-3 mb-3" id="all-controls">
                            For all photos:
                            comment
                            單位 <input type="checkbox" value="1" name="room_" class="file-border all_control">
                            <br class="d-block d-md-none">
                            呎吋 <input type="checkbox" value="1" name="size_" class="file-border all_control">
                            <br class="d-block d-md-none">
                            價錢 <input type="checkbox" value="1" name="price_" class="file-border all_control">
                            <hr class="d-block d-md-none">
                            label
                            單位 <input type="checkbox" value="1" name="label_room_" class="file-border all_control">
                            <br class="d-block d-md-none">
                            呎吋 <input type="checkbox" value="1" name="label_size_" class="file-border all_control">
                            <br class="d-block d-md-none">
                            價錢 <input type="checkbox" value="1" name="label_price_" class="file-border all_control">
                        </div>
                        <script>
                            
                        </script>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            {{-- FIle Pond --}}
                            <input type="file" class="filepond" name="filepond" multiple />
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <button type="submit" name="submit" class="btn btn-block font-weight-bold log_btn btn-lg mt-4">Share</button>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <button type="submit" name="submit" id="downloadImgBtn" class="btn btn-block font-weight-bold log_btn btn-lg mt-4">Download</button>
                        </div>
                    </div>
                </form>
            </div>
            <div class="tab-pane share-list p-3 " id="listings" role="tabpanel" aria-labelledby="listings-tab">
                <form action="{{ route('properties.shared') }}" method="post">
                    @csrf
                    <input type="radio" id="show_items_y" name="show_items" value="yes">
                    <label for="show_items_y">Show All items</label>
                    <input checked="" type="radio" id="show_items_n" name="show_items" value="no"> 
                    <label for="show_items_n">Show Code only</label>
                    <br><br>
                    <div id="properties-details"></div>
                    <div class="row">
                        <div class="col-12">
                            <textarea name="comment" class="form-control w-100" id="" cols="30" rows="3" placeholder="Comment" spellcheck="false"></textarea>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <input type="submit" class="btn btn-block font-weight-bold log_btn btn-lg mt-4" value="MARK">
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <button class="btn btn-primary position-fixed" id="swipFun" style="bottom: 10px; left: 10px; display: none;">Swip</button>
</section>



@endsection

@section('scripts')
<script>
    var pencilImgUrl = "{{ asset('assets/logos/pencil.svg') }}";
</script>
<script src="{{ asset('assets/filePond/img-preview-input-show.js?v=1') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<!-- include FilePond library -->
<script src="https://unpkg.com/filepond/dist/filepond.min.js"></script>
<!-- include FilePond plugins -->
<script src="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.min.js"></script>
<!-- include FilePond jQuery adapter -->
<script src="https://unpkg.com/jquery-filepond/filepond.jquery.js"></script>

<script src="https://unpkg.com/filepond-plugin-file-poster/dist/filepond-plugin-file-poster.min.js"></script>
<script>
    $(document).ready(function() {
        ShareDetails();
        resetSwipe();

        $('#words').select2({
            tags: true
        });
        $.ajax({
            url: "{{ route('fetch.usefultWords') }}",
            type: "GET",
            success: function(response) {
                if (response.words && response.words.length > 0) {
                    $('#words').empty();
                    response.words.forEach(function(word) {
                        $('#words').append(new Option(word.word, word.word, false, false));
                    });

                    $('#words').trigger('change');
                }
            }
        });

        $('#words').on('select2:select', function(evt) {
            let selectedOption = evt.params.data.element;
            let $selectedOption = $(selectedOption);
            $selectedOption.detach();
            $('#words').append($selectedOption).trigger('change');
            updateCommentBox();
        });

        $('#words').on('select2:unselect', function() {
            updateCommentBox();
        });

        function updateCommentBox() {
            let selectedWords = $('#words').find(':selected').map(function() {
                return $(this).text();
            }).get();

            $('#comment').val(selectedWords.join(', '));
        }


        $('#checkbox-all-columns').on('change', function() {
            $('input[name="building_info[]"]').prop('checked', this.checked);
        });
    });

    function ShareDetails() {
        $.ajax({
            url: "{{ route('share.details') }}",
            type: "GET",
            success: function(response) {
                if (response.comments_codes && response.comments_codes.length > 0) {
                    let codesArray = [];
                    response.comments_codes.forEach(function(item) {
                        if ($(`textarea[name="individual_comment_${item}"]`).length === 0) {
                            let html = `
                                <p>Comment For <span style="color: blue">${item}</span></p>
                                <textarea class="form-control" name="individual_comment_${item}"></textarea>
                                <br>
                            `;
                            $('#bbttnn2').append(html);
                        }
                        $(`textarea[name="individual_comment_${item}"]`).val();

                        codesArray.push(item);
                    });

                    if ($('input[name="codesArr"]').length === 0) {
                        $('#bbttnn2').append(`<input type="hidden" name="codesArr">`);
                    }
                    $('input[name="codesArr"]').val(codesArray.join(','));
                }

                $('#img-count').text(response.images_count);
                $('#property-count').text(response.properties_count);
                if (response.images_count > 0) {
                    $('#photos-tab-container').show();
                } else {
                    $('#photos-tab-container').hide();
                    $('#photos').hide();
                }

                if (response.properties_count > 0) {
                    $('#listings-tab-container').show();
                } else {
                    $('#listings-tab-container').hide();
                    $('#listings-tab').hide();
                }

                if (response.images_count === 0 && response.properties_count > 0) {
                    $('#listings-tab').tab('show');
                    $('#photos').hide();
                } else if (response.images_count > 0) {
                    $('#photos-tab').tab('show');
                }

                $('#properties-details').empty();
                if(response.properties_count > 0){
                    response.properties_data.forEach(property => {
                        let imagesHtml = property.photos.map(photo => `
                            <a href="${photo.image}">
                                <img src="${photo.image}" data-file="${photo.image}">
                            </a>
                        `).join('');

                        let deleteUrl = `{{ route('remove.shared.property', ':id') }}`.replace(':id', property.building_id);
                        let propertyHtml = `
                            <div id="property-row-${property.building_id}" class="row mb-2">
                                <div class="col-2">
                                    <input type="checkbox" class="swipe-check" id="swipe-${property.building_id}">
                                    <a target="_blank" href="property/${property.code}">${property.code}</a>
                                </div>
                                <div class="col-6">
                                    <div class="img-overflow popup-gallery">
                                        ${imagesHtml}
                                    </div>
                                </div>
                                <div class="col-4">
                                    <a href="${deleteUrl}" class="btn btn-danger">Delete</a>
                                </div>
                            </div>
                        `;

                        $('#properties-details').append(propertyHtml);
                    });
                }

                // console.log( response.images_data)
                if (response.images_count > 0) {
                    FilePond.registerPlugin(FilePondPluginImagePreview, FilePondNotePlugin);

                    const inputElement = document.querySelector('.filepond');

                    if (FilePond.find(inputElement)) {
                        FilePond.destroy(inputElement);
                    }
                    FilePond.create(inputElement, {
                        allowMultiple: true,
                        allowReorder: true,
                        files: response.images_data.map(image => ({
                            source: image.image,
                            options: {
                                type: 'local',
                                metadata: {
                                    id: image.id,
                                }
                            }
                        })),
                        server: {
                            load: (source, load, error) => {
                                fetch(source)
                                    .then(res => res.blob())
                                    .then(load)
                                    .catch(err => {
                                        console.error("Failed to load image:", err);
                                        error(err.message);
                                    });
                            }
                        }
                    });

                    $(document).on('FilePond:removefile', '.filepond', function(e) {
                        const imageId = e.detail.file.getMetadata('id');
                        // console.log('Removed Metadata ID:', imageId);

                        $.ajax({
                            url: '/remove-shared-image', 
                            method: 'POST',
                            data: {
                                id: imageId,
                                _token: $('meta[name="csrf-token"]').attr('content')
                            },
                            success: (response) => {
                                console.log('Image removed:', response.message);
                            },
                            error: (xhr) => {
                                console.error('Failed to remove image:', xhr.responseText);
                            }
                        });
                    });

                    $(document).on('FilePond:reorderfiles', '.filepond', function(e) {
                        const reorderedIds = e.detail.items.map(item => item.getMetadata('id'));

                        console.log('Reordered IDs:', reorderedIds);

                        $.ajax({
                            url: '/shared-image-order',
                            method: 'POST',
                            data: {
                                reordered_ids: reorderedIds,
                                _token: $('meta[name="csrf-token"]').attr('content')
                            },
                            success: (response) => {
                                console.log('Order updated:', response.message);
                            },
                            error: (xhr) => {
                                console.error('Failed to update order:', xhr.responseText);
                            }
                        });
                    });

                    // Download function
                    function downloadFiles() {
                        const files = [];
                        
                        // Retrieve all files from the FilePond instance
                        FilePond.find(document.querySelector('.filepond')).getFiles().forEach(file => {
                            const fileURL = file.serverId ? file.serverId : file.source;
                            files.push(fileURL);
                        });

                        // console.log('Download URLs:', files);
                        
                        // Download all files
                        files.forEach(url => {
                            const a = $('<a>')
                                .attr('href', url)
                                .attr('download', url.split('/').pop()) // Extract the file name
                                .appendTo('body');
                            
                            a[0].click(); // Trigger the click event
                            a.remove(); // Remove the anchor element after the download starts
                        });
                    }

                    // Attach the click event to the button
                    $(document).on('click', '#downloadImgBtn', function(e) {
                        e.preventDefault();
                        downloadFiles();
                    });


                } else {
                console.log("No images to preview.");
                }
                
            },
            error: function() {
                console.error("Failed to fetch share details.");
            }
        });
    }
    
    // modal checkboxes
    $(document).ready(function() {
        const checkboxes = [
            { value: 'all', label: '全選' },
            { value: 'building', label: '大廈' },
            { value: 'street', label: '街道' },
            { value: 'district', label: '地區' },
            { value: 'floor', label: '樓層' },
            { value: 'flat', label: '單位' },
            { value: 'block', label: '座數' },
            { value: 'rental_price', label: '業主叫租' },
            { value: 'rental_g', label: '呎租(建)' },
            { value: 'rental_n', label: '呎租(實)' },
            { value: 'selling_price', label: '售價' },
            { value: 'selling_g', label: '呎價(建)' },
            { value: 'selling_n', label: '呎價(實)' },
            { value: 'gross_sf', label: '建築面積' },
            { value: 'net_sf', label: '實用面積' },
            { value: 'mgmf', label: '管理費' },
            { value: 'rate', label: '差餉' },
            { value: 'land', label: '地租' },
            { value: 'oths', label: '其他' },
            { value: 'youtube_link', label: 'Youtube link' },
            { value: 'cargo_lift', label: '載貨電梯' },
            { value: 'customer_lift', label: '載客電梯' },
            { value: 'num_floors', label: '最高樓層' },
            { value: 'car_park', label: '停車場' },
            { value: 'ceiling_height', label: '樓層高度' },
            { value: 'air_con_system', label: '冷氣系統' },
            { value: 'building_loading', label: '樓面承重' }
        ];

        checkboxes.forEach(({ value, label }) => {
            const nameAttr = value === 'all' ? 'checkbox-all' : 'building_info[]';
            const checkboxHtml = `
                <div class="form-check-width">
                    <input type="checkbox" name="${nameAttr}" value="${value}" id="checkbox-${value}" checked>
                    <label for="checkbox-${value}">${label}</label>
                </div>
            `;
            $('#checkboxContainer').append(checkboxHtml);
        });

        $(document).on('change', 'input[name="checkbox-all"]', function() {
            const isChecked = $(this).prop('checked');
            $('input[name="building_info[]"]').prop('checked', isChecked);
        });

        $(document).on('change', 'input[name="building_info[]"]', function() {
            const checkedValues = $('input[name="building_info[]"]:checked')
                .map(function() {
                    return $(this).val();
                }).get();

            console.log("Checked Values:", checkedValues);

            const totalCheckboxes = $('input[name="building_info[]"]').length;
            const totalChecked = $('input[name="building_info[]"]:checked').length;
            $('input[name="checkbox-all"]').prop('checked', totalChecked === totalCheckboxes);
        });
    });

    let swipableids = []
    $('#swipFun').click(function() {
        if (swipableids.length === 2) {
            let parent1 = $('#' + swipableids[0]).closest('.row')[0];
            let parent2 = $('#' + swipableids[1]).closest('.row')[0];

            if (parent1 && parent2) {
                let firstHTML = parent1.innerHTML;
                let secondHTML = parent2.innerHTML;
                parent1.innerHTML = secondHTML;
                parent2.innerHTML = firstHTML;
                swipableids = [];
                $('.swipe-check').prop('checked', false).removeClass('active');
                $('.swipe-check').show();
                $('#swipFun').hide();

                let property_share_list = [];
                $('.swipe-check').each(function() {
                    property_share_list.push($(this).attr('id'));
                });

                $.ajax({
                    url: '/swipe-properties',
                    type: 'POST',
                    data: {
                        _token: $('meta[name="csrf-token"]').attr('content'),
                        property_share_list: property_share_list
                    },
                    success: function (response) {
                        console.log('Property share list saved successfully:', response);
                    },
                    error: function (error) {
                        console.log('Error saving property share list:', error);
                    }
                });

                console.log("Updated Share List:", property_share_list);
            } else {
                console.error("One or both elements were not found.");
            }
        }
    });

    function resetSwipe() {
        swipableids = []
        $('#swipFun').hide()
        $('.swipe-check.active').removeClass('.active')
        $('.swipe-check').show()
        
        $(document).on('change', '.swipe-check', function() {
            let $this = $(this);
            let id = $this.attr('id');

            if ($this.is(':checked')) {
                $this.addClass('active');
                if (!swipableids.includes(id)) {
                    swipableids.push(id);
                }
            } else {
                $this.removeClass('active');
                swipableids = swipableids.filter(item => item !== id);
            }

            console.log(swipableids);

            if (swipableids.length === 2) {
                $('.swipe-check:not(.active)').hide();
                $('#swipFun').show();
            } else {
                $('.swipe-check').show();
                $('#swipFun').hide();
            }
        });
    }

    $(document).on('click', '.btn-danger', function(e) {
        e.preventDefault();

        let deleteUrl = $(this).attr('href');

        $.ajax({
                url: deleteUrl,
                type: 'POST',
                data: {
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    // alert(response.message);
                    $(`#property-row-${response.property_id}`).remove();
                    // ShareDetails();
                },
                error: function(xhr, status, error) {
                    console.error("Error deleting property:", error);
                    alert("Failed to delete the property.");
                }
            });
    });

    // $(document).ready(function() {
    //     $('#show_building_name').on('change', function() {
    //         if ($(this).is(':checked')) {
    //             console.log('is buildingName');
    //         }
    //     });

    //     $('#show_map').on('change', function() {
    //         if ($(this).is(':checked')) {
    //             console.log('is buildingMap');
    //         }
    //     });
    // });

    $(function (){
        $('.all_control').click(function (){
            console.log('All controls', $(this).attr('name'), $(this), $(this).parent().find('checkbox'));
            $('.photo-label-controls input[name^='+$(this).attr('name')+']').prop('checked', $(this).prop('checked'));
        });
    });

    $(function (){
        $('#show_building_name').click(function (){
            if($(this).prop('checked')){
                $('#show_building_name').val(1)
            }else{
                $('#show_building_name').val(0)
            }
        });
        $('#show_map').click(function (){
            if($(this).prop('checked')){
                $('#show_map').val(1)
            }else{
                $('#show_map').val(0)
            }
        });

        $('#show_as_list').click(function (){
            if($(this).prop('checked')){
                $('#show_as_list').val(1)
                $("#listViewAlert").show()
            }else{
                $('#show_as_list').val(0)
                $("#listViewAlert").hide()
            }
        });
    });

    $(document).ready(function() {
        $('#images_form').on('submit', function(e) {
            e.preventDefault();  // Prevent normal form submission

            // Get the action type based on the button clicked
            var actionType = $(this).find('button[name="submit1"]').is(':focus') ? 'submit1' : 'submit';

            // Set the action type value to the hidden input
            $('#actionType').val(actionType);

            // Perform AJAX request
            $.ajax({
                url: $(this).attr('action'),
                method: 'POST',
                data: $(this).serialize(),
                success: function(response) {
                    // Check the action and open the appropriate route
                    if (response.route) {
                        if (actionType === 'submit1') {
                            // Open PDF in a new tab
                            window.open(response.route, "_blank");
                        } else if (actionType === 'submit') {
                            // Redirect for WhatsApp sharing
                            window.location.href = response.route;
                        }
                    }
                },
                error: function(xhr, status, error) {
                    console.error("AJAX request failed: " + error);
                }
            });
        });

        // To handle the button click (set focus when PDF button is clicked)
        $('#pdfButton').on('click', function() {
            $(this).focus();  // Focus on the PDF button so that we know which one was clicked
        });
    });

</script>
@endsection