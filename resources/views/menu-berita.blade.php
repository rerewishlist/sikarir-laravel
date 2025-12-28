@extends('layouts.content-guest')
@section('title', 'Berita Page')
@section('menuBerita', 'active')
@section('content-guest')

    <main class="main">

        <!-- Page Title -->
        <div class="page-title" data-aos="fade">
            <div class="container d-lg-flex justify-content-between align-items-center">
                <h1 class="mb-2 mb-lg-0">Berita Terbaru
<button type="button" class="btn btn-link p-0" data-bs-toggle="modal" data-bs-target="#infoModal">
        <i class="bi bi-question-circle fs-5"></i>
</button>
                </h1>
                <nav class="breadcrumbs">
                    <ol>
                        @if (auth()->check())
                            <li><a href="{{ Route('dashboard') }}">Home</a></li>
                        @else
                            <li><a href="{{ Route('landing') }}">Home</a></li>
                        @endif
                        <li class="current">Berita</li>
                    </ol>
                </nav>
            </div>
        </div><!-- End Page Title -->

        <!-- Service Details Section -->
        <section id="service-details" class="service-details section">
            <div class="container">
                <div class="row gy-5">
                    @if ($beritas->count() > 0)
                        <div class="col-lg-3" data-aos="fade-up" data-aos-delay="100">
                            <div class="service-box">
                                <div class="services-list">
                                    <form action="">
                                        <input type="text" name="search_berita" class="form-control mb-3" placeholder="Cari judul berita..."
                                            value="{{ request('search_berita') }}">
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

                            <div class="service-box">
                                <h4>List Kategori</h4>
                                <div class="services-list">
                                    @foreach ($kategoris as $item)
                                        @if (auth()->check())
                                            <a href="{{ route('user.berita.view', ['kategori_id' => $item->id]) }}"
                                                class="{{ request()->get('kategori_id') == $item->id ? 'active' : '' }}">
                                            @else
                                                <a href="{{ route('berita.menu', ['kategori_id' => $item->id]) }}"
                                                    class="{{ request()->get('kategori_id') == $item->id ? 'active' : '' }}">
                                        @endif
                                        <i class="bi bi-arrow-right-circle"></i><span>{{ $item->nama }}</span>
                                        </a>
                                    @endforeach
                                </div>
                            </div><!-- End Services List -->
                        </div>


                        <div class="col-lg-9 ps-lg-5" data-aos="fade-up" data-aos-delay="200">
                            @foreach ($beritas as $item)
                                <div class="mb-5">
                                    <h3>{{ $item->judul }}</h3>
                                    @php
                                        $randomImages = [
                                            'assets/img/berita1.jpeg',
                                            'assets/img/berita2.jpeg',
                                            'assets/img/berita3.jpeg',
                                            'assets/img/berita4.jpeg',
                                            'assets/img/berita5.jpeg',
                                        ];
                                        $randomImage = $randomImages[array_rand($randomImages)];
                                    @endphp
                                    @if ($item->gambar)
                                        <img src="{{ asset('storage/berita/' . $item->gambar) }}" alt="Gambar berita" class="img-fluid services-img">
                                    @else
                                        <img src="{{ asset($randomImage) }}" alt="Gambar berita" class="img-fluid services-img">
                                    @endif
                                    <p>
                                        @foreach ($item->kategoris as $index => $kategori)
                                            <span>{{ $kategori->nama }}{{ $loop->last ? '' : ' |' }}</span>
                                        @endforeach
                                    </p>
                                    <p>
                                        {{ $item->created_at->translatedFormat('d F Y') }}
                                    </p>
                                    <div class="content-justify" style="text-align: justify;">
                                        {!! \Illuminate\Support\Str::limit(strip_tags($item->content), 300, '...') !!}
                                    </div>

                                    @if (auth()->check())
                                        <a href="{{ Route('user.berita.detail', $item->slug) }}">Selengkapnya...</a>
                                    @else
                                        <a href="{{ Route('berita.detail.menu', $item->slug) }}">Selengkapnya...</a>
                                    @endif
                                </div>
                            @endforeach

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

                        </div>
                    @else
                        <div class="col-lg-9 ps-lg-5" data-aos="fade-up" data-aos-delay="200">
                            <div class="mb-5">
                                <h3>Belum ada berita</h3>
                            </div>
                        </div>
                    @endif
                </div>
            </div>

        </section><!-- /Service Details Section -->

<!-- Modal -->
<div class="modal fade" id="infoModal" tabindex="-1" aria-labelledby="infoModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl"> <!-- Menambahkan modal-lg untuk lebar lebih besar -->
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="infoModalLabel">Panduan Berita Terbaru</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Tempat segala infromasi berita terbaru mengenai Pekerjaan ataupun Perkuliahan untuk menambah wawasan Siswa!
                Membantu siswa SMK menemukan peluang karir yang tepat dengan menghadirkan informasi terbaru seputar lowongan kerja dan jalur pendidikan lanjutan. Jangan lewatkan kesempatan emas untuk meraih masa depan yang lebih cerah! 🌟<br>
                ✅ Anda dapat menggunakan filter berdasarkan kategori pekerjaan ataupun perkuliahan.<br>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>
    </main>

    <script>
        window.addEventListener('load', function() {
            // Menghapus parameter pencarian dari URL saat halaman di-refresh
            var url = new URL(window.location.href);
            url.searchParams.delete('kategori_id');
            url.searchParams.delete('filter_tanggal');
            url.searchParams.delete('search_berita');
            window.history.replaceState({}, document.title, url.toString());
        });
    </script>
@endsection
