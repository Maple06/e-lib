@extends('layouts.app')

@section('title', 'Daftar Buku')

@section('page-header')
<div class="row">
    <div class="col-12">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Daftar Buku</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('publishers.index') }}"><i class="fas fa-list mr-1"></i> Penerbit</a></li>
                            <li class="breadcrumb-item active">Daftar Buku</li>
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
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <a href="{{ route('books.create') }}" class="btn btn-primary"><i class="fas fa-plus mr-1"></i>Tambah Buku</a>
                </div>
                <div class="card-body">
                    <table table id="booksTable" class="table table-bordered table-striped dataTable dtr-inline">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Judul</th>
                                <th>ISBN</th>
                                <th>Pengarang</th>
                                <th>Tahun Terbit</th>
                                <th>Kategori</th>
                                <th>Penerbit</th>
                                <th>Stok</th>
                                <th>Harga Sewa</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($books as $book)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $book->title }}</td>
                                    <td>{{ $book->isbn }}</td>
                                    <td>{{ $book->author }}</td>
                                    <td>{{ $book->published_year }}</td>
                                    <td>{{ $book->category->name }}</td>
                                    <td>{{ $book->publisher->name }}</td>
                                    <td>{{ $book->stock }}</td>
                                    <td>{{ formatRp($book->rental_price) }}</td>
                                    <td>
                                        <div class="btn-group dropleft">
                                            <button type="button" class="btn btn-secondary btn-sm">Pilih</button>
                                            <button type="button" class="btn btn-secondary btn-sm dropdown-toggle dropdown-toggle-split" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                <span class="sr-only">Toggle Dropdown</span>
                                            </button>
                                            <div class="dropdown-menu dropdown-menu-left">
                                                <a class="dropdown-item" href="{{ route('books.show', $book->id) }}">Detail</a>
                                                <a class="dropdown-item" href="{{ route('books.edit', $book->id) }}">Edit</a>
                                                <a class="dropdown-item" href="#" onclick="confirmDelete({{ $book->id }}, '{{ $book->title }}')">Hapus</a>
                                            </div>
                                        </div>
                                        <form id="delete-form-{{ $book->id }}" action="{{ route('books.destroy', $book->id) }}" method="POST" style="display: none;">
                                            @csrf
                                            @method('DELETE')
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('css')
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.7.1/css/buttons.dataTables.min.css">
@endsection

@section('js')
<script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.7.1/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.7.1/js/buttons.flash.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.7.1/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.7.1/js/buttons.print.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
$(document).ready(function() {
    $('#booksTable').DataTable({
        dom: 'Bfrtip',
        buttons: [
            'copy', 'csv', 'excel', 'pdf', 'print'
        ]
    });
});

function confirmDelete(bookId, bookTitle) {
    Swal.fire({
        title: 'Apakah Anda yakin?',
        text: "Setelah dihapus, Anda tidak dapat memulihkan buku \"" + bookTitle + "\"!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Ya, hapus!',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
            document.getElementById('delete-form-' + bookId).submit();
        }
    })
}

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
