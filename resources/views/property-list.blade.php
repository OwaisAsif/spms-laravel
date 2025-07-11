@extends('layouts.app')

@section('styles')
{{-- <style>
    body {
        font-size: 12px !important;
    }
</style> --}}
@endsection

@section('content')
<section>
    <div class="container bg-white pr-4 pl-4 log_section pb-5 pt-lg-4 mt-3">
        <h4 class="font-weight-bold pt-5 text-center">Building Info</h4>
        <div class="table-responsive">
            <table id="propertyTable" class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th style="width: 117px;">Code</th>
                        <th style="width: 70px;">District</th>
                        <th style="width: 263px;">Street</th>
                        <th style="width: 327px;">Building</th>
                        <th style="width: 120px;">Action</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
    </div>
</section>

<section class="p-2 mt-2" style="background-color: #fff;">
    <footer>
        <div class="container social_icon text-center">
            <hr class="font-weight-bold">
            <small class="text-center text-muted">Copyright 2021</small>
        </div>
    </footer>
</section>
@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        $('#propertyTable').DataTable({
            processing: true,
            // serverSide: true,
            ordering: false,
            ajax: {
                url: '{{ route("property.table") }}',
                type: 'GET',
                dataSrc: function (json) {
                    return json.data;
                }
            },
            columns: [
                {
                    data: 'code',
                    name: 'code',
                    render: function(data, type, row) {
                        return `<a href="/property/${data}">${data}</a>`;
                    }
                },
                {
                    data: 'district',
                    name: 'district',
                    render: function(data, type, row) {
                        return data ? data : 'N/A';
                    }
                },
                {
                    data: 'street',
                    name: 'street',
                    render: function(data, type, row) {
                        return data ? data : 'N/A'; 
                    }
                },
                { data: 'building', name: 'building' },
                {
                    data: null,
                    render: function(data, type, row) {
                        return `
                            <button id="del-btn" data-id="${row.code}" class="btn btn-sm btn-danger deleteUser w-100">Delete</button>
                            <a href="{{ route('view.photo', ':code') }}" class="btn btn-sm btn-success w-100 mt-2">View Photos</a>
                            <button class="btn btn-sm btn-info copyUser w-100 mt-2" data-id="${row.code}">Copy</button>
                        `.replace(':code', row.code);
                    }
                }
            ],
            pageLength: 50,
            lengthMenu: [10, 25, 50, 100],
            responsive: true,
        });
    });

    $(document).on('click', '.copyUser', function() {
        var originalCode = $(this).data('id');
        
        $.ajax({
            url: '{{ route("property.copy") }}',
            type: 'POST',
            data: {
                _token: $('meta[name="csrf-token"]').attr('content'),
                code: originalCode
            },
            success: function(response) {
                if (response.success) {
                    alert('Property copied successfully');
                    $('#propertyTable').DataTable().ajax.reload();
                } else {
                    alert(response.message);
                }
            },
            error: function(xhr, status, error) {
                alert("An error occurred while copying the property.");
            }
        });
    });

    $(document).on('click', '#del-btn', function() {
        var id = $(this).data('id');
        const deleteUserRoute = "{{ route('property.destroy', ':code') }}";
        var deleteConfirm = confirm("Are you sure?");

        if (deleteConfirm) {
            $.ajax({
                url: deleteUserRoute.replace(':code', id),
                type: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    if (response.success) {
                        alert(response.message);

                        // Reload DataTable or the page
                        $('#propertyTable').DataTable().ajax.reload();
                    } else {
                        alert(response.message);
                    }
                },
                error: function(xhr, status, error) {
                    alert("An error occurred while deleting the property.");
                }
            });
        }
    });

</script>
@endsection
