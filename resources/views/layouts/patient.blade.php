<!DOCTYPE html>
<html lang="en" class="">

<head>

    <!-- Site Title -->
    <title>Doctor Portal</title>
    <!-- Character Set and Responsive Meta Tags -->

    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />

    <!-- Favicon -->
    <link rel="shortcut icon" href="{{ asset('assets/img/logo/fevicon.png')}}" type="image/x-icon" />

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/bootstrap.min.css')}}" />
    <link rel="stylesheet" href="https://site-assets.fontawesome.com/releases/v6.5.2/css/all.css">

    <!-- Custom Styles -->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/style.css')}}" />

    <link href="https://cdnjs.cloudflare.com/ajax/libs/flag-icon-css/3.5.0/css/flag-icon.min.css" rel="stylesheet" />

    @yield('style')
</head>

<body class="bg-light">

    <!-- main screen start -->
    <main class="cust-admin-area">
        <header class="header patient-header">
            <div class="container-fluid">
                <nav class="navbar navbar-expand-lg">
                    <a class="navbar-brand me-lg-5" href="#">
                        <img src="{{ asset('assets/img/logo/main.svg')}}" alt="logo" class="img-fluid">
                    </a>
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <ul class="navbar-nav mx-auto mb-2 mb-lg-0">
                            <li class="nav-item">
                                <a class="nav-link @if(request()->segment(1)=='doctor' && request()->segment(2)=='') active @endif" href="{{ route('doctor')}}">{{ __('patient.doctors portal')}}</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link @if(request()->segment(1)=='doctor' && request()->segment(2)=='monitoring') active @endif" href="{{ route('patientMonitoring')}}">{{ __('patient.patient monitor')}}</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link @if(request()->segment(1)=='doctor' && request()->segment(2)=='patients') active @endif" href="{{ route('doctor.patients')}}">{{ __('patient.patients')}}</a>
                            </li>
                            <!-- <li class="nav-item">
                                <a class="nav-link" href="#"> add new patient</a>
                            </li> -->
                        </ul>
                        <div class="top-header-right">
                           
                            <form class="search-bar position-relative me-2" id="" accept="">
                                <input type="text" name="" id="" placeholder="Search..." class="form-control">
                                <i class="fa-regular fa-magnifying-glass"></i>
                            </form>
                            <div class="language-dropdown position-relative me-2">
                                @if(app()->getLocale()=='sk')
                                <button class="btn btn-primary btn-lg dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false"><span class="flag-icon flag-icon-sk me-1"></span> <span>Slovak</span></button>
                                @else
                                <button class="btn btn-primary btn-lg dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false"><span class="flag-icon flag-icon-us me-1"></span> <span>English</span></button>
                                @endif
                                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                    <li>
                                        <a class="dropdown-item @if(app()->getLocale()=='en') active @endif" href="{{ route('changeLanguage','en')}}"><span class="flag-icon flag-icon-us me-1"></span> <span>English</span></a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item @if(app()->getLocale()=='sk') active @endif" href="{{ route('changeLanguage','sk')}}"><span class="flag-icon flag-icon-sk me-1"></span> <span>Slovak</span></a>
                                    </li>

                                </ul>
                            </div>
                            <div class="profile-dropdown">
                                <ul class="list-inline mb-0">
                                    <li class="list-inline-item">
                                        <a href="#" data-bs-toggle="dropdown" class="dropdown" aria-expanded="true">
                                            <p> <img src="{{ asset('assets/img/profile.png')}}" alt="" class="me-1" /> {{auth()->user()->firstname}} {{auth()->user()->lastname}}</p>
                                        </a>
                                        <ul class="dropdown-menu dropdown-menu-end border-light-subtle py-3" data-popper-placement="bottom-start">
                                            <li class="mb-3"><a class="dropdown-item border-bottom-1" href="#">
                                                    <svg class="me-2" width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                        <path d="M10.0001 20C8.48816 20.0043 6.99532 19.6622 5.6361 19C5.13865 18.758 4.66203 18.4754 4.2111 18.155L4.0741 18.055C2.83392 17.1396 1.81997 15.9522 1.1101 14.584C0.375836 13.1679 -0.00499271 11.5952 4.94229e-05 10C4.94229e-05 4.47715 4.47725 0 10.0001 0C15.5229 0 20.0001 4.47715 20.0001 10C20.0051 11.5944 19.6247 13.1664 18.8911 14.582C18.1822 15.9494 17.1697 17.1364 15.9311 18.052C15.4639 18.394 14.968 18.6951 14.4491 18.952L14.3691 18.992C13.009 19.6577 11.5144 20.0026 10.0001 20ZM10.0001 15C8.50158 14.9971 7.12776 15.834 6.4431 17.167C8.68449 18.2772 11.3157 18.2772 13.5571 17.167V17.162C12.8716 15.8305 11.4977 14.9954 10.0001 15ZM10.0001 13C12.1662 13.0028 14.1635 14.1701 15.2291 16.056L15.2441 16.043L15.2581 16.031L15.2411 16.046L15.2311 16.054C17.7601 13.8691 18.6644 10.3423 17.4987 7.21011C16.3331 4.07788 13.3432 2.00032 10.0011 2.00032C6.65901 2.00032 3.66909 4.07788 2.50345 7.21011C1.33781 10.3423 2.2421 13.8691 4.7711 16.054C5.83736 14.169 7.83446 13.0026 10.0001 13ZM10.0001 12C7.79096 12 6.0001 10.2091 6.0001 8C6.0001 5.79086 7.79096 4 10.0001 4C12.2092 4 14.0001 5.79086 14.0001 8C14.0001 9.06087 13.5787 10.0783 12.8285 10.8284C12.0784 11.5786 11.061 12 10.0001 12ZM10.0001 6C8.89553 6 8.0001 6.89543 8.0001 8C8.0001 9.10457 8.89553 10 10.0001 10C11.1047 10 12.0001 9.10457 12.0001 8C12.0001 6.89543 11.1047 6 10.0001 6Z" fill="#6371E8"></path>
                                                    </svg>
                                                    Profile </a></li>
                                            <li><a class="dropdown-item" href="javascript:void(0)" onclick="logoutForm()">
                                                    <svg class="me-2" width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                        <path d="M16 18H7C5.89543 18 5 17.1046 5 16V12H7V16H16V2H7V6H5V2C5 0.89543 5.89543 0 7 0H16C17.1046 0 18 0.89543 18 2V16C18 17.1046 17.1046 18 16 18ZM9 13V10H0V8H9V5L14 9L9 13Z" fill="#6371E8"></path>
                                                    </svg>
                                                    Log Out</a></li>
                                        </ul>
                                    </li>
                                </ul>
                            </div>

                            </form>
                        </div>
                </nav>

            </div>
        </header>
        @yield('content')
    </main>
    <form method="post" action="{{ route('logout')}}" id="logoutForm">
        @csrf
    </form>
    <script src="{{ asset('assets/js/jquery.min.js') }}"></script>
    <!-- Popper JS and Bootstrap JS -->
    <script src="{{ asset('assets/js/bootstrap.bundle.js') }}"></script>
    <script src="{{ asset('assets/js/popper.min.js') }}"></script>
    <script src="{{ asset('assets/js/custom.js') }}"></script>
    @yield('script')
    <script>
        function logoutForm() {
            $('#logoutForm').submit();
        }
    </script>
</body>

</html>