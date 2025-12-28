@extends('layouts.main')
@section('title', 'Data Jurusan')
@section('content')
    <main id="main" class="main">

        <div class="pagetitle">
            @if (session()->has('success'))
                <div class="alert alert-primary alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            <h1>Data Jurusan
<button type="button" class="btn btn-link p-0" data-bs-toggle="modal" data-bs-target="#infoModal">
    <i class="bi bi-question-circle fs-5"></i>
</button>
            </h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active">Data Jurusan</li>
                </ol>
            </nav>
        </div><!-- End Page Title -->

        <section class="section">
            <div class="row">

                @include('jurusan.modal.tambah')

                <div class="col-lg-8">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <h5 class="card-title">Table Data Jurusan</h5>
                                <!-- Form Pencarian -->
                                <form method="GET" action="{{ url('/admin/datajurusan') }}" class="d-flex search-form">
                                    <input style="margin-right: 10px;" type="text" name="search_jurusan" class="form-control"
                                        placeholder="Cari data jurusan..." value="{{ request('search_jurusan') }}">
                                    <button type="submit" class="btn btn-primary">Cari</button>
                                </form>
                                <!-- End Form Pencarian -->
                            </div>

                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th style="width: 1%" scope="col">No</th>
                                        <th style="width: 19%" scope="col">Nama</th>
                                        <th style="width: 60%" scope="col">Deskripsi</th>
                                        <th style="width: 20%" scope="col">Aksi</th>
                                    </tr>
                                </thead>
                                @if ($jurusans->count() > 0)
                                    <tbody>
                                        @foreach ($jurusans as $item)
                                            <tr>
                                                <th scope="row">
                                                    {{ ($jurusans->currentPage() - 1) * $jurusans->perPage() + $loop->iteration }}
                                                </th>
                                                <td>{{ $item->nama }}</td>
                                                <td>{{ $item->deskripsi }}</td>
                                                <td>
                                                    <!-- Button Modal Edit jurusan-->
                                                    <button type="button" class="btn btn-outline-warning" data-bs-toggle="modal"
                                                        data-bs-target="#detailModal{{ $item->id }}">
                                                        <i class="bi bi-pencil-square"></i>
                                                    </button>
                                                    <!-- End Button Modal Edit jurusan-->

                                                    <!-- Button Modal Hapus jurusan-->
                                                    <button type="button" class="btn btn-outline-danger" data-bs-toggle="modal"
                                                        data-bs-target="#deleteModal{{ $item->id }}">
                                                        <i class="bi bi-trash"></i>
                                                    </button>
                                                    <!-- End Button Modal Hapus jurusan-->
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                @else
                                    <tbody>
                                        <tr>
                                            <td colspan="4" class="text-center align-middle">
                                                Tidak ada data jurusan
                                            <td>
                                        </tr>
                                    </tbody>
                                @endif
                            </table>
                        </div>
                    </div>

                    <!-- Paginate -->
                    <nav aria-label="Page navigation example">
                        <ul class="pagination">
                            <!-- Previous Page Link -->
                            @if ($jurusans->onFirstPage())
                                <li class="page-item disabled"><span class="page-link">Previous</span></li>
                            @else
                                <li class="page-item"><a class="page-link" href="{{ $jurusans->previousPageUrl() }}">Previous</a>
                                </li>
                            @endif

                            <!-- Pagination Elements -->
                            @for ($i = 1; $i <= $jurusans->lastPage(); $i++)
                                <li class="page-item {{ $i == $jurusans->currentPage() ? 'active' : '' }}">
                                    <a class="page-link" href="{{ $jurusans->url($i) }}">{{ $i }}</a>
                                </li>
                            @endfor

                            <!-- Next Page Link -->
                            @if ($jurusans->hasMorePages())
                                <li class="page-item"><a class="page-link" href="{{ $jurusans->nextPageUrl() }}">Next</a>
                                </li>
                            @else
                                <li class="page-item disabled"><span class="page-link">Next</span></li>
                            @endif
                        </ul>
                    </nav>
                    <!-- End Paginate -->

                </div>

            </div>
        </section>

        @include('jurusan.modal.edit')
        @include('jurusan.modal.hapus')

<!-- Modal -->
<div class="modal fade" id="infoModal" tabindex="-1" aria-labelledby="infoModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl"> <!-- Menambahkan modal-lg untuk lebar lebih besar -->
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="infoModalLabel">Panduan Data Jurusan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Jurusan untuk Siswa. Setiap Jurusan tidak dapat memiliki nama yang sama. Admin/Guru dapat:<br>
                🔹 Masukan nama jurusan dalam singkatan (misal: PPLG).<br>
                🔹 Masukan deskripsi jurusan dalam nama panjang (misal: Pengembangan Perangkat Lunak dan Gim).<br>
                🔹 Tekan simpan.<br>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>
    </main><!-- End #main -->

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // AJAX untuk form edit jurusan
            @foreach ($jurusans as $item)
                document.getElementById('formEditJurusan{{ $item->id }}').addEventListener('submit', function(
                    e) {
                    e.preventDefault();
                    var form = this;

                    fetch(form.action, {
                            method: form.method,
                            body: new FormData(form),
                            headers: {
                                'X-Requested-With': 'XMLHttpRequest'
                            }
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.errors) {
                                // Tampilkan pesan kesalahan
                                Object.keys(data.errors).forEach(function(key) {
                                    var input = document.querySelector(`[name="${key}"]`);
                                    input.classList.add('is-invalid');
                                    var feedback = input.nextElementSibling;
                                    feedback.textContent = data.errors[key][0];
                                    feedback.style.display = 'block';
                                });
                            } else {
                                // Sukses, redirect ke halaman yang diinginkan
                                window.location.href = data.redirect;
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                        });
                });
            @endforeach

        });
    </script>

    <!-- Tambahkan JavaScript untuk menghapus parameter pencarian saat halaman di-refresh -->
    <script>
        window.addEventListener('load', function() {
            // Menghapus parameter pencarian dari URL saat halaman di-refresh
            var url = new URL(window.location.href);
            url.searchParams.delete('search_jurusan');
            window.history.replaceState({}, document.title, url.toString());
        });
    </script>


@endsection
