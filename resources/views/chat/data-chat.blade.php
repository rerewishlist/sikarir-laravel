@extends('layouts.main')
@section('title', 'Data Chat Siswa')
@section('content')
    <main id="main" class="main">

        <div class="pagetitle">
            @if (session()->has('success'))
                <div class="alert alert-primary alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            <h1>Data Chat Siswa
<button type="button" class="btn btn-link p-0" data-bs-toggle="modal" data-bs-target="#infoModal">
    <i class="bi bi-question-circle fs-5"></i>
</button>                
            </h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active">Data Chat Siswa</li>
                </ol>
            </nav>
        </div><!-- End Page Title -->

        <section class="section">
            <div class="row">
                <div class="col-lg-12">

                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <h5 class="card-title">Table Data Siswa</h5>
                                <!-- Form Pencarian -->
                                <form method="GET" action="{{ url('/admin/chat') }}" class="d-flex search-form">
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

                            <!-- Table with hoverable rows -->
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th style="width: 1%" scope="col">No</th>
                                        <th style="width: 39%" scope="col">Nama</th>
                                        <th style="width: 35%" scope="col">Kelas Jurusan</th>
                                        <th style="width: 10%"scope="col">No HP</th>
                                        <th style="width: 15%" scope="col">Aksi</th>
                                    </tr>
                                </thead>
                                @if ($users->count() > 0)
                                    <tbody>
                                        @foreach ($users as $item)
                                            <tr>
                                                <th scope="row">
                                                    {{ ($users->currentPage() - 1) * $users->perPage() + $loop->iteration }}
                                                </th>
                                                <td>{{ $item->nama }}</td>
                                                <td>{{ $item->kelas }} {{ $item->nama_jurusan }} {{ $item->subkelas }}</td>
                                                <td>{{ $item->nohp }}</td>
                                                <td>
                                                    <!-- Button Modal Edit Siswa-->
                                                    <button type="button" class="btn btn-info" data-bs-toggle="modal"
                                                        data-bs-target="#detailModal{{ $item->id }}">
                                                        <i class="bi bi-info-circle"></i>
                                                    </button>
                                                    <!-- End Button Modal Edit Siswa-->
                                                    <!-- Button Chat-->
                                                    <button type="button" class="btn btn-success"
                                                        onclick="window.location.href='{{ route('admin.chat.detail', $item->id) }}'">
                                                        <i class="bi bi-chat-dots"></i>
                                                    </button>
                                                    <!-- End Chat-->
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                @else
                                    <tbody>
                                        <tr>
                                            <td colspan="5" class="text-center align-middle">
                                                Tidak ada data chat siswa
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

    </main><!-- End #main -->

            <!-- Modal -->
<div class="modal fade" id="infoModal" tabindex="-1" aria-labelledby="infoModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl"> <!-- Menambahkan modal-lg untuk lebar lebih besar -->
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="infoModalLabel">Panduan Chatting dengan Siswa</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Tempat chat pribadi yang memungkinkan siswa dan guru untuk berkomunikasi secara langsung. Di sini, guru dapat membimbing siswa secara pribadi mengenai pilihan karir, perkuliahan, serta persiapan menghadapi dunia kerja.<br>
                💡 Cara Memulai Chat:<br>
                🔹 Guru dapat menunggu siswa yang akan menghubungi terlebih dahulu<br>
                🔹 Jika Guru ingin memulai chat terlebih dahulu, Guru dapat menekan fitur "Data Siswa" dan menekan tombol chat berwarna biru dalam kolom aksi salah satu siswa<br>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>

    <!-- Modal Edit Siswa-->
    @foreach ($users as $item)
        <div class="modal fade" id="detailModal{{ $item->id }}" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Data Detail Siswa</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="formEditSiswa{{ $item->id }}" class="row g-3">
                            <div class="col-md-12">
                                <div class="form-floating">
                                    <input class="form-control" type="text" id="floatingNama" name="namaupdate" value="{{ $item->nama }}"
                                        placeholder="Nama" disabled>
                                    <label for="floatingNama">Nama</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input class="form-control" type="text" id="floatingNis" name="nisupdate" value="{{ $item->nis }}"
                                        placeholder="NIS" disabled>
                                    <label for="floatingNis">NIS</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input class="form-control" type="text" id="floatingNis" name="levelupdate" value="{{ $item->level }}"
                                        placeholder="Level" disabled>
                                    <label for="floatingNis">Level</label>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-floating">
                                    <input class="form-control" type="text" id="floatingNis" name="levelupdate"
                                        value="{{ $item->kelas }} {{ $item->nama_jurusan }} {{ $item->subkelas }}" placeholder="Kelas Jurusan"
                                        disabled>
                                    <label for="floatingNis">Kelas Jurusan</label>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-floating">
                                    <input class="form-control" type="text" id="floatingNis" name="jenis_kelaminupdate"
                                        value="{{ $item->jenis_kelamin }}" placeholder="Jenis Kelamin" disabled>
                                    <label for="floatingNis">Jenis Kelamin</label>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-floating">
                                    <div class="form-floating">
                                        <input class="form-control" type="text" id="floatingNis" name="tempat_lahirupdate"
                                            value="{{ $item->tempat_lahir }}" placeholder="Jenis Kelamin" disabled>
                                        <label for="floatingNis">Tempat Lahir</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-floating">
                                    <div class="form-floating">
                                        <input class="form-control" type="text" id="floatingNis" name="tanggal_lahir"
                                            value="{{ date('d-m-Y', strtotime($item->tanggal_lahir)) }}" placeholder="Jenis Kelamin" disabled>
                                        <label for="floatingNis">Tanggal Lahir</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-floating">
                                    <div class="form-floating">
                                        <input class="form-control" type="text" id="floatingNis" name="alamat" value="{{ $item->alamat }}"
                                            placeholder="Alamat" disabled>
                                        <label for="floatingNis">Alamat</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-floating">
                                    <div class="form-floating">
                                        <input class="form-control" type="text" id="floatingNis" name="nohp" value="{{ $item->nohp }}"
                                            placeholder="No HP" disabled>
                                        <label for="floatingNis">No HP</label>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Kembali</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
    <!-- End Modal Edit Siswa-->

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
