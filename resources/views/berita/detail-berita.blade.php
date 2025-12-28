@extends('layouts.main')
@section('title', 'Detail Berita')
@section('content')
    <main id="main" class="main">

        <div class="pagetitle">
            @if (session()->has('success'))
                <div class="alert alert-primary alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            <h1>Detail Berita</h1>
            <nav>
                <ol class="breadcrumb">
                    @if (auth()->user()->level == 'admin')
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('databerita.view') }}">Data Berita</a></li>
                    @elseif (auth()->user()->level == 'siswa')
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                    @endif
                    <li class="breadcrumb-item active">{{ $berita->judul }}</li>
                </ol>
            </nav>
        </div><!-- End Page Title -->

        <section class="section">
            <div class="row">
                <div class="col-lg-12">
                    <!-- Card with header and footer -->
                    <div class="card mb-3">

                        <div class="card-body">
                            <h5 class="card-title mb-0" style="font-size: 30px;">{{ $berita->judul }}</h5>
                            <div class="content-justify mt-0" style="text-align: justify; font-size: 15px;">by {{ $berita->admin->nama }} |
                                {{ $berita->created_at->translatedFormat('l, j F Y, H:i A') }} |
                                @foreach ($berita->kategoris as $index => $kategori)
                                    {{ $kategori->nama }}@if ($index < $berita->kategoris->count() - 1)
                                        ,
                                    @endif
                                @endforeach
                                <hr>
                            </div>
                            <span>
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
                                @if ($berita->gambar)
                                    <img src="{{ asset('storage/berita/' . $berita->gambar) }}" alt="Gambar berita" class="img-thumbnail mb-4"
                                        style="max-width: 500px; max-height: 500px; object-fit: cover;">
                                @else
                                    <img src="{{ asset($randomImage) }}" alt="foto" class="card-img-top" style="height: 300px; object-fit: cover;">
                                @endif
                            </span>
                            <p><span></span></p>
                            <div class="content-justify" style="text-align: justify;">
                                {!! $berita->content !!}
                            </div>
                            <div class="content-justify" style="text-align: justify;">
                                <b>Lokasi</b> : {!! $berita->lokasi !!}
                            </div>
                        </div>
                    </div><!-- End Card with header and footer -->

                </div>
            </div>
        </section>

    </main><!-- End #main -->
@endsection
