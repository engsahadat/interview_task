@php
use App\Libs\Constants;
@endphp
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title','Dashboard')</title>
    <!-- Bootstrap Css -->
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
    <!-- custom css -->
    <link href="{{asset('assets/css/custom.css')}}" rel="stylesheet" type="text/css" />
    <!-- toastify css -->
    <link href="{{asset('assets/css/toastify.min.css')}}" rel="stylesheet" type="text/css" />
</head>

<body>
    <div class="container mt-2">
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <a class="navbar-brand" href="#">Navbar</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    @if (Auth::user()->role == Constants::ADMIN_ROLE)
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('admin') }}">{{ __('Admin') }}</a>
                        </li>
                    @endif
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('order.index') }}">{{ __('Order') }}</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('order.optimize') }}">{{ __('Optimize Query') }}</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('file.index') }}">{{ __('File Upload') }}</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout').submit();">{{ __('Logout') }}</a>
                        <form id="logout" method="POST" action="{{ route('logout') }}">
                            @csrf
                        </form>
                    </li>
                </ul>
            </div>
        </nav>
        <div class="m-5">
            @yield('content')
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
    @yield('script')
</body>