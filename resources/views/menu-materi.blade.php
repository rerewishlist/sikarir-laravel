@extends('layouts.content-guest')
@section('title', 'Materi Page')
@section('menuMateri', 'active')
@section('content-guest')

    <main class="main">

        <!-- Page Title -->
        <div class="page-title" data-aos="fade">
            <div class="container d-lg-flex justify-content-between align-items-center">
                <h1 class="mb-2 mb-lg-0">Materi Terbaru</h1>
                <nav class="breadcrumbs">
                    <ol>
                        <li><a href="{{ Route('dashboard') }}">Home</a></li>
                        <li class="current">Materi</li>
                    </ol>
                </nav>
            </div>
        </div><!-- End Page Title -->

        <!-- Service Details Section -->
        <section id="service-details" class="service-details section">
            <div class="container">
                <div class="row gy-5">
                    @if ($materis->count() > 0)
                        <div class="col-lg-3" data-aos="fade-up" data-aos-delay="100">
                            <div class="service-box">
                                <div class="services-list">
                                    <form action="">
                                        <input type="text" name="search_materi" class="form-control mb-3" placeholder="Cari judul materi..."
                                            value="{{ request('search_materi') }}">
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
                                        <button type="submit" class="btn btn-primary mt-3">Cari</button>
                                    </form>
                                </div>
                            </div><!-- End Services List -->
                        </div>

                        <div class="col-lg-9 ps-lg-5" data-aos="fade-up" data-aos-delay="200">
                            @foreach ($materis as $item)
                                <a href="{{ Route('user.materi.detail', $item->id) }}">
                                    <div class="d-flex align-items-center mb-2">
                                        <div class="col-md-1">
                                            <div class="icon-circle">
                                                <i class="bi bi-blockquote-left"></i>
                                            </div>
                                        </div>
                                        <div class="d-flex flex-column">
                                            <span style="font-size: 0.8em; color: gray;">
                                                <b>
                                                    {{ $item->admin->nama }}
                                                </b>
                                                , memposting materi baru pada {{ $item->created_at->translatedFormat('j F Y, H:i A') }}
                                            </span>
                                            <h3>
                                                {{ $item->judul }}
                                            </h3>
                                        </div>
                                    </div>
                                    <hr>
                                </a>
                            @endforeach

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

                        </div>
                    @else
                        <div class="col-lg-9 ps-lg-5" data-aos="fade-up" data-aos-delay="200">
                            <div class="mb-5">
                                <h3>Belum ada materi</h3>
                            </div>
                        </div>
                    @endif
                </div>
            </div>

        </section><!-- /Service Details Section -->
    </main>

    <script>
        window.addEventListener('load', function() {
            // Menghapus parameter pencarian dari URL saat halaman di-refresh
            var url = new URL(window.location.href);
            url.searchParams.delete('filter_tanggal');
            url.searchParams.delete('search_materi');
            window.history.replaceState({}, document.title, url.toString());
        });
    </script>
    <style>
        .icon-circle {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 50px;
            /* Sesuaikan ukuran lebar */
            height: 50px;
            /* Sesuaikan ukuran tinggi */
            border-radius: 50%;
            background-color: #828282;
            /* Warna latar belakang abu-abu */
        }

        .icon-circle i {
            font-size: 24px;
            /* Sesuaikan ukuran ikon */
            color: #ffffff;
            /* Warna ikon menjadi putih */
        }
    </style>
@endsection
