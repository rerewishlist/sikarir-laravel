@extends('layouts.main')
@section('title', 'Data Siswa')
@section('content')
    <main id="main" class="main">

        <div class="pagetitle">
            @if (session()->has('success'))
                <div class="alert alert-primary alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            <h1>Data Siswa
<button type="button" class="btn btn-link p-0" data-bs-toggle="modal" data-bs-target="#infoModal">
    <i class="bi bi-question-circle fs-5"></i>
</button>
            </h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active">Data Siswa</li>
                </ol>
            </nav>
        </div><!-- End Page Title -->

        <section class="section">
            <div class="row">
                <div class="col-lg-12">

                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <h5 class="card-title">Table Data Siswa</h5>
                                <!-- Form Pencarian -->
                                <form method="GET" action="{{ url('/admin/datasiswa') }}" class="d-flex search-form">
                                    <input style="margin-right: 10px;" type="text" name="search" class="form-control"
                                        placeholder="Cari data nama siswa..." value="{{ request('search') }}">

                                    <!-- Dropdown untuk memilih kelas -->
                                    <select name="kelas" class="form-control" style="margin-right: 10px;">
                                        <option value="">Semua Kelas</option>
                                        @foreach ($kelasOptions as $kelas)
                                            <option value="{{ $kelas }}" {{ request('kelas') == $kelas ? 'selected' : '' }}>{{ $kelas }}
                                            </option>
                                        @endforeach
                                    </select>

                                    <!-- Dropdown untuk memilih jurusan -->
                                    <select name="jurusan" class="form-control" style="margin-right: 10px;">
                                        <option value="">Semua Jurusan</option>
                                        @foreach ($jurusanOptions as $jurusan)
                                            <option value="{{ $jurusan->id }}" {{ request('jurusan') == $jurusan->id ? 'selected' : '' }}>
                                                {{ $jurusan->nama }}</option>
                                        @endforeach
                                    </select>

                                    <button type="submit" class="btn btn-primary">Cari</button>
                                </form>
                                <!-- End Form Pencarian -->
                            </div>

                            <div class="d-flex justify-content-between align-items-start mb-3">
                                <!-- Button Modal Tambah Siswa-->
                                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#tambahModal">
                                    <i class="bi bi-plus"></i> Tambah Data
                                </button>
                                <!-- End button Modal Tambah Siswa -->
                                <!-- Form Upload -->
                                <form action="{{ route('datasiswa.upload') }}" method="POST" enctype="multipart/form-data"
                                    class="d-flex align-items-start">
                                    @csrf
                                    <div class="d-flex flex-column" style="margin-right: 10px;">
                                        <input class="form-control @error('file') is-invalid @enderror" type="file" id="formFile" name="file">
                                        <div class="invalid-feedback" style="display: block;">
                                            <a href="{{ asset('assets/datasiswa.xlsx') }}" target="_blank">
                                                Format data file
                                            </a>
                                        </div>
                                        <!-- Menampilkan pesan error untuk input file -->
                                        @error('file')
                                            <div class="invalid-feedback" style="display: block;">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                    <button type="submit" class="btn btn-secondary">Upload</button>
                                </form>
                            </div>



                            <!-- Table with hoverable rows -->
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th style="width: 1%" scope="col">No</th>
                                        <th style="width: 9%" scope="col">NIS</th>
                                        <th style="width: 25%" scope="col">Nama</th>
                                        <th style="width: 15%" scope="col">Kelas</th>
                                        <th style="width: 22%"scope="col">Tempat Tanggal Lahir</th>
                                        <th style="width: 10%"scope="col">No HP</th>
                                        <th style="width: 18%" scope="col">Aksi</th>
                                    </tr>
                                </thead>
                                @if ($users->count() > 0)
                                    <tbody>
                                        @foreach ($users as $item)
                                            <tr>
                                                <th scope="row">
                                                    {{ ($users->currentPage() - 1) * $users->perPage() + $loop->iteration }}
                                                </th>
                                                <td>{{ $item->nis }}</td>
                                                <td>{{ $item->nama }}</td>
                                                <td>{{ $item->kelas }} {{ $item->nama_jurusan }} {{ $item->subkelas }}</td>
                                                <td>{{ $item->tempat_lahir }}, {{ \Carbon\Carbon::parse($item->tanggal_lahir)->format('d/m/Y') }}</td>
                                                <td>{{ $item->nohp }}</td>
                                                <td>
                                                    <!-- Button Chat-->
                                                    <button type="button" class="btn btn-outline-info"
                                                        onclick="window.location.href='{{ route('admin.chat.detail', $item->id) }}'">
                                                        <i class="bi bi-chat-dots"></i>
                                                    </button>
                                                    <!-- End Chat-->

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
                                                Tidak ada data siswa
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
                    @if ($users->onFirstPage())
                        <li class="page-item disabled"><span class="page-link">Previous</span></li>
                    @else
                        <li class="page-item"><a class="page-link" href="{{ $users->previousPageUrl() }}">Previous</a>
                        </li>
                    @endif

                    <!-- Pagination Elements -->
                    @for ($i = 1; $i <= $users->lastPage(); $i++)
                        <li class="page-item {{ $i == $users->currentPage() ? 'active' : '' }}">
                            <a class="page-link" href="{{ $users->url($i) }}">{{ $i }}</a>
                        </li>
                    @endfor

                    <!-- Next Page Link -->
                    @if ($users->hasMorePages())
                        <li class="page-item"><a class="page-link" href="{{ $users->nextPageUrl() }}">Next</a></li>
                    @else
                        <li class="page-item disabled"><span class="page-link">Next</span></li>
                    @endif
                </ul>
            </nav>
            <!-- End Paginate -->
        </section>

        @include('siswa.modal.tambah')
        @include('siswa.modal.edit')
        @include('siswa.modal.hapus')

<!-- Modal -->
<div class="modal fade" id="infoModal" tabindex="-1" aria-labelledby="infoModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl"> <!-- Menambahkan modal-lg untuk lebar lebih besar -->
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="infoModalLabel">Panduan Data Siswa</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Admin atau Guru bisa:<br>
                ✅ Menambahkan siswa secara manual satu per satu.<br>
                ✅ Menambahkan siswa secara massal (Menggunakan Excel).<br>
                💡 Akses Guru atau Admin:<br>
                🔹 Membuat Data Siswa Baru dengan menekan tombol "Buat Forum" atau "Upload"<br>
                🔹 Memulai Chatting pada Siswa dengan menekan tombol Chat berwarna biru di kolom aksi salah satu siswa.<br>
                🔹 Melihat dan Mengubah Detail Siswa dengan menekan tombol pensil berwarna kuning di kolom aksi salah satu siswa.<br>
                🔹 Menghapus Siswa dengan menekan tombol tempat sampah berwarna merah di kolom aksi salah satu siswa.<br><br>
                💡 Cara Menambahkan Data Siswa secara manual:<br>
                🔹 Tekan tombol "+ Tambah Data".<br>
                🔹 Masukan data informasi siswa dengan lengkap.<br>
                🔹 Tekan simpan.<br><br>
                💡 Cara Menambahkan Data Siswa secara massal:<br>
                🔹 Tekan tombol "Format data file" untuk mengunduh format file pada excel.<br>
                🔹 Masukan data informasi siswa dengan lengkap dalam format file.<br>
                🔹 Upload file excel dengan menekan tombol "Pilih File".<br>
                🔹 Tekan upload.<br><br>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>        
    </main><!-- End #main -->

    <script>
        document.querySelector('.btn').addEventListener('click', function() {
            document.getElementById('formFileExcel').click();
        });
    </script>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // AJAX untuk form tambah siswa
            document.getElementById('formTambahSiswa').addEventListener('submit', function(e) {
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

            // AJAX untuk form edit siswa
            @foreach ($users as $item)
                document.getElementById('formEditSiswa{{ $item->id }}').addEventListener('submit', function(
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

    <!-- Tambahkan JavaScript untuk menghapus parameter pencarian saat halaman di-refresh -->
    <script>
        window.addEventListener('load', function() {
            // Menghapus parameter pencarian dari URL saat halaman di-refresh
            var url = new URL(window.location.href);
            url.searchParams.delete('search');
            url.searchParams.delete('kelas');
            url.searchParams.delete('jurusan');
            window.history.replaceState({}, document.title, url.toString());
        });
    </script>



@endsection
