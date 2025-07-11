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
        <div class="container bg-white pr-4 pl-4  log_section pb-5 pt-lg-4">
            <h4 class="font-weight-bold pt-5 text-center">Users Info</h4>
            <div class="table-responsive">

                <div id="userTable_wrapper" class="dataTables_wrapper dt-bootstrap4 no-footer">
                    <table id="userTable" class="table table-striped table-bordered dataTable no-footer" style="width: 1092px;">
                        <thead>
                            <tr>
                                <th>Username</th>
                                <th style="width: 185px;">Created at</th>
                                <th style="width: 195px;">Contact Permission</th>
                                <th style="width: 178px;">Photo Permission</th>
                                <th style="width: 178px;">Image Merge Permission</th>
                                <th style="width: 95px;">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($users as $user)
                                <tr>
                                    <td class="sorting_1">{{ $user->name }}</td>
                                    <td>{{ $user->created_at }}</td>
                                    <td>
                                        <input type="checkbox" data-type="contact" class="permission_check" data-id="{{ $user->id }}" 
                                        {{ $user->contact_permission ? 'checked' : '' }}>
                                    </td>
                                    <td>
                                        <input type="checkbox" data-type="photo" class="permission_check" data-id="{{ $user->id }}" 
                                        {{ $user->photo_permission ? 'checked' : '' }}>
                                    </td>
                                    <td>
                                        <input type="checkbox" data-type="image_merge" class="permission_check" data-id="{{ $user->id }}" 
                                        {{ $user->image_merge_permission ? 'checked' : '' }}>
                                    </td>
                                    <td>
                                        <button class="btn btn-block btn-sm btn-danger deleteUser" data-id="{{ $user->id }}">Delete</button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
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
@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        $('#userTable').DataTable({
            pageLength: 50,
            lengthMenu: [10, 25, 50, 100],
            responsive: true, 
        });
    });
    
    $('#userTable').on('click', '.deleteUser', function() {
        var id = $(this).data('id');
        const deleteUserRoute = "{{ route('users.destroy', ':id') }}";
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

                        // Reload DataTable
                        location.reload();
                    } else {
                        alert(response.message);
                    }
                }
            });
        }
    });

    $('#userTable').on('click', '.permission_check', function() {
        var id = $(this).data('id');
        var type = $(this).data('type');
        var value = $(this).prop('checked') ? 1 : 0;

        // AJAX request
        $.ajax({
            url: "{{ route('users.update-permission') }}",
            type: 'POST',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: {
                id: id,
                type: type,
                value: value
            },
            success: function(response) {
                if (!response.success) {
                    alert("Invalid ID.");
                }
            }
        });
    });
</script>
@endsection