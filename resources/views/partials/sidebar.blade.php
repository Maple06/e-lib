<style>
    div.circle-avatar{
        width: 37px;
        height: auto;

        padding-top: 100%;

        border-radius: 50%;

        background-position-y: center;
        background-position-x: center;
        background-repeat: no-repeat;

        background-size: cover;
    }
</style>
@php
    $app = json_decode(File::get(base_path('app_info.json')));
@endphp
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="/" class="brand-link">
        <img src="{{ asset($app->logo_path) }}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light">{{ $app->name }}</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <div class="circle-avatar" style="background-image:url({{ asset('storage/' . Auth::user()->profile_photo) }})" alt="User Image"></div>
                {{-- <img src="{{ asset('storage/' . Auth::user()->profile_photo) }}" class="circle-avatar elevation-2" alt="User Image"> --}}
            </div>
            <div class="info">
                <a href="#" class="d-block">{{ Auth::user()->name }}</a>
            </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                data-accordion="false">

                <li class="nav-item">
                    <a href="{{ route('dashboard') }}" class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>
                            Dashboard
                        </p>
                    </a>
                </li>

                {{-- Roles --}}
                <li class="nav-header">Peran</li>
                @if (Auth::user()->role === 'admin')
                    <li class="nav-item">
                        <a href="{{ route('users.index') }}" class="nav-link {{ request()->routeIs('users.*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-user-friends"></i>
                            <p>
                                Pengguna
                            </p>
                        </a>
                    </li>
                @endif

                <li class="nav-item">
                    <a href="{{ route('members.index') }}" class="nav-link {{ request()->routeIs('members.*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-users"></i>
                        <p>
                            Anggota
                        </p>
                    </a>
                </li>

                {{-- Management --}}
                <li class="nav-header">Manajemen</li>
                <li class="nav-item">
                    <a href="{{ route('books.index') }}" class="nav-link {{ request()->routeIs('books.*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-book"></i>
                        <p>
                            Buku
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('categories.index') }}" class="nav-link {{ request()->routeIs('categories.*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-list"></i>
                        <p>
                            Kategori
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('publishers.index') }}" class="nav-link {{ request()->routeIs('publishers.*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-print"></i>
                        <p>
                            Penerbit
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('borrowings.index') }}" class="nav-link {{ request()->routeIs('borrowings.*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-file"></i>
                        <p>
                            Penyewaan
                        </p>
                    </a>
                </li>

                {{-- Sample pages --}}
                <li class="nav-header">Halaman Contoh</li>
                <li class="nav-item">
                    <a href="{{ route('samples.datepicker') }}" class="nav-link {{ request()->routeIs('samples.datepicker') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-calendar"></i>
                        <p>
                            Date Picker
                        </p>
                    </a>
                </li>
                
                {{-- Settings --}}
                <li class="nav-header">Pengaturan</li>
                <li class="nav-item">
                    <a href="{{ route('account.show', Auth::user()->id) }}" class="nav-link {{ request()->routeIs('account.*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-users-cog"></i>
                        <p>
                            Akun
                        </p>
                    </a>
                </li>
                @if (Auth::user()->role === 'admin')
                <li class="nav-item">
                    <a href="{{ route('app.index') }}" class="nav-link {{ request()->routeIs('app.*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-cog"></i>
                        <p>
                            Aplikasi
                        </p>
                    </a>
                </li>
                @endif
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
