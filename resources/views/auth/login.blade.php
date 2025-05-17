<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ __('Login') }}</title>
    <!-- Bootstrap Css -->
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
    <!-- custom css -->
    <link href="{{asset('assets/css/custom.css')}}" rel="stylesheet" type="text/css" />
    <!-- toastify css -->
    <link href="{{asset('assets/css/toastify.min.css')}}" rel="stylesheet" type="text/css" />
</head>

<body>
    <div class="container">
        <div class="row">
            <div class="col-md-6 offset-md-3">
                <h2 class="text-center text-dark mt-5">{{ __('Login Form') }}</h2>
                <div class="card my-5">
                    <form id="login-form" class="card-body cardbody-color p-lg-5">
                        <div class="text-center">
                            <img src="https://cdn.pixabay.com/photo/2016/03/31/19/56/avatar-1295397__340.png" class="img-fluid profile-image-pic img-thumbnail rounded-circle my-3" width="200px" alt="profile">
                        </div>
                         <div class="mb-3">
                            <label for="email" class="form-label">{{ __('Email') }}</label>
                            <input type="email" class="form-control" name="email" placeholder="Enter Email" value="{{ old('email') }}">
                            <p class="text-danger d-none error-message" id="email-error"></p>
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">{{ __('Password') }}</label>
                            <input type="password" class="form-control" name="password" placeholder="Enter password">
                            <p class="text-danger d-none error-message" id="password-error"></p>
                        </div>
                        <p class="text-danger d-none error-message" id="invalid-error"></p>
                        <div class="text-center">
                            <button id="submit-button" type="button" class="btn btn-success px-5 mb-5 w-100">{{ __('Login') }}</button>
                        </div>
                        <div class="form-text text-center mb-5 text-dark">
                            <span>{{ __('Not Registered?') }}</span>
                            <a href="{{ route('register') }}" class="text-dark fw-bold">{{ __('Create an Account') }}</a>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
    <!-- Jquery JS -->
    <script src="{{ asset('assets/js/jquery-3.7.1.min.js') }}"></script>
    <!-- Bootstrap JS -->
    <script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>
    <!-- Axios JS -->
    <script src="{{ asset('assets/js/axios.min.js')}}"></script>
    <!-- Toastify JS -->
    <script src="{{ asset('assets/js/toastify-js.js')}}"></script>
    <script type="text/javascript">
        $('#submit-button').click(function () {
            const form = $('#login-form');
            let formData = new FormData(form[0]);
            const spinner = `<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span><span class="visually-hidden">Loading...</span>`;
            $('#submit-button').html(spinner);
            $('.error-message').addClass('d-none').html('');
        
            axios.post("{{ route('login.post') }}", formData, {
                headers: {
                    'Content-Type': 'multipart/form-data',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                method: 'post',
                params: {
                    '_method': 'POST'
                }
            })
            .then(response => {
                if (response.status === 200) {
                    Toastify({
                        text: response.data.message,
                        backgroundColor: "green",
                        close: true,
                    }).showToast();
                    setTimeout(function () {
                        window.location.href = response.data.redirect;
                    }, 1000);
                }
            })
            .catch(error => {
                console.log(error.response);
                if (error.response && error.response.status === 422) {
                    let errors = error.response.data.errors;
                    for (let field in errors) {
                        $(`#${field}-error`).removeClass('d-none').html(errors[field][0]);
                    }
                }else if (error.response && error.response.status === 401) {
                    const invalidError = error.response.data.error;
                    $('#invalid-error').removeClass('d-none').html(invalidError);
                }else {
                    console.error("An unexpected error occurred.");
                }
            })
            .finally(() => {
                $('#submit-button').html('Submit');
            });
        });
    </script>
</body>