@extends('layouts.main')
@section('title', 'Detail Materi')
@section('content')
    <main id="main" class="main">

        <div class="pagetitle">
            @if (session()->has('success'))
                <div class="alert alert-primary alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            <h1>Detail Materi</h1>
            <nav>
                <ol class="breadcrumb">
                    @if (auth()->user()->level == 'admin')
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('datamateri.view') }}">Data Materi</a></li>
                    @elseif (auth()->user()->level == 'siswa')
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('user.materi') }}">Materi</a></li>
                    @endif
                    <li class="breadcrumb-item active">{{ $materi->judul }}</li>
                </ol>
            </nav>
        </div><!-- End Page Title -->

        <section class="section">
            <div class="row">
                <div class="col-lg-12">
                    <!-- Card with header and footer -->
                    <div class="card mb-3">

                        <div class="card-body">
                            <h5 class="card-title mb-0" style="font-size: 30px;">{{ $materi->judul }}</h5>
                            <div class="content-justify mt-0" style="text-align: justify; font-size: 15px;">by {{ $materi->admin->nama }} |
                                {{ $materi->created_at->translatedFormat('l, j F Y, H:i A') }}
                                <hr>
                            </div>
                            <div class="content-justify mb-2" style="text-align: justify;">
                                {!! $materi->deskripsi !!}
                            </div>
                            <span>
                                @if ($materi->file_pendukung)
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
                                            <img src="{{ asset('storage/materi/' . $materi->file_pendukung) }}" alt="Gambar berita" class="img-thumbnail mb-2"
                                                style="max-width: 500px; max-height: 500px; object-fit: cover;">
                                        @else
                                            <i class="bi bi-file-text" style="font-size: 24px;"></i>
                                        @endif
                                    </div>
                                @endif
                            </span>
                            <p><span></span></p>
                            <div class="content-justify" style="text-align: justify;">
                                {!! $materi->content !!}
                            </div>
                        </div>
                    </div><!-- End Card with header and footer -->

                </div>
            </div>
        </section>

    </main><!-- End #main -->
@endsection
