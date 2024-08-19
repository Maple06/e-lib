@extends('layouts.app')

@section('title', 'Update Password')

@section('page-header')
<div class="row">
    <div class="col-12 col-lg-8 offset-lg-2">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Update Password</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('account.show', $account->id) }}"><i class="fas fa-user-cog mr-1"></i> Akun</a></li>
                            <li class="breadcrumb-item active">Update Password</li>
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
                    <form action="{{ route('account.update_password', $account->id) }}" method="POST">
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
                            <div class="form-group">
                                <label for="current_password">Current Password</label>
                                <input type="password" name="current_password" id="current_password" class="form-control" required>
                            </div>
                            @if ($errors->has('password'))
                                <div class="text-danger">
                                    {{ $errors->first('password') }}
                                </div>
                            @endif

                            <div class="form-group">
                                <label for="new_password">New Password</label>
                                <input type="password" name="new_password" id="new_password" class="form-control" required>
                            </div>
                            @if ($errors->has('new_password'))
                                <div class="text-danger">
                                    {{ $errors->first('new_password') }}
                                </div>
                            @endif

                            <div class="form-group">
                                <label for="new_password_confirmation">Confirm New Password</label>
                                <input type="password" name="new_password_confirmation" id="new_password_confirmation" class="form-control" required>
                            </div>
                            @if ($errors->has('new_password_confirmation'))
                                <div class="text-danger">
                                    {{ $errors->first('new_password_confirmation') }}
                                </div>
                            @endif

                            <button type="submit" class="btn btn-primary mt-3">Update Password</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
