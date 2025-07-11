@extends('layouts.app')

@section('content')
<section>
    <div class="container bg-white pr-4 pl-4  log_section pb-5 pt-lg-4">
        {{-- <h4 class="font-weight-bold text-center">Utilities</h4>
        <div class="table-responsive">
            <div id="example_wrapper" class="dataTables_wrapper dt-bootstrap4 no-footer">
                <table class="table table-bordered table-striped dataTable no-footer" id="facilities_table" style="width: 100%;">
                    <thead>
                        <tr>
                            <th style="width: 107px;">No</th>
                            <th style="width: 153px;">Value</th>
                            <th style="width: 173px;">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div> --}}


        <ul class="nav nav-tabs" id="myTab" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" id="photos-tab" data-toggle="tab" href="#districts" role="tab" aria-controls="photos" aria-selected="true">Districts</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="listings-tab" data-toggle="tab" href="#facilities" role="tab" aria-controls="listings" aria-selected="false">Facilities</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="photos-tab" data-toggle="tab" href="#types" role="tab" aria-controls="photos" aria-selected="true">Types</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="listings-tab" data-toggle="tab" href="#decoration" role="tab" aria-controls="listings" aria-selected="false">Decorations</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="photos-tab" data-toggle="tab" href="#usage" role="tab" aria-controls="photos" aria-selected="true">Usage</a>
            </li>
        </ul>
        <div class="tab-content" style="height: auto;">
            <div class="tab-pane active p-3" id="districts" role="tabpanel" aria-labelledby="districts-tab">
                <h4 class="font-weight-bold text-center">Districts</h4>
                <div class="row py-3">
                    <div class="col-md-8">
                        <input type="text" class="form-control" name="district">
                    </div>
                    <div class="col-md-4">
                        <button class="btn btn-primary add-btn">Add District</button>
                    </div>
                </div>
                <hr>
                <div class="table-responsive">
                    <div id="example_wrapper" class="dataTables_wrapper dt-bootstrap4 no-footer">
                        <table class="table table-bordered table-striped dataTable no-footer" id="district-table" style="width: 100%;">
                            <thead>
                                <tr>
                                    <th style="width: 107px;">No</th>
                                    <th style="width: 153px;">Value</th>
                                    <th style="width: 173px;">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="tab-pane p-3" id="facilities" role="tabpanel" aria-labelledby="facilities-tab">
                <h4 class="font-weight-bold text-center">Facilities</h4>
                <div class="row py-3">
                    <div class="col-md-8">
                        <input type="text" class="form-control" name="facilities">
                    </div>
                    <div class="col-md-4">
                        <button class="btn btn-primary add-btn">Add Facility</button>
                    </div>
                </div>
                <hr>
                <div class="table-responsive">
                    <div id="example_wrapper" class="dataTables_wrapper dt-bootstrap4 no-footer">
                        <table class="table table-bordered table-striped dataTable no-footer" id="facilities-table" style="width: 100%;">
                            <thead>
                                <tr>
                                    <th style="width: 107px;">No</th>
                                    <th style="width: 153px;">Value</th>
                                    <th style="width: 173px;">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="tab-pane p-3" id="types" role="tabpanel" aria-labelledby="types-tab">
                <h4 class="font-weight-bold text-center">Types</h4>
                <div class="row py-3">
                    <div class="col-md-8">
                        <input type="text" class="form-control" name="types">
                    </div>
                    <div class="col-md-4">
                        <button class="btn btn-primary add-btn">Add types</button>
                    </div>
                </div>
                <hr>
                <div class="table-responsive">
                    <div id="example_wrapper" class="dataTables_wrapper dt-bootstrap4 no-footer">
                        <table class="table table-bordered table-striped dataTable no-footer" id="types-table" style="width: 100%;">
                            <thead>
                                <tr>
                                    <th style="width: 107px;">No</th>
                                    <th style="width: 153px;">Value</th>
                                    <th style="width: 173px;">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="tab-pane p-3" id="decoration" role="tabpanel" aria-labelledby="decoration-tab">
                <h4 class="font-weight-bold text-center">Decorations</h4>
                <div class="row py-3">
                    <div class="col-md-8">
                        <input type="text" class="form-control" name="decorations">
                    </div>
                    <div class="col-md-4">
                        <button class="btn btn-primary add-btn">Add Decoration</button>
                    </div>
                </div>
                <hr>
                <div class="table-responsive">
                    <div id="example_wrapper" class="dataTables_wrapper dt-bootstrap4 no-footer">
                        <table class="table table-bordered table-striped dataTable no-footer" id="decorations-table" style="width: 100%;">
                            <thead>
                                <tr>
                                    <th style="width: 107px;">No</th>
                                    <th style="width: 153px;">Value</th>
                                    <th style="width: 173px;">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="tab-pane p-3" id="usage" role="tabpanel" aria-labelledby="usage-tab">
                <h4 class="font-weight-bold text-center">Usage</h4>
                <div class="row py-3">
                    <div class="col-md-8">
                        <input type="text" class="form-control" name="usage">
                    </div>
                    <div class="col-md-4">
                        <button class="btn btn-primary add-btn">Add Usage</button>
                    </div>
                </div>
                <hr>
                <div class="table-responsive">
                    <div id="example_wrapper" class="dataTables_wrapper dt-bootstrap4 no-footer">
                        <table class="table table-bordered table-striped dataTable no-footer" id="usage-table" style="width: 100%;">
                            <thead>
                                <tr>
                                    <th style="width: 107px;">No</th>
                                    <th style="width: 153px;">Value</th>
                                    <th style="width: 173px;">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="" style="background-color: #fff;">
    <footer>
        <div class="container social_icon text-center">
            <hr class="font-weight-bold">
            <small class="text-center text-muted">Copyright 2024</small>
        </div>
    </footer>
</section>

    <div class="modal fade" id="edit_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Edit Modal</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            </div>
            <div class="row p-4">
                <div class="col-md-8">
                    <input type="text" class="form-control">
                </div>
                <div class="col-md-4">
                    <button class="btn btn-primary edit-btn">Edit</button>
                </div>
            </div>
        </div>
        </div>
    </div>
@endsection

@section('scripts')
<script>
    $(document).ready(function () {
        function loadTableData(key, tableId) {
            $.ajax({
                url: `/get-utility-values/${key}`,
                type: 'GET',
                success: function (data) {
                    let tableBody = $(`#${tableId} tbody`);
                    let table = $(`#${tableId}`);
                    
                    // Destroy existing DataTable instance
                    if ($.fn.DataTable.isDataTable(table)) {
                        table.DataTable().destroy();
                    }
                    
                    tableBody.empty();
                    data.forEach((value, index) => {
                        tableBody.append(`
                            <tr>
                                <td>${index + 1}</td>
                                <td>${value}</td>
                                <td>
                                    <button class="btn btn-warning btn-sm edit-btn" data-id="${index}" data-value="${value}" data-key="${key}">Edit</button>
                                    <button class="btn btn-danger btn-sm delete-btn" data-id="${index}" data-key="${key}">Delete</button>
                                </td>
                            </tr>
                        `);
                    });

                    // Reinitialize DataTable
                    table.DataTable({
                        responsive: true,
                        autoWidth: false,
                        pageLength: 50,
                    });
                }
            });
        }

        // Load tables data
        const keys = ['district', 'facilities', 'types', 'decorations', 'usage'];
        keys.forEach(key => loadTableData(key, `${key}-table`));

        // Add Value
        $('.add-btn').click(function () {
            let input = $(this).closest('.row').find('input');
            let value = input.val();
            let key = input.attr('name');
            if (value.trim() !== '') {
                $.ajax({
                    url: `/utilities/value/add`,
                    type: 'POST',
                    data: { key, value, _token: '{{ csrf_token() }}' },
                    success: function () {
                        loadTableData(key, `${key}-table`);
                        input.val('');
                    }
                });
            }
        });

        // Edit Value
        $(document).on('click', '.edit-btn', function () {
            let value = $(this).data('value');
            let key = $(this).data('key');
            let index = $(this).data('id');

            // console.log(value, key, index);

            $('#edit_modal input').val(value);
            $('#edit_modal').modal('show');

            $('#edit_modal .edit-btn').off('click').on('click', function () {
                let updatedValue = $('#edit_modal input').val();
                $.ajax({
                    url: `/utilities/value/edit`,
                    type: 'POST',
                    data: { key, value: updatedValue, index, _token: '{{ csrf_token() }}' },
                    success: function () {
                        loadTableData(key, `${key}-table`);
                        $('#edit_modal').modal('hide');
                    }
                });
            });
        });

        // Delete Value
        $(document).on('click', '.delete-btn', function () {
            let key = $(this).data('key');
            let index = $(this).data('id');
            if (confirm('Are you sure you want to delete this value?')) {
                $.ajax({
                    url: `/utilities/value/delete`,
                    type: 'POST',
                    data: { key, index, _token: '{{ csrf_token() }}' },
                    success: function () {
                        loadTableData(key, `${key}-table`);
                    }
                });
            }
        });
    });
</script>
@endsection