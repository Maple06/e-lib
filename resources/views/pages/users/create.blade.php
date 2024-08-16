@extends('layouts.app')

@section('title', 'Tambah Anggota')

@section('page-header')
<div class="row">
    <div class="col-12 col-lg-8 offset-lg-2">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Tambah Anggota</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('members.index') }}"><i class="fas fa-users mr-1"></i> Anggota</a></li>
                            <li class="breadcrumb-item active">Tambah</li>
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
                <!-- /.card-header -->
                <div class="card-header">
                    <h3 class="card-title">Form Tambah Anggota</h3>
                </div>

                <!-- form start -->
                <form action="{{ route('users.store') }}" method="POST">
                    @csrf
                    <div class="card-body">
                        <!-- validation error handler -->
                        @if ($errors->any())
                            <div class="alert alert-secondary alert-dismissible">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                <h5><i class="icon fas fa-exclamation-triangle"></i> Terdapat input yang tidak valid!</h5>
                                <ul class="mb-0 px-3">
                                    @foreach ($errors->all() as $error)
                                        <li><small>{{ $error }}</small></li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <div class="form-group">
                            <label for="full_name">Nama Lengkap</label>
                            <input type="text" class="form-control" id="full_name" name="full_name" value="{{ old('full_name') }}" required>
                        </div>
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}" required>
                        </div>
                        <div class="row">
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="password-hid">Password</label>
                                    <input type="password-hid" class="form-control" id="password-hid" name="password-hid" required>
                                    <input type="hidden" id="password" name="password" value="">
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="password-conf-hid">Password Confirmation</label>
                                    <input type="password-conf-hid" class="form-control" id="password-conf-hid" name="password-conf-hid" required>
                                    <input type="hidden" id="password_confirmation" name="password_confirmation" value="">
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /.card-body -->
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary"><i class="fas fa-save mr-1"></i>Simpan</button>
                        <a href="{{ route('users.index') }}" class="btn btn-secondary"><i class="fas fa-arrow-left mr-1"></i>Kembali</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')
<script>
    var showLength = 1;
    var delay = 1000;
    var hideAll = setTimeout(function() {}, 0);

    $(document).ready(function() {
        function handlePasswordField(inputSelector, hiddenSelector) {
        $(inputSelector).on("input", function() {
            var offset = $(inputSelector).val().length - $(hiddenSelector).val().length;
            if (offset > 0) {
                $(hiddenSelector).val($(hiddenSelector).val() + $(inputSelector).val().substring($(hiddenSelector).val().length, $(hiddenSelector).val().length + offset));
            } else if (offset < 0) {
                $(hiddenSelector).val($(hiddenSelector).val().substring(0, $(hiddenSelector).val().length + offset));
            }

            // Change the visible string
            if ($(this).val().length > showLength) {
                $(this).val($(this).val().substring(0, $(this).val().length - showLength).replace(/./g, "•") + $(this).val().substring($(this).val().length - showLength, $(this).val().length));
            }

            // Set the timer
            clearTimeout(hideAll);
            hideAll = setTimeout(function() {
                $(inputSelector).val($(inputSelector).val().replace(/./g, "•"));
            }, delay);
        });
    }

    // Apply to both password fields
    handlePasswordField("#password-hid", "#password");
    handlePasswordField("#password-conf-hid", "#password_confirmation");
    });
</script>
@endsection
