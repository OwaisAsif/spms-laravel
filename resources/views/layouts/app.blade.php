<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>SPMS</title>
    <link rel="icon" type="image/x-icon" href="{{ asset('assets/logos/favicon.jpg') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    {{-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" crossorigin="anonymous"> --}}
    <link href="https://fonts.googleapis.com/css2?family=Lato:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css" />
    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap4.min.css">

    <!-- SmartWizard CSS -->
    <link href="https://cdn.jsdelivr.net/npm/smartwizard@6/dist/css/smart_wizard_all.min.css" rel="stylesheet" type="text/css" />
    
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Lato:wght@400;700&display=swap');
        body {
            font-family: 'Lato', sans-serif;
            font-size: 14px !important;
        }
        h1, h2, h3 {
            font-family: 'Lato', sans-serif;
        }
        p {
            font-family: 'Lato', sans-serif;
        }
        section {
            padding: 10px 10px;
        }
    </style>
    <link rel="stylesheet" href="{{ asset('assets/css/style.css?v=2') }}">
    @yield('styles')
</head>
<body class="bg-light">
    @include('layouts.partials.navbar')
    
    <div>
        @yield('content')
    </div>

    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- jQuery and DataTables Scripts -->
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap4.min.js"></script>
    <!-- Popper.js -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <!-- Bootstrap JS -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    @yield('scripts')

    <script>
        function updateShareCount() {
            $.ajax({
                url: "{{ route('getShareCount') }}",
                type: "GET",
                success: function(response) {
                    // console.log(response.count);
                    $('.wa-selected').text(response.count);
                    $('.wa-pre-share').text(response.preShareCount);
                    if (response.preShareCount >= 100) {
                        $.ajax({
                            url: "{{ route('deleteOldShareRecords') }}", 
                            type: "POST",
                            data: {
                                _token: $('meta[name="csrf-token"]').attr('content') 
                            },
                            success: function(deleteResponse) {
                                console.log(deleteResponse.message);
                            },
                            error: function() {
                                console.error("Failed to delete old records.");
                            }
                        });
                    }
                },
                error: function() {
                    console.error("Failed to fetch share count.");
                }
            });
        }

        $(document).ready(function() {
            updateShareCount();
        });
    </script>
</body>
</html>