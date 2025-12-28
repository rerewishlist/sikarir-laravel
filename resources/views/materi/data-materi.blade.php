@extends('layouts.main')
@section('title', 'Data Materi')
@section('content')
    <main id="main" class="main">
        <div class="pagetitle">
            @if (session()->has('success'))
                <div class="alert alert-primary alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            @if (auth()->user()->level == 'admin')
                <h1>Data Materi</h1>
                <nav>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Data Materi</li>
                    </ol>
                </nav>
            @elseif (auth()->user()->level == 'siswa')
                <h1>Materi</h1>
                <nav>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Materi</li>
                    </ol>
                </nav>
            @endif
        </div><!-- End Page Title -->

        <section class="section">
            <div class="row">
                <div class="col-lg-12">

                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <h5 class="card-title">Table Data Materi</h5>
                                <!-- Form Pencarian -->
                                <form method="GET" action="{{ url('/admin/datamateri') }}" class="d-flex search-form">
                                    <input style="margin-right: 10px;" type="text" name="search_materi" class="form-control"
                                        placeholder="Cari judul materi..." value="{{ request('search_materi') }}">

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

                                    <button type="submit" class="btn btn-primary">Cari</button>
                                </form>
                                <!-- End Form Pencarian -->
                            </div>

                            <!-- Button Modal Tambah materi-->
                            <a href="{{ route('datamateri.create') }}" class="btn btn-primary mb-3">
                                <i class="bi bi-plus me-1"></i> Tambah Data
                            </a>
                            <!-- End button Modal Tambah materi -->

                            <!-- Table with hoverable rows -->
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th style="width: 1%" scope="col">No</th>
                                        <th style="width: 40%" scope="col">Judul</th>
                                        <th style="width: 19%" scope="col">Author</th>
                                        <th style="width: 20%"scope="col">Tanggal</th>
                                        <th style="width: 20%"scope="col">aksi</th>
                                    </tr>
                                </thead>
                                @if ($materis->count() > 0)
                                    <tbody>
                                        @foreach ($materis as $item)
                                            <tr>
                                                <th scope="row">
                                                    {{ ($materis->currentPage() - 1) * $materis->perPage() + $loop->iteration }}
                                                </th>
                                                <td>{{ $item->judul }}</td>
                                                <td>{{ $item->admin->nama }}</td>
                                                <td>{{ $item->created_at->translatedFormat('d F Y') }}</td>
                                                <td>
                                                    <!-- Button Chat-->
                                                    <button type="button" class="btn btn-outline-info"
                                                        onclick="window.location.href='{{ route('datamateri.detail', $item->id) }}'">
                                                        <i class="bi bi-info-circle"></i>
                                                    </button>
                                                    <!-- End Chat-->
                                                    <!-- Button Modal Edit Siswa-->
                                                    <button type="button" class="btn btn-outline-warning"
                                                        onclick="window.location.href='{{ route('datamateri.edit', $item->id) }}'">
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
                                            <td colspan="5" class="text-center align-middle">
                                                Tidak ada data materi
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
                    @if ($materis->onFirstPage())
                        <li class="page-item disabled"><span class="page-link">Previous</span></li>
                    @else
                        <li class="page-item"><a class="page-link" href="{{ $materis->previousPageUrl() }}">Previous</a>
                        </li>
                    @endif

                    <!-- Pagination Elements -->
                    @for ($i = 1; $i <= $materis->lastPage(); $i++)
                        <li class="page-item {{ $i == $materis->currentPage() ? 'active' : '' }}">
                            <a class="page-link" href="{{ $materis->url($i) }}">{{ $i }}</a>
                        </li>
                    @endfor

                    <!-- Next Page Link -->
                    @if ($materis->hasMorePages())
                        <li class="page-item"><a class="page-link" href="{{ $materis->nextPageUrl() }}">Next</a></li>
                    @else
                        <li class="page-item disabled"><span class="page-link">Next</span></li>
                    @endif
                </ul>
            </nav>
            <!-- End Paginate -->
        </section>

        @include('materi.modal.hapus')

    </main><!-- End #main -->

    <!-- Tambahkan JavaScript untuk menghapus parameter pencarian saat halaman di-refresh -->
    <script>
        window.addEventListener('load', function() {
            // Menghapus parameter pencarian dari URL saat halaman di-refresh
            var url = new URL(window.location.href);
            url.searchParams.delete('search_materi');
            url.searchParams.delete('filter_tanggal');
            window.history.replaceState({}, document.title, url.toString());
        });
    </script>
@endsection
