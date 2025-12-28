@extends('layouts.content-guest')
@section('title', 'Perusahaan Page')
@section('menuPerusahaan', 'active')
@section('content-guest')

    <main class="main">

        <!-- Page Title -->
        <div class="page-title" data-aos="fade">
            <div class="container d-lg-flex justify-content-between align-items-center">
                @if (auth()->check())
                <h1 class="mb-2 mb-lg-0">
                    Kerjasama Perusahaan
                    <button type="button" class="btn btn-link p-0" data-bs-toggle="modal" data-bs-target="#infoModal">
                        <i class="bi bi-question-circle fs-5"></i>
                    </button>
                    </h1>
                    <nav class="breadcrumbs">
                        <ol>
                            <li><a href="{{ Route('landing') }}">Home</a></li>
                            <li class="current">Perusahaan</li>
                        </ol>
                    </nav>
                </h1>
                @else
                    <h1 class="mb-2 mb-lg-0">
                        Kerjasama Perusahaan
                    <button type="button" class="btn btn-link p-0" data-bs-toggle="modal" data-bs-target="#a">
                        <i class="bi bi-question-circle fs-5"></i>
                    </button>
                    </h1>
                    <nav class="breadcrumbs">
                        <ol>
                            <li><a href="{{ Route('landing') }}">Home</a></li>
                            <li class="current">Perusahaan</li>
                        </ol>
                    </nav>
                @endif
            </div>
        </div><!-- End Page Title -->

        <!-- Service Details Section -->
        <section id="service-details" class="service-details section">

            <div class="container">
                <div class="row gy-5">
                    @if ($perusahaans->count() > 0)
                        @if (auth()->check())
                            <div class="col-lg-3" data-aos="fade-up" data-aos-delay="100">
                                <div class="service-box">
                                    <div class="services-list">
                                        <form action="">
                                            <input type="text" name="search_perusahaan" class="form-control mb-3" placeholder="Cari nama perusahaan..."
                                                value="{{ request('search_perusahaan') }}">
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

                        @foreach ($perusahaans as $item)
                            <div class="mb-5">
                                <h3>{{ $item->nama_industri }}</h3>
                                @if ($item->gambar)
                                    <img src="{{ asset('storage/perusahaan/' . $item->gambar) }}" alt="Gambar perusahaan" class="img-fluid services-img">
                                @endif
                                <p>
                                    {{ $item->alamat }}
                                </p>
                                <p>
                                    <hr>
                                </p>
                            </div>
                        @endforeach

                        @if (auth()->check())
                            <!-- Paginate -->
                            <nav aria-label="Page navigation example">
                                <ul class="pagination">
                                    <!-- Previous Page Link -->
                                    @if ($perusahaans->onFirstPage())
                                        <li class="page-item disabled"><span class="page-link">Previous</span></li>
                                    @else
                                        <li class="page-item"><a class="page-link" href="{{ $perusahaans->previousPageUrl() }}">Previous</a>
                                        </li>
                                    @endif

                                    <!-- Pagination Elements -->
                                    @for ($i = 1; $i <= $perusahaans->lastPage(); $i++)
                                        <li class="page-item {{ $i == $perusahaans->currentPage() ? 'active' : '' }}">
                                            <a class="page-link" href="{{ $perusahaans->url($i) }}">{{ $i }}</a>
                                        </li>
                                    @endfor

                                    <!-- Next Page Link -->
                                    @if ($perusahaans->hasMorePages())
                                        <li class="page-item"><a class="page-link" href="{{ $perusahaans->nextPageUrl() }}">Next</a></li>
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
                                    <div class="services-list">
                                        <form action="">
                                            <input type="text" name="search_perusahaan" class="form-control mb-3" placeholder="Cari judul forum..."
                                                value="{{ request('search_perusahaan') }}">
                                            <button type="submit" class="btn btn-primary mt-3">Cari</button>
                                        </form>
                                    </div>
                                </div><!-- End Services List -->
                            </div>
                        @endif
                        <div class="col-lg-9 ps-lg-5" data-aos="fade-up" data-aos-delay="200">
                            <div class="mb-5">
                                <h3>Belum ada Kerjasama Perusahaan</h3>
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
                <h5 class="modal-title" id="infoModalLabel">Panduan Perusahaan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Merupakan halaman yang menmberikan informasi perusahaan-perusahaan yang bekerja sama dengan sekolah
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
                <h5 class="modal-title" id="infoModalLabel">Panduan Kerjasama Perusahaan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Merupakan halaman yang menmberikan informasi perusahaan-perusahaan yang bekerja sama dengan sekolah
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
            url.searchParams.delete('search_perusahaan');
            window.history.replaceState({}, document.title, url.toString());
        });
    </script>
@endsection
