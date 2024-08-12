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

</head>

<body class="bg-light">

    <!-- main screen start -->
    <main class="cust-admin-area">
        <header class="header">
            <div class="container-fluid">
                <div class="row align-items-center">
                    <div class="col-md-6 col-6">
                        <div class="logo-sec">
                            <img src="{{ asset('assets/img/logo/main.svg')}}" alt="logo" class="img-fluid" />
                        </div>
                    </div>
                    <div class="col-md-6 col-6">
                        <div class="top-header-right">
                            <a href="{{route('login')}}" class="btn btn-theme px-5">{{__('register.Login')}}</a>
                            <a href="{{route('admin.dashboard')}}" class="btn btn-theme px-5 ms-2">Go To Admin Panel</a>
                        </div>
                    </div>
                </div>
            </div>
        </header>

        @yield('content')
    </main>

    <script src="{{ asset('assets/js/jquery.min.js') }}"></script>
    <!-- Popper JS and Bootstrap JS -->
    <script src="{{ asset('assets/js/bootstrap.bundle.js') }}"></script>
    <script src="{{ asset('js/popper.min.js') }}"></script>
    <script src="{{ asset('assets/js/custom.js') }}"></script>
    @stack('script')
</body>

</html>