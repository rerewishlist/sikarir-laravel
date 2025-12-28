@extends('layouts.content-guest')
@section('title', 'Materi Page')
@section('menuMateri', 'active')
@section('content-guest')

    <main class="main">

        <!-- Page Title -->
        <div class="page-title" data-aos="fade">
            <div class="container d-lg-flex justify-content-between align-items-center">
                <div class="mb-2 mb-lg-0">
                    <h1>{{ $materi->judul }}</h1>
                    by {{ $materi->admin->nama }} |
                    {{ $materi->created_at->translatedFormat('d F Y') }}
                </div>
                <nav class="breadcrumbs">
                    <ol>
                        <li><a href="{{ Route('dashboard') }}">Home</a></li>
                        <li><a href="{{ Route('user.materi') }}">Materi</a></li>
                        <li class="current">Detail Materi</li>
                    </ol>
                </nav>
            </div>
        </div><!-- End Page Title -->

        <!-- Service Details Section -->
        <section id="service-details" class="service-details section">

            <div class="container">

                <div class="row gy-5">
                    <div class="col-lg-10 ps-lg-5" data-aos="fade-up" data-aos-delay="200">
                        <div class="content-justify mb-5" style="text-align: justify;">
                            {{ $materi->deskripsi }}
                        </div>
                        @if ($materi->file_pendukung)
                            <hr>
                            @php
                                $fileExtension = pathinfo($materi->file_pendukung, PATHINFO_EXTENSION);
                            @endphp
                            <div class="d-flex align-items-center">
                                @if (in_array($fileExtension, ['pdf']))
                                    <i class="bi bi-file-pdf text-danger" style="font-size: 24px;"></i>
                                    <a href="{{ asset('storage/materi/' . $materi->file_pendukung) }}" class="ms-2" target="_blank">
                                        {{ $materi->file_pendukung }}
                                    </a>
                                @elseif (in_array($fileExtension, ['doc', 'docx']))
                                    <i class="bi bi-file-word text-primary" style="font-size: 24px;"></i>
                                    <a href="{{ asset('storage/materi/' . $materi->file_pendukung) }}" class="ms-2" target="_blank">
                                        {{ $materi->file_pendukung }}
                                    </a>
                                @elseif (in_array($fileExtension, ['jpg', 'jpeg', 'png']))
                                    <img src="{{ asset('storage/materi/' . $materi->file_pendukung) }}" alt="Gambar berita" class="img-fluid services-img">
                                @else
                                    <i class="bi bi-file-text" style="font-size: 24px;"></i>
                                @endif
                            </div>
                            <hr>

                        @endif
                        <div class="content-justify" style="text-align: justify;">
                            {!! $materi->content !!}
                        </div>

                    </div>

                </div>

            </div>

        </section><!-- /Service Details Section -->

    </main>
@endsection
