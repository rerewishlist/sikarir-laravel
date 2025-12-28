@extends('layouts.content-guest')
@section('title', 'Notifikasi')
@section('content-guest')

    <main class="main">

        <!-- Page Title -->
        <div class="page-title" data-aos="fade">
            <div class="container d-lg-flex justify-content-between align-items-center">
                <h1 class="mb-2 mb-lg-0">Notifikasi</h1>
                <nav class="breadcrumbs">
                    <ol>
                        <li><a href="{{ Route('dashboard') }}">Home</a></li>
                        <li class="current">Notifikasi</li>
                    </ol>
                </nav>
            </div>
        </div><!-- End Page Title -->

        <!-- Service Details Section -->
        <section id="service-details" class="service-details section">
            <div class="container">
                <div class="row gy-5">

                    <div class="col-lg-12 ps-lg-5" data-aos="fade-up" data-aos-delay="200">
                        @if ($beritaforummateriNotifications->count() > 0)
                            @foreach ($databeritaforummateriNotifications as $item)
                                @if ($item->data['type'] == 'berita')
                                    <a href="{{ route('user.berita.detail', $item->data['slug']) }}">
                                        <div class="d-flex align-items-center mb-2">

                                            <div class="col-md-1">
                                                <div class="icon-circle">
                                                    <i class="bi bi-newspaper"></i>
                                                </div>
                                            </div>
                                            <div class="d-flex flex-column">
                                                <span style="font-size: 0.8em; color: gray;">
                                                    {{ \Carbon\Carbon::parse($item->data['created_at'])->format('d/m/Y') }} |
                                                    {{ $item->created_at->diffForHumans() }}
                                                </span>
                                                <h5>
                                                    <strong>Berita: </strong>{!! \Illuminate\Support\Str::limit(strip_tags($item->data['judul']), 50, '...') !!}
                                                </h5>
                                            </div>
                                        </div>
                                        <hr>
                                    </a>
                                @elseif ($item->data['type'] == 'forum')
                                    <a href="{{ route('user.dataforum.detail', $item->data['forum_id']) }}">
                                        <div class="d-flex align-items-center mb-2">

                                            <div class="col-md-1">
                                                <div class="icon-circle">
                                                    <i class="bi bi-chat-dots"></i></i>
                                                </div>
                                            </div>
                                            <div class="d-flex flex-column">
                                                <span style="font-size: 0.8em; color: gray;">
                                                    {{ \Carbon\Carbon::parse($item->data['created_at'])->format('d/m/Y') }} |
                                                    {{ $item->created_at->diffForHumans() }}
                                                </span>
                                                <h5>
                                                    <strong>Forum: </strong>{!! \Illuminate\Support\Str::limit(strip_tags($item->data['judul']), 50, '...') !!}
                                                </h5>
                                            </div>
                                        </div>
                                        <hr>
                                    </a>
                                @elseif ($item->data['type'] == 'materi')
                                    <a href="{{ route('user.materi.detail', $item->data['materi_id']) }}">
                                        <div class="d-flex align-items-center mb-2">

                                            <div class="col-md-1">
                                                <div class="icon-circle">
                                                    <i class="bi bi-blockquote-left"></i>
                                                </div>
                                            </div>
                                            <div class="d-flex flex-column">
                                                <span style="font-size: 0.8em; color: gray;">
                                                    {{ \Carbon\Carbon::parse($item->data['created_at'])->format('d/m/Y') }} |
                                                    {{ $item->created_at->diffForHumans() }}
                                                </span>
                                                <h5>
                                                    <strong>Materi: </strong>{!! \Illuminate\Support\Str::limit(strip_tags($item->data['judul']), 50, '...') !!}
                                                </h5>
                                            </div>
                                        </div>
                                        <hr>
                                    </a>
                                @endif
                            @endforeach
                        @else
                            <a href="#">
                                <div class="d-flex align-items-center mb-2">
                                    <div class="d-flex flex-column">
                                        <span style="font-size: 0.8em; color: gray;">
                                        </span>
                                        <h5>
                                            Tidak Ada Notifikasi
                                        </h5>
                                    </div>
                                </div>
                                <hr>
                            </a>
                        @endif
                    </div>
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
