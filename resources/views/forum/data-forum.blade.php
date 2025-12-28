@extends('layouts.main')
@section('title', 'Data Forum')
@section('content')
    <main id="main" class="main">
        <div class="pagetitle">
            @if (session()->has('success'))
                <div class="alert alert-primary alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            <h1>Data Forum Diskusi
<button type="button" class="btn btn-link p-0" data-bs-toggle="modal" data-bs-target="#infoModal">
    <i class="bi bi-question-circle fs-5"></i>
</button>
            </h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active">Data Forum Diskusi</li>
                </ol>
            </nav>
        </div><!-- End Page Title -->

        <section class="section">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <h5 class="card-title">Table Data Forum Diskusi</h5>
                                <!-- Form Pencarian -->
                                <form method="GET" action="{{ url('/admin/dataforum') }}" class="d-flex search-form">
                                    <input style="margin-right: 10px;" type="text" name="search_forum" class="form-control"
                                        placeholder="Cari data foru..." value="{{ request('search_forum') }}">

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

                            <!-- Button Modal Tambah Forum-->
                            <a href="{{ route('admin.dataforum.create') }}" class="btn btn-primary mb-3">
                                <i class="bi bi-plus me-1"></i> Buat Forum
                            </a>
                            <!-- End button Modal Tambah Forum -->

                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th style="width: 1%" scope="col">No</th>
                                        <th style="width: 15%" scope="col">Judul</th>
                                        <th style="width: 16%" scope="col">Thumbnail</th>
                                        <th style="width: 10%" scope="col">Author</th>
                                        <th style="width: 5%" scope="col">Balasan</th>
                                        <th style="width: 20%" scope="col">Content</th>
                                        <th style="width: 10%"scope="col">Tanggal</th>
                                        <th style="width: 20%" scope="col">Aksi</th>
                                    </tr>
                                </thead>
                                @if ($forums->count() > 0)
                                    <tbody>
                                        @foreach ($forums as $item)
                                            <tr>
                                                <th scope="row">
                                                    {{ ($forums->currentPage() - 1) * $forums->perPage() + $loop->iteration }}
                                                </th>
                                                <td>{{ $item->judul }}</td>
                                                <td>
                                                    @if ($item->gambar)
                                                        <img src="{{ asset('storage/forum/' . $item->gambar) }}" alt="Gambar forum"
                                                            class="img-thumbnail mt-2" style="width: 150px; height: 150px; object-fit: cover;">
                                                    @endif
                                                </td>
                                                <td>
                                                    @if ($item->admin)
                                                        Admin : {{ $item->admin->nama }}
                                                    @elseif ($item->user)
                                                        Siswa : {{ $item->user->nama }}
                                                    @else
                                                        Unknown
                                                    @endif
                                                </td>
                                                <td>{{ $item->comments->count() }}</td>
                                                <td>{!! \Illuminate\Support\Str::limit(strip_tags($item->content), 150, '...') !!}</td>
                                                <td>{{ $item->created_at->translatedFormat('d F Y') }}</td>
                                                <td>
                                                    <!-- Button Chat-->
                                                    <button type="button" class="btn btn-outline-info"
                                                        onclick="window.location.href='{{ route('admin.dataforum.detail', $item->id) }}'">
                                                        <i class="bi bi-info-circle"></i>
                                                    </button>
                                                    <!-- End Chat-->

                                                    <!-- Button Chat-->
                                                    <button type="button" class="btn btn-outline-warning"
                                                        onclick="window.location.href='{{ route('admin.dataforum.edit', $item->id) }}'">
                                                        <i class="bi bi-pencil-square"></i>
                                                    </button>
                                                    <!-- End Chat-->

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
                                            <td colspan="8" class="text-center align-middle">
                                                Tidak ada data forum
                                            <td>
                                        </tr>
                                    </tbody>
                                @endif
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Paginate -->
                <nav aria-label="Page navigation example">
                    <ul class="pagination">
                        <!-- Previous Page Link -->
                        @if ($forums->onFirstPage())
                            <li class="page-item disabled"><span class="page-link">Previous</span></li>
                        @else
                            <li class="page-item"><a class="page-link" href="{{ $forums->previousPageUrl() }}">Previous</a>
                            </li>
                        @endif

                        <!-- Pagination Elements -->
                        @for ($i = 1; $i <= $forums->lastPage(); $i++)
                            <li class="page-item {{ $i == $forums->currentPage() ? 'active' : '' }}">
                                <a class="page-link" href="{{ $forums->url($i) }}">{{ $i }}</a>
                            </li>
                        @endfor

                        <!-- Next Page Link -->
                        @if ($forums->hasMorePages())
                            <li class="page-item"><a class="page-link" href="{{ $forums->nextPageUrl() }}">Next</a>
                            </li>
                        @else
                            <li class="page-item disabled"><span class="page-link">Next</span></li>
                        @endif
                    </ul>
                </nav>
                <!-- End Paginate -->

            </div>
        </section>

        @include('forum.modal.hapus')

        
        
    </main><!-- End #main -->

    <!-- Tambahkan JavaScript untuk menghapus parameter pencarian saat halaman di-refresh -->
    <script>
        window.addEventListener('load', function() {
            // Menghapus parameter pencarian dari URL saat halaman di-refresh
            var url = new URL(window.location.href);
            url.searchParams.delete('search_forum');
            url.searchParams.delete('filter_tanggal');
            window.history.replaceState({}, document.title, url.toString());
        });
    </script>


@endsection
