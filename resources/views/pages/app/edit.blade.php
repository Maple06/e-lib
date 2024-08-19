@extends('layouts.app')

@section('title', 'Edit Aplikasi')

@section('page-header')
    <div class="row">
        <div class="col-12 col-lg-8 offset-lg-2">
            <section class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1>Edit Aplikasi</h1>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="{{ route('app.index') }}"><i class="fas fa-window-maximize mr-1"></i> Aplikasi</a></li>
                                <li class="breadcrumb-item active">Edit</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
@endsection

@section('content')
    <style>
        .input-group > .custom-select:not(:first-child),
        .input-group > .form-control:not(:first-child) {
            border-top-left-radius: 0.25rem;
            border-bottom-left-radius: 0.25rem;
        }
    </style>
    <div class="container-fluid">
        <div class="row">
            <div class="col-12 col-lg-8 offset-lg-2">
                <div class="card">
                    <form action="{{ route('app.update') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="card-body">
                            <!-- Validation error handler -->
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

                            <div class="row">
                                <div class="col-md-4 align-self-center">
                                    <!-- Display the logo -->
                                    <img id="logoPreview"
                                         src="{{ asset($app->logo_path) }}" 
                                         alt="{{ $app->name }} Logo" class="img-fluid img-thumbnail w-100">

                                    <!-- Custom button to trigger file input -->
                                    <div class="input-group">
                                        <div class="custom-file d-flex justify-content-center mt-3">
                                            <input type="file" class="custom-file-input" id="logoPath"
                                                name="logo_path" accept=".jpg" style="display: none;">
                                            <button type="button" class="btn btn-primary" id="editLogoPathButton">
                                                <i class="fas fa-edit mr-1"></i>Edit Logo Aplikasi
                                            </button>
                                        </div>
                                    </div>
                                    @if ($errors->has('logo_path'))
                                        <div class="text-danger">
                                            {{ $errors->first('logo_path') }}
                                        </div>
                                    @endif
                                    <div class="input-group" style="display: grid !important">
                                        <div id="cancelUploadButton" style="display: none; justify-self: center">
                                            <button type="button" class="btn btn-danger mt-2">
                                                <i class="fas fa-trash-alt"></i> Batalkan Pilihan
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-8">
                                    <div class="form-group">
                                        <label for="name">Nama Aplikasi</label>
                                        <input type="text" class="form-control" id="name" name="name"
                                            value="{{ old('name', $app->name) }}" placeholder="Masukkan nama aplikasi" required>
                                        @if ($errors->has('name'))
                                            <div class="text-danger">
                                                {{ $errors->first('name') }}
                                            </div>
                                        @endif
                                    </div>
                                    
                                    <div class="form-group">
                                        <label for="description">Deskripsi Aplikasi</label>
                                        <textarea class="form-control" id="description" name="description" rows="3" cols="30" placeholder="Masukkan deskripsi aplikasi">
                                            {{ old('description', $app->description) }}
                                        </textarea>
                                        @if ($errors->has('description'))
                                        <div class="text-danger">
                                            {{ $errors->first('description') }}
                                        </div>
                                        @endif
                                    </div>

                                    <div class="form-group">
                                        <label>Media Sosial</label>
                                        <div class="input-group row">
                                            <p class="col-4"><i class="fas fa-envelope mr-1"></i> Email</p>
                                            <input class="form-control col-8" type="email" id="email" name="email" placeholder="Masukkan email contact person" value="{{ old('email', $app->socials->email) }}" required />
                                            @if ($errors->has('email'))
                                                <div class="text-danger">
                                                    {{ $errors->first('email') }}
                                                </div>
                                            @endif
                                        </div>
                                        <div class="input-group row">
                                            <p class="col-4"><i class="fas fa-phone mr-1"></i> Telepon</p>
                                            <input class="form-control col-8" type="text" id="phone" name="phone" placeholder="Masukkan nomor telepon" value="{{ old('phone', $app->socials->phone) }}" required />
                                            @if ($errors->has('phone'))
                                                <div class="text-danger">
                                                    {{ $errors->first('phone') }}
                                                </div>
                                            @endif
                                        </div>
                                        <div class="input-group row">
                                            <p class="col-4"><i class="fab fa-facebook mr-1"></i> Facebook</p>
                                            <input class="form-control col-8" type="text" id="facebook" name="facebook" placeholder="Masukkan link/username Facebook" value="{{ old('facebook', $app->socials->facebook) }}" />
                                            @if ($errors->has('facebook'))
                                                <div class="text-danger">
                                                    {{ $errors->first('facebook') }}
                                                </div>
                                            @endif
                                        </div>
                                        <div class="input-group row">
                                            <p class="col-4"><i class="fab fa-instagram mr-1"></i> Instagram</p>
                                            <input class="form-control col-8" type="text" id="instagram" name="instagram" placeholder="Masukkan link/username Instagram" value="{{ old('instagram', $app->socials->instagram) }}" />
                                            @if ($errors->has('instagram'))
                                                <div class="text-danger">
                                                    {{ $errors->first('instagram') }}
                                                </div>
                                            @endif
                                        </div>
                                        <div class="input-group row">
                                            <p class="col-4"><i class="fab fa-linkedin mr-1"></i> Linkedin</p>
                                            <input class="form-control col-8" type="text" id="linkedin" name="linkedin" placeholder="Masukkan link/username Linkedin" value="{{ old('linkedin', $app->socials->linkedin) }}" />
                                            @if ($errors->has('linkedin'))
                                                <div class="text-danger">
                                                    {{ $errors->first('linkedin') }}
                                                </div>
                                            @endif
                                        </div>
                                        <div class="input-group row">
                                            <p class="col-4 d-flex align-items-center pl-1">
                                                <img src="{{ asset('images/x-twitter-logo.png') }}" alt="X / Twitter Logo" width="20" height="20" class="mr-2">
                                                 X / Twitter
                                            </p>
                                            <input class="form-control col-8" type="text" id="x-twitter" name="x-twitter" placeholder="Masukkan link/username X/Twitter" value="{{ old('x-twitter', $app->socials->twitter) }}" />
                                            @if ($errors->has('x-twitter'))
                                                <div class="text-danger">
                                                    {{ $errors->first('x-twitter') }}
                                                </div>
                                            @endif
                                        </div>
                                        <div class="input-group row">
                                            <p class="col-4"><i class="fab fa-youtube mr-1"></i> YouTube</p>
                                            <input class="form-control col-8" type="text" id="youtube" name="youtube" placeholder="Masukkan link/username YouTube" value="{{ old('youtube', $app->socials->youtube) }}" />
                                            @if ($errors->has('youtube'))
                                                <div class="text-danger">
                                                    {{ $errors->first('youtube') }}
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary d-none" id="saveButton"><i class="fas fa-save mr-1"></i>Simpan</button>
                            <a href="{{ route('app.index') }}" class="btn btn-secondary"><i class="fas fa-arrow-left mr-1"></i>Kembali</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script>
        $(document).ready(function() {
            const initialFormState = {
                name: $('#name').val(),
                description: $('#description').val(),
                logoPath: $('#logoPreview').attr('src'),
                email: $('#email').val(),
                phone: $('#phone').val(),
                facebook: $('#facebook').val(),
                instagram: $('#instagram').val(),
                linkedin: $('#linkedin').val(),
                twitter: $('#x-twitter').val(),
                youtube: $('#youtube').val()
            };

            function checkForChanges() {
                const currentFormState = {
                    name: $('#name').val(),
                    description: $('#description').val(),
                    logoPath: $('#logoPreview').attr('src'),
                    email: $('#email').val(),
                    phone: $('#phone').val(),
                    facebook: $('#facebook').val(),
                    instagram: $('#instagram').val(),
                    linkedin: $('#linkedin').val(),
                    twitter: $('#x-twitter').val(),
                    youtube: $('#youtube').val()
                };

                const formChanged = initialFormState.name !== currentFormState.name ||
                                    initialFormState.description !== currentFormState.description ||
                                    initialFormState.logoPath !== currentFormState.logoPath ||
                                    initialFormState.email !== currentFormState.email ||
                                    initialFormState.phone !== currentFormState.phone ||
                                    initialFormState.facebook !== currentFormState.facebook ||
                                    initialFormState.instagram !== currentFormState.instagram ||
                                    initialFormState.linkedin !== currentFormState.linkedin ||
                                    initialFormState.twitter !== currentFormState.twitter ||
                                    initialFormState.youtube !== currentFormState.youtube;

                if (formChanged) {
                    $('#saveButton').removeClass('d-none');
                } else {
                    $('#saveButton').addClass('d-none');
                }
            }

            $('#editLogoPathButton').click(function() {
                $('#logoPath').click();
            });

            $('#logoPath').change(function(e) {
                const file = e.target.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        $('#logoPreview').attr('src', e.target.result);
                        $('#cancelUploadButton').show();
                        checkForChanges();
                    };
                    reader.readAsDataURL(file);
                } else {
                    $('#logoPreview').attr('src', initialFormState.logoPath);
                    $('#cancelUploadButton').hide();
                    checkForChanges();
                }
            });

            $('#name, #description, #email, #phone, #facebook, #instagram, #linkedin, #x-twitter, #youtube').on('input', function() {
                checkForChanges();
            });

            $('#cancelUploadButton button').click(function() {
                $('#logoPath').val('');
                $('#logoPreview').attr('src', initialFormState.logoPath);
                $('#cancelUploadButton').hide();
                checkForChanges();
            });

            // Initial check to set the correct state of the save button
            checkForChanges();
        });

        function confirmDelete(accountId) {
            Swal.fire({
                title: 'Apakah Anda yakin?',
                text: "Setelah dihapus, Anda tidak dapat memulihkan akun anda!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('delete-form-' + accountId).submit();
                }
            })
        }

        document.addEventListener('DOMContentLoaded', function() {
            var textarea = document.getElementById('description');
            if (textarea) {
                textarea.value = textarea.value.trim();
            }
        });
    </script>
@endsection
