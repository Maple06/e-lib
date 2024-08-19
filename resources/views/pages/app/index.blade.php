@extends('layouts.app')

@section('title', 'Detail Aplikasi')

@section('page-header')
<div class="row">
    <div class="col-12 col-lg-8 offset-lg-2">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Detail Aplikasi</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item active"><i class="fas fa-window-maximize mr-1"></i> Aplikasi</li>
                        </ol>
                    </div>
                </div>
            </div>
        </section>
    </div>
</div>
@endsection

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12 col-lg-8 offset-lg-2">
            <div class="card">
                <div class="card-body">
                    <div class="col">
                        <br>
                            <p class="h3 w-50 m-auto text-center">{{ $app->name }}</p>
                        <hr class="border" />
                        <div class="logo">
                            <label>Logo Aplikasi</label>
                            <br />
                            <img src="{{ asset($app->logo_path) }}" 
                                    alt="App Logo" class="img-fluid img-thumbnail">
                        </div>
                        <div class="description mt-3">
                            <label>Deskripsi Aplikasi</label>
                            <p>{{ $app->description }}</p>
                        </div>
                        <hr />
                        <div class="socials">
                            <label>Akun Media Sosial Konvensional</label>
                            <p>
                                <a href="mailto:{{ $app->socials->email }}" target="_blank">
                                    <i class="fas fa-envelope mr-1"></i> Email
                                </a><br />
                                <a href="tel:{{ $app->socials->phone }}" target="_blank">
                                    <i class="fas fa-phone mr-1"></i> Telepon
                                </a>
                            </p>
                            <hr />
                            <label>Akun Media Sosial</label>
                            <p>
                                @if (!$app->socials || !$app->socials->facebook && !$app->socials->instagram && !$app->socials->twitter && !$app->socials->youtube)
                                    <p>Tidak ada akun media sosial</p>
                                @else
                                    @php
                                        $socials_link = [
                                            'facebook' => ['url' => 'https://www.facebook.com/', 'icon' => 'fab fa-facebook'],
                                            'instagram' => ['url' => 'https://www.instagram.com/', 'icon' => 'fab fa-instagram'],
                                            'linkedin' => ['url' => 'https://www.linkedin.com/in/', 'icon' => 'fab fa-linkedin'],
                                            'twitter' => ['url' => 'https://twitter.com/', 'icon' => 'fab fa-twitter'],
                                            'youtube' => ['url' => 'https://www.youtube.com/channel/', 'icon' => 'fab fa-youtube'],
                                        ];
                                    @endphp
                        
                                    @foreach ($socials_link as $key => $info)
                                        @if ($app->socials->$key)
                                            @if ($key == 'twitter')
                                                <a href="{{ $info['url'] . $app->socials->$key }}" class="col-4 d-flex align-items-center px-0" style="margin-left: -3px" target="_blank">
                                                    <img src="{{ asset('images/x-twitter-logo.png') }}" alt="X / Twitter Logo" width="20" height="20" class="mr-2">
                                                    X / Twitter
                                                </a>
                                            @else
                                            <a href="{{ $info['url'] . $app->socials->$key }}" target="_blank">
                                                <i class="{{ $info['icon'] }} mr-1"></i> {{ $app->socials->$key }}
                                            </a><br>
                                            @endif
                                        @endif
                                    @endforeach
                                @endif
                            </p>
                        </div>                        
                        
                        <div class="form-group">
                            <a href="{{ route('app.edit') }}" class="btn btn-primary mt-3"><i class="fas fa-edit mr-1"></i> Edit Detail Aplikasi</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')
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
@endsection
