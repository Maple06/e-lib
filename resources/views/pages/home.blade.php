@php
    use Illuminate\Support\Facades\File;
    $app = json_decode(File::get(base_path('app_info.json')));
@endphp

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>e-Library Home</title>
    <link href="{{ asset('AdminLTE-3.2.0/plugins/fontawesome-free/css/all.min.css') }}" rel="stylesheet">
    <link href="{{ asset('AdminLTE-3.2.0/dist/css/adminlte.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link rel="icon" href="{{ asset($app->logo_path) }}">
</head>
<body class="hold-transition layout-top-nav">
    <div class="wrapper">

        <!-- Navbar -->
        <nav class="main-header navbar navbar-expand-md navbar-light navbar-white">
            <div class="container">
                <a href="{{ url('/') }}" class="navbar-brand">
                    <img src="{{ asset($app->logo_path) }}" alt="Logo Aplikasi" style="width:50px">
                    <span class="brand-text font-weight-light">{{ $app->name }}</span>
                </a>
                <div class="collapse navbar-collapse order-3" id="navbarCollapse">
                    <ul class="navbar-nav">
                        <!-- Add additional links here if necessary -->
                    </ul>
                </div>
            </div>
        </nav>
        <!-- /.navbar -->

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Main content -->
            <div class="content">
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-md-8">
                            <div class="card mt-5">
                                <div class="card-header">Selamat Datang di e-Library!</div>
                                <div class="card-body">
                                    <p>Selamat datang di aplikasi e-Library kami. Silakan login untuk mengakses dashboard.</p>
                                    @guest
                                        <a href="{{ route('login') }}" class="btn btn-primary">Login</a>
                                    @else
                                        <a href="{{ route('dashboard') }}" class="btn btn-primary">Masuk ke Dashboard</a>
                                    @endguest
                                </div>
                            </div>
                        </div>
                    </div>
                </div><!-- /.container-fluid -->
            </div>
            <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->
    </div>
    <!-- ./wrapper -->

    <script src="{{ asset('AdminLTE-3.2.0/plugins/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('AdminLTE-3.2.0/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('AdminLTE-3.2.0/dist/js/adminlte.min.js') }}"></script>
    <script>
        @if(session('success'))
            $(document).Toasts('create', {
                class: 'bg-success',
                title: 'Berhasil',
                autohide: true, // Enable auto hide
                delay: 3000,    // Auto close after 3 seconds
                body: '{{ session('success') }}'
            });
        @endif
    </script>
</body>
</html>
