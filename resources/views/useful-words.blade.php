@extends('layouts.app')

@section('styles')
{{-- <style>
    body{
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
</style> --}}
@endsection

@section('content')
<section>
    <div class="container mt-2">
        <form id="common-words-form" method="POST">
            @csrf        
            <h3>Useful Words</h3>
            <div class="row">
               
                <div class="col-12">
                    <label for="">Word</label>
                    <input type="text" name="word" id="word" class="form-control">
                </div>
            </div>
          
            <button type="submit" name="submit" class="btn btn-block font-weight-bold log_btn btn-lg mt-4">Save</button>
                      
        </form>
        <h4 class="font-weight-bold pt-5 text-center">Words List</h4>
        <div id="wordsTable_wrapper" class="dataTables_wrapper dt-bootstrap4 no-footer">
            <table id="wordsTable" class="table table-striped table-bordered dataTable no-footer" style="width: 1110px;">
                <thead>
                    <tr>
                        <th class="sorting_disabled sorting_asc" rowspan="1" colspan="1" style="width: 572px;" aria-label="Word">Word</th>
                        <th class="sorting" tabindex="0" aria-controls="wordsTable" rowspan="1" colspan="1" style="width: 276px;" aria-label="Created at: activate to sort column ascending">Created at</th>
                        <th class="sorting" tabindex="0" aria-controls="wordsTable" rowspan="1" colspan="1" style="width: 151px;">Action</th>
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
            <small class="text-center text-muted">Copyright 2024</small>
        </div>
    </footer>
</section>
@endsection

@section('scripts')
<script>
    // $(document).ready(function() {
    //     $('#wordsTable').DataTable({
    //         pageLength: 50, // Default entries
    //         lengthMenu: [10, 25, 50, 100]
    //     });
    // });

    $('#common-words-form').on('submit', function (e) {
        e.preventDefault();

        let formData = {
            word: $('#word').val(),
            _token: '{{ csrf_token() }}',
        };

        $.ajax({
            url: '{{ route("common.words.save") }}',
            type: 'POST',
            data: formData,
            success: function (response) {
                fetchWords();
                // alert(response.message);
                $('#word').val('');
            },
            error: function (xhr) {
                alert('An error occurred: ' + xhr.responseText);
            }
        });
    });


    function fetchWords() {
        $.ajax({
            url: '{{ route("common.words.fetch") }}',
            type: 'GET',
            success: function (data) {
                if ($.fn.DataTable.isDataTable('#wordsTable')) {
                    $('#wordsTable').DataTable().clear().destroy();
                }

                $('#wordsTable').DataTable({
                    data: data, 
                    columns: [
                        { data: 'word', title: 'Word' },
                        {
                            data: 'created_at',
                            title: 'Created At',
                            render: function (data) {
                                return new Date(data).toISOString().slice(0, 19).replace('T', ' ');
                            }
                        },
                        {
                            data: 'id',
                            title: 'Action',
                            orderable: false,
                            render: function (data) {
                                return `
                                    <button class="btn btn-block btn-sm btn-danger deleteUser delete-word" data-id="${data}">
                                        Delete
                                    </button>
                                `;
                            }
                        }
                    ],
                    order: [[1, 'desc']],
                    pageLength: 50,
                    destroy: true
                });
            },
            error: function (xhr) {
                console.error('Failed to fetch words:', xhr.responseText);
            }
        });
    }

    fetchWords();

    $(document).on('click', '.delete-word', function () {
        const wordId = $(this).data('id');
        if (confirm('Are you sure?')) {
            $.ajax({
                url: `/delete-word/${wordId}`, // Define the delete route
                type: 'DELETE',
                data: { _token: '{{ csrf_token() }}' },
                success: function () {
                    alert('Record deleted.');
                    fetchWords();
                },
                error: function (xhr) {
                    console.error('Failed to delete word:', xhr.responseText);
                }
            });
        }
    });
</script>
@endsection