<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Login</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <style>
        h4 {
            font-family: 'Lato', sans-serif;
            font-size: 1.5rem;
        }
        /* input {
            font-size: 1.2rem !important;
        } */
        input:-webkit-autofill {
            font-size: 1.2rem !important;
            background-color: #fff;
            transition: background-color 5000s ease-in-out 0s;
        }
    </style>
</head>
<body class="bg-light">
    <div class="container mt-2 bg-white">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card" style="border: 0;">
                    <div class="card-body">
                        <h4 class="font-weight-bold pt-5 pb-4 text-danger text-center">SPMS LOGIN</h4>
                        <form method="POST" action="{{ route('login') }}" autocomplete="on">
                            @csrf
    
                            <div class="row mt-3 d-flex justify-content-center">
                                <div class="col-md-6">
                                    <input id="name" type="name" class="form-control p-4 border-0 bg-light @error('name') is-invalid @enderror" name="name" placeholder="Enter your username" value="{{ old('name') }}" required autocomplete="name" autofocus>
                                    @error('name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
    
                            <div class="row mt-3 d-flex justify-content-center">
                                <div class="col-md-6">
                                    <input id="password" type="password" class="form-control p-4 border-0 bg-light @error('password') is-invalid @enderror" name="password" required autocomplete="current-password" placeholder="Enter your password">
    
                                    @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
    
                            <div class="row mt-3 d-flex justify-content-center">
                                <div class="col-md-6">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
    
                                        <label class="form-check-label" for="remember">
                                            {{ __('Remember Me') }}
                                        </label>
                                    </div>
                                </div>
                            </div>
    
                            <div class="row mb-0 d-flex justify-content-center">
                                <div class="col-md-6">
                                    <button type="submit" class="btn btn-block font-weight-bold btn-danger btn-lg mt-3 w-100">
                                        {{ __('LOGIN') }}
                                    </button>
    
                                    {{-- @if (Route::has('password.request'))
                                        <a class="btn btn-link" href="{{ route('password.request') }}">
                                            {{ __('Forgot Your Password?') }}
                                        </a>
                                    @endif --}}
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <section class="py-2 mt-2" style="background-color: #fff;">
        <footer>
            <div class="container social_icon text-center">
                <hr class="font-weight-bold">
                <small class="text-center text-muted">Copyright 2024</small>
            </div>
        </footer>
    </section>
</body>
</html>
