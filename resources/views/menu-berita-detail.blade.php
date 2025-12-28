@extends('layouts.content-guest')
@section('title', 'Berita Page')
@section('menuBerita', 'active')
@section('content-guest')

    <main class="main">

        <!-- Page Title -->
        <div class="page-title" data-aos="fade">
            <div class="container d-lg-flex justify-content-between align-items-center">
                <div class="mb-2 mb-lg-0">
                    <h1>{{ $berita->judul }}</h1>
                    by {{ $berita->admin->nama }} |
                    {{ $berita->created_at->translatedFormat('d F Y') }} |
                    @foreach ($berita->kategoris as $kategori)
                    <span>{{ $kategori->nama }}{{ $loop->last ? '' : ' |' }}</span>
                    @endforeach
                </div>
                <nav class="breadcrumbs">
                    <ol>
                        @if (auth()->check())
                            <li><a href="{{ Route('dashboard') }}">Home</a></li>
                            <li><a href="{{ Route('user.berita.view') }}">Berita</a></li>
                        @else
                            <li><a href="{{ Route('landing') }}">Home</a></li>
                            <li><a href="{{ Route('berita.menu') }}">Berita</a></li>
                        @endif
                        <li class="current">{{ $berita->judul }}</li>
                    </ol>
                </nav>
            </div>
        </div><!-- End Page Title -->

        <!-- Service Details Section -->
        <section id="service-details" class="service-details section">

            <div class="container">

                <div class="row gy-5">
                    <div class="col-lg-10 ps-lg-5" data-aos="fade-up" data-aos-delay="200">
                        @if ($berita->gambar)
                            <img src="{{ asset('storage/berita/' . $berita->gambar) }}" alt="Gambar berita" class="img-fluid services-img mb-5">
                        @endif
                        <div class="content-justify" style="text-align: justify;">
                            {!! $berita->content !!}
                        </div>

                    </div>

                </div>

            </div>

        </section><!-- /Service Details Section -->

    </main>
@endsection
