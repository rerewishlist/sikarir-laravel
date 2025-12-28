@extends('layouts.main')
@section('title', 'Data Berita')
@section('content')
    <main id="main" class="main">
        <div class="pagetitle">
            @if (session()->has('success'))
                <div class="alert alert-primary alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            <h1>Data Berita
<button type="button" class="btn btn-link p-0" data-bs-toggle="modal" data-bs-target="#infoModal">
    <i class="bi bi-question-circle fs-5"></i>
</button>
            </h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active">Data Berita</li>
                </ol>
            </nav>
        </div><!-- End Page Title -->

        <section class="section">
            <div class="row">
                <div class="col-lg-12">

                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <h5 class="card-title">Table Data Berita</h5>
                                <!-- Form Pencarian -->
                                <form method="GET" action="{{ url('/admin/databerita') }}" class="d-flex search-form">
                                    <input style="margin-right: 10px;" type="text" name="search_berita" class="form-control"
                                        placeholder="Cari judul berita..." value="{{ request('search_berita') }}">

                                    @php
                                        $uniqueDates = collect($dates)
                                            ->map(function ($date) {
                                                return \Carbon\Carbon::parse($date)->format('Y-m');
                                            })
                                            ->unique();
                                    @endphp

                                    <select name="filter_tanggal" class="form-control" style="margin-right: 10px;">
                                        <option value="">-- Pilih Bulan dan Tahun --</option>
                                        @foreach ($uniqueDates as $date)
                                            <option value="{{ $date }}" {{ request('filter_tanggal') == $date ? 'selected' : '' }}>
                                                {{ \Carbon\Carbon::parse($date)->format('F Y') }}
                                            </option>
                                        @endforeach
                                    </select>

                                    <!-- Dropdown untuk memilih kategori -->
                                    <select name="filter_kategori" class="form-control" style="margin-right: 10px;">
                                        <option value="">-- Pilih Kategori --</option>
                                        @foreach ($kategoris as $kategori)
                                            <option value="{{ $kategori->id }}" {{ request('filter_kategori') == $kategori->id ? 'selected' : '' }}>
                                                {{ $kategori->nama }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <button type="submit" class="btn btn-primary">Cari</button>
                                </form>
                                <!-- End Form Pencarian -->
                            </div>

                            <!-- Button Modal Tambah Berita-->
                            <a href="{{ route('databerita.create') }}" class="btn btn-primary mb-3">
                                <i class="bi bi-plus me-1"></i> Tambah Data
                            </a>
                            <!-- End button Modal Tambah Berita -->

                            <!-- Table with hoverable rows -->
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th style="width: 1%" scope="col">No</th>
                                        <th style="width: 20%" scope="col">Judul</th>
                                        <th style="width: 15%" scope="col">Author</th>
                                        <th style="width: 15%" scope="col">Slug</th>
                                        <th style="width: 19%" scope="col">Kategori</th>
                                        <th style="width: 10%"scope="col">Tanggal</th>
                                        <th style="width: 20%"scope="col">aksi</th>
                                    </tr>
                                </thead>
                                @if ($beritas->count() > 0)
                                    <tbody>
                                        @foreach ($beritas as $item)
                                            <tr>
                                                <th scope="row">
                                                    {{ ($beritas->currentPage() - 1) * $beritas->perPage() + $loop->iteration }}
                                                </th>
                                                <td>{{ $item->judul }}</td>
                                                <td>{{ $item->admin->username }}</td>
                                                <td>{{ $item->slug }}</td>
                                                <td>
                                                    @foreach ($item->kategoris as $kategori)
                                                        <span class="badge bg-primary">{{ $kategori->nama }}</span>
                                                    @endforeach
                                                </td>
                                                <td>{{ $item->created_at->translatedFormat('d F Y') }}</td>
                                                <td>
                                                    <!-- Button Chat-->
                                                    <button type="button" class="btn btn-outline-info"
                                                        onclick="window.location.href='{{ route('databerita.detail', $item->id) }}'">
                                                        <i class="bi bi-info-circle"></i>
                                                    </button>
                                                    <!-- End Chat-->

                                                    <!-- Button Modal Edit Siswa-->
                                                    <button type="button" class="btn btn-outline-warning"
                                                        onclick="window.location.href='{{ route('databerita.edit', $item->id) }}'">
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
                                                Tidak ada data berita
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
                    @if ($beritas->onFirstPage())
                        <li class="page-item disabled"><span class="page-link">Previous</span></li>
                    @else
                        <li class="page-item"><a class="page-link" href="{{ $beritas->previousPageUrl() }}">Previous</a>
                        </li>
                    @endif

                    <!-- Pagination Elements -->
                    @for ($i = 1; $i <= $beritas->lastPage(); $i++)
                        <li class="page-item {{ $i == $beritas->currentPage() ? 'active' : '' }}">
                            <a class="page-link" href="{{ $beritas->url($i) }}">{{ $i }}</a>
                        </li>
                    @endfor

                    <!-- Next Page Link -->
                    @if ($beritas->hasMorePages())
                        <li class="page-item"><a class="page-link" href="{{ $beritas->nextPageUrl() }}">Next</a></li>
                    @else
                        <li class="page-item disabled"><span class="page-link">Next</span></li>
                    @endif
                </ul>
            </nav>
            <!-- End Paginate -->
        </section>


        @include('berita.modal.hapus')

<!-- Modal -->
<div class="modal fade" id="infoModal" tabindex="-1" aria-labelledby="infoModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl"> <!-- Menambahkan modal-lg untuk lebar lebih besar -->
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="infoModalLabel">Panduan Data Berita</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Tempat membagikan berita berisikan informasi terbaru seputar lowongan pekerjaan dan dunia perkuliahan. Admin/Guru dapat:<br>
                ✅ Membuat berita baru tentang pekerjaan ataupun perkuliahan.<br>
                💡 Akses Guru atau Admin:<br>
                🔹 Membuat Berita Baru dengan menekan tombol "+ Tambah Data"<br>
                🔹 Melihat Detail Berita dengan menekan tombol informasi berwarna biru di kolom aksi sebuah berita.<br>
                🔹 Mengubah Berita dengan menekan tombol pensil berwarna kuning di kolom aksi sebuah berita.<br>
                🔹 Menghapus Berita yang Tidak Relevan dengan menekan tombol tempat sampah berwarna merah di kolom aksi sebuah berita.<br><br>
                <!-- 💡 Cara Membuat Forum:<br>
                🔹 Tekan tombol "Buat Forum".<br>
                🔹 Masukan judul forum, gambar (opsional), dan juga isi konten dengan topik yang akan dibahas.<br>
                🔹 Tekan simpan.<br><br>
                💡 Cara Berkomentar Dalam Forum:<br>
                🔹 Tekan tombol icon "i" berwarna biru pada kolom aksi sebuah forum.<br>
                🔹 Masukan isi dalam komentar.<br>
                🔹 Tekan kirim.<br> -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>

    </main><!-- End #main -->

    <!-- Tambahkan JavaScript untuk menghapus parameter pencarian saat halaman di-refresh -->
    <script>
        window.addEventListener('load', function() {
            // Menghapus parameter pencarian dari URL saat halaman di-refresh
            var url = new URL(window.location.href);
            url.searchParams.delete('search_berita');
            url.searchParams.delete('filter_tanggal');
            url.searchParams.delete('filter_kategori');
            window.history.replaceState({}, document.title, url.toString());
        });
    </script>
@endsection
