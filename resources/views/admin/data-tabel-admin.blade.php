@extends('layouts.main')
@section('title', 'Data Admin')
@section('content')
    <main id="main" class="main">

        <div class="pagetitle">
            @if (session()->has('success'))
                <div class="alert alert-primary alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            <h1>Data Admin</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active">Data Admin</li>
                </ol>
            </nav>
        </div><!-- End Page Title -->

        <section class="section">
            <div class="row">
                <div class="col-lg-12">

                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <h5 class="card-title">Table Data Admin</h5>
                            </div>

                            <div class="d-flex justify-content-between align-items-start mb-3">
                                <!-- Button Modal Tambah Siswa-->
                                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#tambahModal">
                                    <i class="bi bi-plus"></i> Tambah Data
                                </button>
                                <!-- End button Modal Tambah Siswa -->
                            </div>

                            <!-- Table with hoverable rows -->
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th style="width: 1%" scope="col">No</th>
                                        <th style="width: 34%" scope="col">Nama</th>
                                        <th style="width: 20%" scope="col">Username</th>
                                        <th style="width: 15%" scope="col">Level</th>
                                        <th style="width: 15%"scope="col">No HP</th>
                                        <th style="width: 15%" scope="col">Aksi</th>
                                    </tr>
                                </thead>
                                @if ($alladmins->count() > 0)
                                    <tbody>
                                        @foreach ($alladmins as $item)
                                            <tr>
                                                <th scope="row">
                                                    {{ ($alladmins->currentPage() - 1) * $alladmins->perPage() + $loop->iteration }}
                                                </th>
                                                <td>{{ $item->nama }}</td>
                                                <td>{{ $item->username }}</td>
                                                <td>{{ $item->level }}</td>
                                                <td>{{ $item->nohp }}</td>
                                                <td>

                                                    <!-- Button Modal Edit Siswa-->
                                                    <button type="button" class="btn btn-outline-warning" data-bs-toggle="modal"
                                                        data-bs-target="#detailModal{{ $item->id }}">
                                                        <i class="bi bi-pencil-square"></i>
                                                    </button>
                                                    <!-- End Button Modal Edit Siswa-->

                                                    <!-- Button Modal Hapus Siswa-->
                                                    <button type="button" class="btn btn-outline-danger" data-bs-toggle="modal"
                                                        data-bs-target="#deleteModal{{ $item->id }}">
                                                        <i class="bi bi-trash"></i>
                                                    </button>
                                                    <!-- End Button Modal Hapus Siswa-->

                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                @else
                                    <tbody>
                                        <tr>
                                            <td colspan="7" class="text-center align-middle">
                                                Tidak ada data admin
                                            <td>
                                        </tr>
                                    </tbody>
                                @endif
                            </table>
                            <!-- End Table with stripped rows -->

                        </div>
                    </div>
                </div>
            </div>

            <!-- Paginate -->
            <nav aria-label="Page navigation example">
                <ul class="pagination">
                    <!-- Previous Page Link -->
                    @if ($alladmins->onFirstPage())
                        <li class="page-item disabled"><span class="page-link">Previous</span></li>
                    @else
                        <li class="page-item"><a class="page-link" href="{{ $alladmins->previousPageUrl() }}">Previous</a>
                        </li>
                    @endif

                    <!-- Pagination Elements -->
                    @for ($i = 1; $i <= $alladmins->lastPage(); $i++)
                        <li class="page-item {{ $i == $alladmins->currentPage() ? 'active' : '' }}">
                            <a class="page-link" href="{{ $alladmins->url($i) }}">{{ $i }}</a>
                        </li>
                    @endfor

                    <!-- Next Page Link -->
                    @if ($alladmins->hasMorePages())
                        <li class="page-item"><a class="page-link" href="{{ $alladmins->nextPageUrl() }}">Next</a></li>
                    @else
                        <li class="page-item disabled"><span class="page-link">Next</span></li>
                    @endif
                </ul>
            </nav>
            <!-- End Paginate -->
        </section>

        @include('admin.modal.tambah')
        @include('admin.modal.edit')
        @include('admin.modal.hapus')

    </main><!-- End #main -->

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // AJAX untuk form tambah siswa
            document.getElementById('formTambahAdmin').addEventListener('submit', function(e) {
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
                    });;
            });

            // AJAX untuk form edit admin
            @foreach ($alladmins as $item)
                document.getElementById('formEditAdmin{{ $item->id }}').addEventListener('submit', function(
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

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Ambil pesan sukses dari sessionStorage jika ada
            var successMessage = sessionStorage.getItem('successMessage');
            if (successMessage) {
                // Tampilkan pesan sukses
                var alertDiv = document.createElement('div');
                alertDiv.classList.add('alert', 'alert-primary', 'alert-dismissible', 'fade', 'show');
                alertDiv.setAttribute('role', 'alert');
                alertDiv.innerHTML = successMessage +
                    '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>';
                document.body.insertBefore(alertDiv, document.body.firstChild);
                sessionStorage.removeItem('successMessage');
            }
        });
    </script>

@endsection
