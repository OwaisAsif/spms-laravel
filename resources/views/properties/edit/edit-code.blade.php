@extends('layouts.app')

@section('styles')
    {{-- <style>
        .log_btn {
            background-color: #05445E;
            transition: 0.7s;
            color: #fff;
        }
        .log_btn:hover {
            background-color: #189AB4;
            color: #fff;
        }
        .log_section p {
            font-size: 20px;
        }
    </style> --}}
@endsection

@section('content')

    <section>
        <div class="container bg-white pr-4 pl-4  log_section pb-5 pt-lg-4">
            <h4 class="font-weight-bold ">Edit Code
            </h4>

            <form action="{{ route('update.code', $code) }}" method="post" class="form-group">
                @csrf

                <input type="text" name="code_new" id="code" class="form-control" value="{{ $code }}" placeholder="Enter Code">
                <div id="outputC" style="display: none;"></div>

                <input type="hidden" name="code" value="{{ $code }}" class="form-control">
                <input type="submit" name="submit" value="Submit" class="btn log_btn mt-4">
            </form>
            <div id="output2">

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
</script>
@endsection