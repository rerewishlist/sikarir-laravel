@extends('layouts.content-guest')
@section('title', 'Chat Page')
@section('menuChat', 'active')
@section('content-guest')

    <main class="main">

        <!-- Page Title -->
        <div class="page-title" data-aos="fade">
            <div class="container d-lg-flex justify-content-between align-items-center">
                <h1 class="mb-2 mb-lg-0">
                    Chatting
                    <button type="button" class="btn btn-link p-0" data-bs-toggle="modal" data-bs-target="#infoModal">
                        <i class="bi bi-question-circle fs-5"></i>
                    </button>
                </h1>
                
                <nav class="breadcrumbs">
                    <ol>
                        <li><a href="{{ Route('dashboard') }}">Home</a></li>
                        <li class="current">Chatting</li>
                    </ol>
                </nav>
            </div>
        </div><!-- End Page Title -->

        <!-- Service Details Section -->
        <section id="service-details" class="service-details section">
            <div class="container">
                <div class="row gy-5">
                    <div class="col-lg-3" data-aos="fade-up" data-aos-delay="100">
                        <div class="service-box">
                            <h4>List Guru</h4>
                            <div class="services-list">
                                @foreach ($alladmins as $item)
                                    <a href="{{ route('user.chat.view', ['admin_id' => $item->id]) }}"
                                        class="{{ request()->get('admin_id') == $item->id ? 'active' : '' }}">
                                        <i class="bi bi-arrow-right-circle"></i><span>{{ $item->nama }} (Guru)</span>
                                    </a>
                                @endforeach
                            </div>
                        </div><!-- End Services List -->
                    </div>

                    @if ($admins->isNotEmpty())
                        <div class="col-lg-9 ps-lg-5" data-aos="fade-up" data-aos-delay="200">
                            @foreach ($admins as $item)
                                <div class="mb-5">
                                    <h3>{{ $item->nama }}</h3>
                                    <hr>

                                    @if ($item->foto)
                                        <img src="{{ asset('storage/foto/' . $item->foto) }}" alt="Foto Admin" class="img-fluid-foto services-img">
                                    @else
                                        <img src="{{ asset('assets/img/blank-profile-picture.jpg') }}" alt="Foto Admin"
                                            class="img-fluid-foto services-img">
                                    @endif

                                    <p>
                                        <button onclick="location.href='{{ route('user.chat.detail', $item->id) }}'" class="btn btn-primary">Chat
                                            sekarang</button>
                                    </p>

                                </div>
                            @endforeach
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
                <h5 class="modal-title" id="infoModalLabel">Panduan Forum Siswa</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Tempat bagi siswa dan guru bertanya dan berdiskusi mengenai dunia kerja dan perkuliahan secara private. Di sini, kamu bisa:<br><br>
                💡 Cara Chatting dengan Guru:<br>
                🔹 Pilih nama guru pada list guru.<br>
                🔹 Tekan tombol Chat sekarang pada bawah foto profile guru.<br>
                🔹 Silahkan perkenalkan diri dan mulai berinteraksi dengan guru melalui chatting.<br><br>
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
            url.searchParams.delete('admin_id');
            window.history.replaceState({}, document.title, url.toString());
        });
    </script>

    
@endsection
