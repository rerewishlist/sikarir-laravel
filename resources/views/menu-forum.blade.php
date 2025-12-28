@extends('layouts.content-guest')
@section('title', 'Forum Page')
@section('menuForum', 'active')
@section('content-guest')

    <main class="main">

        <!-- Page Title -->
        <div class="page-title" data-aos="fade">
            <div class="container d-lg-flex justify-content-between align-items-center">
                @if (auth()->check())
                <h1 class="mb-2 mb-lg-0">
                    Forum Terbaru
                    <button type="button" class="btn btn-link p-0" data-bs-toggle="modal" data-bs-target="#infoModal">
                        <i class="bi bi-question-circle fs-5"></i>
                    </button>
                </h1>
                @else
                    <h1 class="mb-2 mb-lg-0">
                        Forum Terpopuler
                    <button type="button" class="btn btn-link p-0" data-bs-toggle="modal" data-bs-target="#a">
                        <i class="bi bi-question-circle fs-5"></i>
                    </button>
                    </h1>
                    <nav class="breadcrumbs">
                        <ol>
                            <li><a href="{{ Route('landing') }}">Home</a></li>
                            <li class="current">Forum</li>
                        </ol>
                    </nav>
                @endif
            </div>
        </div><!-- End Page Title -->

        <!-- Service Details Section -->
        <section id="service-details" class="service-details section">

            <div class="container">
                <div class="row gy-5">
                    @if ($forums->count() > 0)
                        @if (auth()->check())
                            <div class="col-lg-3" data-aos="fade-up" data-aos-delay="100">
                                <div class="service-box">
                                    <div class="services-list text-center">
                                        <button onclick="window.location.href='{{ route('user.dataforum.create') }}'" class="btn btn-primary">
                                            <i class="bi bi-plus me-1"></i> Buat Forum Baru
                                        </button>
                                    </div>
                                </div><!-- End Services List -->

                                <div class="service-box">
                                    <div class="services-list">
                                        <form action="">
                                            <input type="text" name="search_forum" class="form-control mb-3" placeholder="Cari judul forum..."
                                                value="{{ request('search_forum') }}">
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
                        @endif

                        @if (auth()->check())
                            <div class="col-lg-9 ps-lg-5" data-aos="fade-up" data-aos-delay="200">
                            @else
                                <div class="col-lg-12 ps-lg-5" data-aos="fade-up" data-aos-delay="200">
                        @endif

                        @foreach ($forums as $item)
                            <div class="mb-5">
                                <h3>{{ $item->judul }}</h3>
                                @if ($item->gambar)
                                    <img src="{{ asset('storage/forum/' . $item->gambar) }}" alt="Gambar forum" class="img-fluid services-img">
                                @endif
                                <p>
                                    @if ($item->admin)
                                        by {{ $item->admin->level }} |
                                    @else
                                        by {{ $item->user->level }} |
                                    @endif
                                    {{ $item->created_at->translatedFormat('d F Y') }} |
                                    {{ $item->comments->count() }} balasan
                                </p>
                                <p>
                                    {!! \Illuminate\Support\Str::limit(strip_tags($item->content), 300, '...') !!}
                                </p>
                                @if (auth()->check())
                                    <a href="{{ Route('user.dataforum.detail', $item->id) }}">Selengkapnya...</a>
                                @endif
                            </div>
                        @endforeach

                        @if (auth()->check())
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
                                        <li class="page-item"><a class="page-link" href="{{ $forums->nextPageUrl() }}">Next</a></li>
                                    @else
                                        <li class="page-item disabled"><span class="page-link">Next</span></li>
                                    @endif
                                </ul>
                            </nav>
                            <!-- End Paginate -->
                        @endif
                    @else
                        @if (auth()->check())
                            <div class="col-lg-3" data-aos="fade-up" data-aos-delay="100">
                                <div class="service-box">
                                    <div class="services-list text-center">
                                        <button onclick="window.location.href='{{ route('user.dataforum.create') }}'" class="btn btn-primary">
                                            <i class="bi bi-plus me-1"></i> Buat Forum Baru
                                        </button>
                                    </div>
                                </div><!-- End Services List -->

                                <div class="service-box">
                                    <div class="services-list">
                                        <form action="">
                                            <input type="text" name="search_forum" class="form-control mb-3" placeholder="Cari judul forum..."
                                                value="{{ request('search_forum') }}">
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
                        @endif
                        <div class="col-lg-9 ps-lg-5" data-aos="fade-up" data-aos-delay="200">
                            <div class="mb-5">
                                <h3>Belum ada forum</h3>
                            </div>
                        </div>
                    @endif
                </div>

            </div>

            </div>


        </section><!-- /Service Details Section -->
<!-- Modal -->
<div class="modal fade" id="a" tabindex="-1" aria-labelledby="infoModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl"> <!-- Menambahkan modal-lg untuk lebar lebih besar -->
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="infoModalLabel">Panduan Forum Siswa</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Tempat diskusi interaktif bagi siswa dan guru untuk berbagi wawasan, bertanya, serta berdiskusi mengenai dunia kerja dan perkuliahan. Di sini, kamu bisa:<br>
                ✅ Membuat forum diskusi tentang pekerjaan, perkuliahan, atau topik lain yang bermanfaat dengan menekan tombol "+ Buat Forum Baru".<br>
                ✅ Mengomentari dan menanggapi forum yang dibuat oleh siswa maupun guru dengan menekan "Selengkapnya..." pada salah satu berita.<br>
                ✅ Berbagi pengalaman dan pengetahuan agar semua dapat belajar dan berkembang bersama.<br><br>
                💡 Silahkan Login dengan akun Anda untuk dapat menikmati kesempatan berdiskusi bersama Siswa lainnya
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="infoModal" tabindex="-1" aria-labelledby="infoModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl"> <!-- Menambahkan modal-lg untuk lebar lebih besar -->
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="infoModalLabel">Panduan Forum Siswa</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Tempat diskusi interaktif bagi siswa dan guru untuk berbagi wawasan, bertanya, serta berdiskusi mengenai dunia kerja dan perkuliahan. Di sini, kamu bisa:<br>
                ✅ Membuat forum diskusi tentang pekerjaan, perkuliahan, atau topik lain yang bermanfaat dengan menekan tombol "+ Buat Forum Baru".<br>
                ✅ Mengomentari dan menanggapi forum yang dibuat oleh siswa maupun guru dengan menekan "Selengkapnya..." pada salah satu berita.<br>
                ✅ Berbagi pengalaman dan pengetahuan agar semua dapat belajar dan berkembang bersama.<br><br>
                💡 Cara Berkomentar Dalam Forum:<br>
                🔹 Tekan tombol "Selengkapnya..." pada bagian bawah forum.<br>
                🔹 Masukan isi dalam komentar.<br>
                🔹 Tekan kirim.<br>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>



    </main>

    <!-- Pastikan Bootstrap JS sudah dimuat -->
<!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script> -->

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
