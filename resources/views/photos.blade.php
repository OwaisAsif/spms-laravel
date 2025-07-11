@extends('layouts.app')

@section('content')

    <section>
        <div class="">
            <h3>Photos</h3>
            <div class="table-responsive">
                <table id="photosTable" class="table table-striped table-bordered dataTable no-footer" style="width: 100%;">
                    <thead>
                        <tr>
                            <th style="width: 548px;">Images</th>
                            <th style="width: 734px;" >Action</th>
                        </tr>
                    </thead>
                    <tbody>
                </table>
            </div>
        </div>   
        <!-- </form> -->
    </section>

@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        var code = "{{ $code }}"; 
        $('#photosTable').DataTable({
            processing: true,
            searching: false,
            // serverSide: true,
            ajax: {
                url: '{{ route("table.photos", ":code") }}'.replace(':code', code),
                type: 'GET',
                dataSrc: function (data) {
                    return data.data;
                }
            },
            columns: [
                { data: 'image', render: function(data) {
                    return `<img src="{{ asset('${data}') }}" class="img-fluid">`;
                }},
                { data: 'action', render: function(data, type, row) {
                    return `<button id="del-btn" class="btn btn-sm btn-danger" data-id="${row.id}">Delete</button>`;
                }}
            ],
            pageLength: 50,
            lengthMenu: [10, 25, 50, 100],
            responsive: true,
        });
    });

    $(document).on('click', '#del-btn', function() {
        var id = $(this).data('id');
        const deleteUserRoute = "{{ route('photo.delete', ':id') }}";
        var deleteConfirm = confirm("Are you sure?");

        if (deleteConfirm) {
            $.ajax({
                url: deleteUserRoute.replace(':id', id),
                type: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    if (response.success) {
                        alert(response.message);

                        // Reload DataTable or the page
                        $('#photosTable').DataTable().ajax.reload();
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