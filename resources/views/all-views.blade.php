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
        <h4 class="font-weight-bold pt-5 text-center">Today's Views Info</h4>
        <div class="table-responsive">
            <div id="example_wrapper" class="dataTables_wrapper dt-bootstrap4 no-footer">
                <table class="table table-bordered table-striped dataTable no-footer" id="all-views-table" style="width: 100%;">
                    <thead>
                        <tr>
                            <th style="width: 107px;">Agent Name</th>
                            <th style="width: 153px;">Last Visited Code</th>
                            <th style="width: 173px">Add Button Pressed</th>
                            <th style="width: 110px;">View Count</th>
                            <th style="width: 160px;">Last Visited Time</th>
                            <th style="width: 150px;">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($agents as $agent)
                            <td>{{ $agent->name }}</td>
                            <td>
                                @if($agent->latestActivity)
                                @php
                                    $urlPath = parse_url($agent->latestActivity->url, PHP_URL_PATH);
                                    $urlPath = urldecode($urlPath);
                                    $code = '';
                                    if (strpos($urlPath, 'property/') !== false) {
                                        $code = last(explode('property/', $urlPath));
                                    }
                                @endphp

                                <a href="{{ $agent->latestActivity->url }}">{{ $code }}</a>
                                @else
                                    No Activity
                                @endif
                            </td>
                            <td>0</td>
                            <td>0</td>
                            <td>
                                @if($agent->latestActivity)
                                    {{ $agent->latestActivity->created_at }}
                                @else
                                    N/A
                                @endif
                            </td>
                            <td>
                                <button class="btn btn-primary view-details-btn" data-agent-id="{{ $agent->id }}">View Detail</button>
                            </td>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</section>

<!-- Modal -->
<div class="modal" tabindex="-1" role="dialog" id="myModal">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Visited Pages By <span id="modalHead"></span></h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>Visited url</th>
                        <th>Time</th>
                    </tr>
                </thead>
                <tbody id="detail-body"></tbody>
            </table>
          <p id="modalContent"></p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
</div>

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
        $('#all-views-table').DataTable({
            processing: true,
            ordering: false,
            // ajax: {
            //     url: '',
            //     type: 'GET',
            //     dataSrc: function (json) {
            //         return json.data;
            //     }
            // },
            // columns: [
            //     {
            //         data: 'code',
            //         name: 'code',
            //         render: function(data, type, row) {
            //             return `<a href="/property/${data}">${data}</a>`;
            //         }
            //     },
            //     {
            //         data: 'district',
            //         name: 'district',
            //         render: function(data, type, row) {
            //             return data ? data : 'N/A';
            //         }
            //     },
            //     {
            //         data: 'street',
            //         name: 'street',
            //         render: function(data, type, row) {
            //             return data ? data : 'N/A'; 
            //         }
            //     },
            //     { data: 'building', name: 'building' },
            //     {
            //         data: null,
            //         render: function(data, type, row) {
            //             return `
            //                 <button id="del-btn" data-id="${row.code}" class="btn btn-sm btn-danger deleteUser w-100">Delete</button>
            //             `.replace(':code', row.code);
            //         }
            //     }
            // ],
            pageLength: 50,
            lengthMenu: [10, 25, 50, 100],
            responsive: true,
        });
    });

    $(document).on('click', '.view-details-btn', function () {
        let agentId = $(this).data('agent-id');

        $.ajax({
            url: '/get-agent-activity',
            type: 'GET',
            data: { agent_id: agentId },
            success: function (response) {
                $('#modalHead').text(response.agent_name);
                let rows = '';
                response.activities.forEach(activity => {
                    let code = ''; 
                    const url = activity.url;

                    const decodedUrl = decodeURIComponent(url);
                    const baseUrl = window.location.origin;
                    const path = decodedUrl.replace(baseUrl, '');

                    // Check if the URL path matches any of the specified patterns
                    if (path.includes('property/') || path.includes('/edit-sizePrice/') || path.includes('/edit-ftod/') || path.includes('/edit-landlord/') || 
                        path.includes('/edit-buildinginfo/') || path.includes('/get-property-images/') || 
                        path.includes('/property-detail-edit/') || path.includes('/edit-code/')) {
                        
                        // Extract the code from the path (after the last '/')
                        const parts = path.split('/');
                        code = parts[parts.length - 1]; // Get the last part as the code
                    }

                    console.log('Extracted Code:', code);
                    const createdAt = new Date(activity.created_at);
                    const formattedDate = createdAt.getFullYear() + '-' +
                        String(createdAt.getMonth() + 1).padStart(2, '0') + '-' +
                        String(createdAt.getDate()).padStart(2, '0') + ' ' +
                        String(createdAt.getHours()).padStart(2, '0') + ':' +
                        String(createdAt.getMinutes()).padStart(2, '0') + ':' +
                        String(createdAt.getSeconds()).padStart(2, '0'); 
                    rows += `<tr>
                                <td>
                                    <a href="${url}">${url}</a><br>
                                    ${code ? `<span>Building Code: ${code}</span>` : ''}
                                </td>
                                <td>${formattedDate}</td>
                            </tr>`;
                });
                $('#detail-body').html(rows);
                $('#myModal').modal('show');
            },
            error: function (xhr) {
                console.error(xhr.responseText);
                alert('Something went wrong. Please try again.');
            }
        });
    });
</script>
@endsection