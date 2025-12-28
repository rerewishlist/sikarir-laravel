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
                    Tes Minat RIASEC
                    <button type="button" class="btn btn-link p-0" data-bs-toggle="modal" data-bs-target="#infoModal">
                        <i class="bi bi-question-circle fs-5"></i>
                    </button>
                    </h1>
                    <nav class="breadcrumbs">
                        <ol>
                            <li><a href="{{ Route('landing') }}">Home</a></li>
                            <li class="current">Tes Minat</li>
                        </ol>
                    </nav>
                </h1>
                @else
                    <h1 class="mb-2 mb-lg-0">
                    Tes Minat RIASEC
                    <button type="button" class="btn btn-link p-0" data-bs-toggle="modal" data-bs-target="#infoModal">
                        <i class="bi bi-question-circle fs-5"></i>
                    </button>
                    </h1>
                    <nav class="breadcrumbs">
                        <ol>
                            <li><a href="{{ Route('landing') }}">Home</a></li>
                            <li class="current">Tes Minat</li>
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

    <form action="{{ route('tes-minat.store') }}" method="POST">
        @csrf
        <div class="col-lg-12" data-aos="fade-up" data-aos-delay="100">
            @foreach ($questions as $q)
            <div class="service-item item-cyan position-relative">
                <div>
                <h5>{{ $loop->iteration }}. {{ $q->pertanyaan }}</h5>
                <label>
                    <h6><input type="radio" name="jawaban[{{ $q->id }}]" value="1" required> Ya </h6>
                </label>
                <label>
                    <h6><input type="radio" name="jawaban[{{ $q->id }}]" value="0"> Tidak </h6>
                </label>
                <hr>
                </div>
            </div>
            @endforeach
        </div>
        <button type="submit" class="btn btn-primary mt-4">Selesai</button>
    </form>
  </div>

</div>


        </section><!-- /Service Details Section -->
<!-- Modal -->
<div class="modal fade" id="infoModal" tabindex="-1" aria-labelledby="infoModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl"> <!-- Menambahkan modal-lg untuk lebar lebih besar -->
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="infoModalLabel">Tes Minat Karir (RIASEC)</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                ✨ Tes Minat Karir (RIASEC) <br>
                Selamat datang di halaman Tes Minat Karir berbasis RIASEC! <br>
                Tes ini dirancang untuk membantu kamu memahami minat dan potensi karirmu berdasarkan tipe kepribadian yang kamu miliki. Dengan menjawab sejumlah pertanyaan sederhana, kamu akan mendapatkan gambaran tentang jenis pekerjaan atau bidang yang paling sesuai dengan minat dan kepribadianmu.<br><br>
                🔍 Apa itu RIASEC?<br>
                RIASEC adalah singkatan dari enam tipe kepribadian yang dikembangkan oleh psikolog John Holland. Keenam tipe tersebut adalah:
                R (Realistic) I (Investigative) A (Artistic) S (Social) E (Enterprising) C (Conventional) <br><br>
                💡 Cara Melakukan Tes:<br>
                🔹 Isi pertanyaan sesuai dengan kepribadian Anda.<br>
                🔹 Tekan selesai di akhir pertanyaan.<br>
                🔹 Anda akan diarahkan ke halaman hasil tes Anda.<br>
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
