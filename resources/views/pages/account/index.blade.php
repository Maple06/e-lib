@extends('layouts.app')

@section('title', 'Akun')

@section('page-header')
<div class="row">
    <div class="col-12 col-lg-8 offset-lg-2">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Akun</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('account.show', $account->id) }}"><i class="fas fa-users-cog mr-1"></i> Akun</a></li>
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
                    <div class="row">
                        <div class="col-md-4 align-self-center">
                            <img src="{{ $account->profile_photo ? asset('storage/' . $account->profile_photo) : asset('https://placehold.co/400x600') }}" 
                                 alt="{{ $account->name }}" class="img-fluid img-thumbnail">
                        </div>
                        <div class="col-md-8">
                            <div class="row">
                                <div class="col-12">
                                    <br>
                                    <div class="form-group">
                                        <p class="h3 w-50 m-auto text-center">{{ $account->name }}</p>
                                    </div>
                                    <hr>
                                    <div class="form-group text-align-left">
                                        <label for="email">Email</label>
                                        <p>{{ $account->email }}</p>
                                    </div>
                                    <div class="form-group">
                                        <label for="Role">Peran</label>
                                        <p>
                                            @if ($account->role == 'admin') 
                                                Administrator
                                            @elseif ($account->role == 'librarian')
                                                Pustakawan
                                            @else
                                                {{ $account->role }}
                                            @endif
                                        </p>
                                    </div>
                                    
                                    <div class="form-group">
                                        <a href="{{ route('account.edit', $account->id) }}" class="btn btn-primary mt-3"><i class="fas fa-edit mr-1"></i> Edit Akun</a>
                                    </div>
                                </div>
                            </div>
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
