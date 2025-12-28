@extends('layouts.content-guest')
@section('title', 'Tes Minat Page')
@section('menuTes', 'active')
@section('content-guest')

    <main class="main">

        <!-- Page Title -->
        <div class="page-title" data-aos="fade">
            <div class="container d-lg-flex justify-content-between align-items-center">
                @if (auth()->check())
                <h1 class="mb-2 mb-lg-0">
                    Hasil Tes RIASEC
                    <button type="button" class="btn btn-link p-0" data-bs-toggle="modal" data-bs-target="#infoModal">
                        <i class="bi bi-question-circle fs-5"></i>
                    </button>
                    </h1>
                    <nav class="breadcrumbs">
                        <ol>
                            <li><a href="{{ Route('landing') }}">Home</a></li>
                            <li class="current">Hasil Tes</li>
                        </ol>
                    </nav>
                </h1>
                @else
                    <h1 class="mb-2 mb-lg-0">
                    Hasil Tes RIASEC
                    <button type="button" class="btn btn-link p-0" data-bs-toggle="modal" data-bs-target="#infoModal">
                        <i class="bi bi-question-circle fs-5"></i>
                    </button>
                    </h1>
                    <nav class="breadcrumbs">
                        <ol>
                            <li><a href="{{ Route('landing') }}">Home</a></li>
                            <li class="current">Hasil Tes</li>
                        </ol>
                    </nav>
                </h1>
                @endif
            </div>
        </div><!-- End Page Title -->

        <!-- Service Details Section -->
        <section id="service-details" class="service-details section">

<div class="container">

  <div class="row g-5">

    <!-- <form action="{{ route('tes-minat.store') }}" method="POST">
        @csrf
        <div class="col-lg-12" data-aos="fade-up" data-aos-delay="100">
        <div class="service-item item-cyan position-relative">
            <div>
            <h3>Informasi Berita Lowongan Pekerjaan dan Perkuliahan</h3>
            <p>Membantu siswa SMK menemukan peluang karir yang tepat dengan menghadirkan informasi terbaru seputar lowongan kerja dan jalur pendidikan lanjutan. Jangan lewatkan kesempatan emas untuk meraih masa depan yang lebih cerah! 🌟</p>
            <a href="{{ Route('berita.menu') }}" class="read-more stretched-link">Learn More <i class="bi bi-arrow-right"></i></a>
            </div>
        </div>
        </div>
    </form> -->

    <table class="table">
    <thead>
        <tr>
            <th>Kode</th>
            <th>Skor</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($results as $result)
            <tr>
                <td>{{ $result->kode_riasec }}</td>
                <td>{{ $result->skor }}</td>
            </tr>
        @endforeach
    </tbody>
</table>

@if ($suggestion)
    <div class="mt-4">
        <h4>Rekomendasi Karir: <strong>{{ $suggestion->karir }}</strong></h4>
        <p>{{ $suggestion->deskripsi }}</p>
    </div>
@endif
    
<form action="{{ route('tes-minat.ulang') }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin mengulang tes?')">
    @csrf
    @method('DELETE')
    <button type="submit" class="btn btn-danger">Ulang Tes</button>
</form>

  </div>

</div>


        </section><!-- /Service Details Section -->


<!-- Modal -->
<div class="modal fade" id="infoModal" tabindex="-1" aria-labelledby="infoModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl"> <!-- Menambahkan modal-lg untuk lebar lebih besar -->
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="infoModalLabel">Hasil Tes Minat Karir (RIASEC)</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                ✨ Hasil Tes Minat Karir (RIASEC) <br>
                Ini adalah hasil tes yang paling sesuai dengan minat dan kepribadianmu.<br><br>
                💡 Cara Memulai Ulang Tes:<br>
                🔹 Tekan Tombol Ulang Tes berwarna merah untuk memulai ulang tes Anda.<br>
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
