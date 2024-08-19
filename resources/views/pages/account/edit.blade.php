@extends('layouts.app')

@section('title', 'Edit Akun')

@section('page-header')
    <div class="row">
        <div class="col-12 col-lg-8 offset-lg-2">
            <section class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1>Edit Akun</h1>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="{{ route('account.show', $account->id) }}"><i
                                            class="fas fa-user-cog mr-1"></i> Akun</a></li>
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
    <div class="container-fluid">
        <div class="row">
            <div class="col-12 col-lg-8 offset-lg-2">
                <div class="card">
                    <form action="{{ route('account.update', $account->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="card-body">
                            <!-- validation error handler -->
                            @if ($errors->any())
                                <div class="alert alert-secondary alert-dismissible">
                                    <button type="button" class="close" data-dismiss="alert"
                                        aria-hidden="true">&times;</button>
                                    <h5><i class="icon fas fa-exclamation-triangle"></i> Terdapat input yang tidak valid!
                                    </h5>
                                    <ul class="mb-0 px-3">
                                        @foreach ($errors->all() as $error)
                                            <li><small>{{ $error }}</small></li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            <div class="row">
                                <div class="col-md-4 align-self-center">
                                    <!-- Display the profile picture -->
                                    <img id="coverPreview"
                                         src="{{ $account->profile_photo ? asset('storage/' . $account->profile_photo) : asset('https://placehold.co/400x600') }}" 
                                         alt="{{ $account->name }}" class="img-fluid img-thumbnail">

                                    <!-- Custom button to trigger file input -->
                                    <div class="input-group">
                                        <div class="custom-file d-flex justify-content-center mt-3">
                                            <input type="file" class="custom-file-input" id="profilePicture"
                                                name="profile_photo" accept=".jpg" style="display: none;">
                                            <button type="button" class="btn btn-primary" id="editProfilePictureButton">
                                                <i class="fas fa-edit mr-1"></i>Edit Gambar Profil
                                            </button>
                                        </div>
                                    </div>
                                    @if ($errors->has('profile_photo'))
                                        <div class="text-danger">
                                            {{ $errors->first('profile_photo') }}
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
                                        <label for="name">Nama</label>
                                        <input type="text" class="form-control" id="name" name="name"
                                            value="{{ old('name', $account->name) }}" required>
                                        @if ($errors->has('name'))
                                            <div class="text-danger">
                                                {{ $errors->first('name') }}
                                            </div>
                                        @endif
                                    </div>

                                    <div class="form-group">
                                        <label for="email">Email</label>
                                        <input type="text" class="form-control" id="email" name="email"
                                            value="{{ old('email', $account->email) }}" placeholder="Masukkan email">
                                        @if ($errors->has('email'))
                                            <div class="text-danger">
                                                {{ $errors->first('email') }}
                                            </div>
                                        @endif
                                    </div>
                                    
                                    <div class="form-group d-flex justify-content-between">
                                        <a href="{{ route('account.edit_password', $account->id) }}" class="btn btn-primary">
                                            <i class="fas fa-edit mr-1"></i>Ubah Password
                                        </a>
                                        <a class="btn btn-danger" href="#" onclick="confirmDelete({{ $account->id }})">
                                            <i class="fas fa-trash-alt"></i> Hapus Akun
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary d-none" id="saveButton"><i class="fas fa-save mr-1"></i>Simpan</button>
                            <a href="{{ route('account.show', $account->id) }}" class="btn btn-secondary"><i
                                    class="fas fa-arrow-left mr-1"></i>Kembali</a>
                        </div>
                    </form>
                    <form id="delete-form-{{ $account->id }}" action="{{ route('account.destroy', $account->id) }}" method="POST" style="display: none;">
                        @csrf
                        @method('DELETE')
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
                email: $('#email').val(),
                profilePicture: $('#coverPreview').attr('src')
            };

            function checkForChanges() {
                const currentFormState = {
                    name: $('#name').val(),
                    email: $('#email').val(),
                    profilePicture: $('#coverPreview').attr('src')
                };

                const formChanged = initialFormState.name !== currentFormState.name ||
                                    initialFormState.email !== currentFormState.email ||
                                    initialFormState.profilePicture !== currentFormState.profilePicture;

                if (formChanged) {
                    $('#saveButton').removeClass('d-none');
                } else {
                    $('#saveButton').addClass('d-none');
                }
            }

            $('#editProfilePictureButton').click(function() {
                $('#profilePicture').click();
            });

            $('#profilePicture').change(function(e) {
                const file = e.target.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        $('#coverPreview').attr('src', e.target.result);
                        $('#cancelUploadButton').show();
                        checkForChanges();
                    };
                    reader.readAsDataURL(file);
                } else {
                    $('#coverPreview').attr('src', initialFormState.profilePicture);
                    $('#cancelUploadButton').hide();
                    checkForChanges();
                }
            });

            $('#name, #email').on('input', function() {
                checkForChanges();
            });

            $('#cancelUploadButton button').click(function() {
                $('#profilePicture').val('');
                $('#coverPreview').attr('src', initialFormState.profilePicture);
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
    </script>
@endsection
