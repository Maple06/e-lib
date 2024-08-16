<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - {{ config('app.name', 'e-Library') }}</title>
    <!-- AdminLTE CSS -->
    <link rel="stylesheet" href="{{ asset('AdminLTE-3.2.0/plugins/fontawesome-free/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('AdminLTE-3.2.0/dist/css/adminlte.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/google.css') }}">
    <!-- Custom CSS -->
    <style>
        body {
            background-color: #f4f6f9;
        }
        .login-logo b {
            font-weight: 700 !important;
        }
        label {
            font-weight: normal !important;
        }
        .login-box {
            border-radius: 10px;
            background-color: rgba(255, 255, 255, 0.9);
        }
        .login-logo {
            margin-bottom: 0px;
            padding: 10px 0px;
            border-radius: 10px 10px 0px 0px; /*TL TR BR BL*/
        }
        .card, .card-body{
            border-radius: 0 0 10px 10px !important;
            /* background-color: rgba(244, 245, 216, 0.9); */
        }
    </style>
</head>
<body class="hold-transition login-page">
    <div class="col d-flex justify-content-center align-items-center m-auto w-50">
        <div class="login-box shadow">
            <div class="login-logo">
                <a href="{{ url('/') }}"><b>{{ config('app.name', 'e-Library') }}</b></a>
            </div>
            <!-- /.login-logo -->
            @yield('content')
        </div>
        <!-- /.login-box -->
        <div class="details-box">
            
        </div>
    </div>

    <!-- AdminLTE JS -->
    <script src="{{ asset('AdminLTE-3.2.0/plugins/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('AdminLTE-3.2.0/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('AdminLTE-3.2.0/dist/js/adminlte.min.js') }}"></script>
</body>
</html>