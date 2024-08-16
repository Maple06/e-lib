@extends('layouts.auth')

@section('title', 'Login')

@section('content')
<script src="https://accounts.google.com/gsi/client" async></script>
<style>
.login-page {
    background-image: url({{ asset('images/login-bg.jpg') }});
    backdrop-filter: blur(10px);
}

.separator {
  display: flex;
  align-items: center;
  text-align: center;
  color: gray !important;
}

.separator::before,
.separator::after {
  content: '';
  flex: 1;
  border-bottom: 1px solid gray;
}

.separator:not(:empty)::before {
  margin-right: .25em;
}

.separator:not(:empty)::after {
  margin-left: .25em;
}

.g-sign-in-button .content-wrapper {
    min-height: auto !important;
    margin-left: 0px;
    background-color: transparent !important;
}

.input-group .input-group-text {
    border-left: 1px solid #ced4da !important;
    border-right: 0 !important;
    border-radius: 5px 0 0 5px !important;
}

.input-group .form-control {
    border-left: 0 !important;
    border-right: 1px solid #ced4da !important;
}

button {
    width: 60% !important;
    margin: auto;
}
</style>
<div class="card">
    <div class="card-body login-card-body">
        <p class="login-box-msg">Selamat datang! <br> Masuk untuk memulai sesi Anda</p>

        <form action="{{ route('login') }}" method="post">
            @csrf
            <div class="input-group mb-3">
                <div class="input-group-append">
                    <div class="input-group-text">
                        <span class="fas fa-envelope"></span>
                    </div>
                </div>
                <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" placeholder="Email" value="{{ old('email') }}" required autofocus>
                @error('email')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
            <div class="input-group mb-3">
                <div class="input-group-append">
                    <div class="input-group-text">
                        <span class="fas fa-lock"></span>
                    </div>
                </div>
                <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" placeholder="Kata Sandi" required>
                @error('password')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>

            <div class="icheck-primary">
                <input type="checkbox" name="remember" id="remember">
                <label for="remember">
                    Ingat Saya
                </label>
            </div>
            <br />
            <button type="submit" class="btn btn-primary btn-block">Masuk</button>
        </form>
        <br />
        <div class="separator">or</div>
        <br />
        <div id="g_id_onload"
            data-client_id="NONE"
            data-context="signin"
            data-ux_mode="popup"
            data-login_uri="NONE"
            data-auto_prompt="false">
        </div>

        <div class="g_id_signin"
            data-type="standard"
            data-shape="rectangular"
            data-theme="outline"
            data-text="signin_with"
            data-size="large"
            data-logo_alignment="left">
        </div>
        <p>*Login with google will be available later</p>
    </div>
    <!-- /.login-card-body -->
</div>
@endsection