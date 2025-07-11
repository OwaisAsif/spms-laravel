@extends('layouts.app')

@section('styles')
    {{-- <style>
        h4 {
            font-family: 'Lato', sans-serif;
            font-size: 1.5rem;
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
    <div class="container bg-white pr-4 pl-4  log_section pb-5 mt-3">

        <div class="row">
            <div class="col-md-6 offset-lg-3 ">
                <form action="{{ route('pass.update') }}" method="POST" data-parsley-validate="" novalidate="">
                    @csrf
                    <div class="text-center">
                        <h4 class="font-weight-bold pt-5 pb-4">RESET PASSWORD</h4>
                        @if(session('success'))
                            <div class="alert alert-success alert-dismissible">
                                <button type="button" class="close" data-dismiss="alert">×</button>
                                <strong>{{ session('success') }}</strong>
                            </div>
                        @endif
                        <input type="password" class="form-control mt-4 p-4 border-0 bg-light" name="passwordLogIn" placeholder="Enter your new password" required="">

                        <button type="submit" class="btn btn-block font-weight-bold log_btn btn-lg mt-4">RESET</button>
                    </div>
                </form>
            </div>
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