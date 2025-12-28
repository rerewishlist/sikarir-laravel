@extends('layouts.main')
@section('title', 'Detail Forum')
@section('content')
<main id="main" class="main">

    <div class="pagetitle">
        @if (session()->has('success'))
        <div class="alert alert-primary alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        @endif
        <h1>Detail Forum
<button type="button" class="btn btn-link p-0" data-bs-toggle="modal" data-bs-target="#infoModal">
    <i class="bi bi-question-circle fs-5"></i>
</button>
        </h1>
        <nav>
            <ol class="breadcrumb">
                @if (auth()->user()->level == 'superadmin')
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('admin.dataforum.view') }}">Data Forum Diskusi</a></li>
                @elseif (auth()->user()->level == 'admin')
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('admin.dataforum.view') }}">Data Forum Diskusi</a></li>
                @elseif (auth()->user()->level == 'siswa')
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('user.dataforum.view') }}">Data Forum Diskusi</a></li>
                @endif
                <li class="breadcrumb-item active">Detail Forum {{ $forum->judul }}</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <!-- Card with header and footer -->
                <div class="card mb-3">
                    <div class="card-header">
                        <div class="d-flex align-items-start">
                            @if (($forum->admin && $forum->admin->foto) || ($forum->user && $forum->user->foto))
                            <img src="{{ $forum->admin && $forum->admin->foto ? asset('storage/foto/' . $forum->admin->foto) : asset('storage/foto/' . $forum->user->foto) }}"
                                alt="Profile" class="rounded-circle"
                                style="width: 45px; height: 45px; object-fit: cover; border-radius: 50%; margin-right: 10px;">
                            @endif
                            <div class="d-flex flex-column">
                                @if ($forum->admin)
                                <span>{{ $forum->admin->nama }} ({{ $forum->admin->level }})</span>
                                @elseif ($forum->user)
                                <span>{{ $forum->user->nama }} ({{ $forum->user->level }})</span>
                                @else
                                <!-- Anda bisa menampilkan pesan atau elemen lain jika admin dan user tidak ada -->
                                <span>Admin dan User tidak tersedia</span>
                                @endif
                                <span style="font-size: 1.0em; color: gray;">
                                    {{ $forum->created_at->translatedFormat('l, j F Y, H:i A') }}
                                </span>
                            </div>
                        </div>
                    </div>

                    <div class="card-body">
                        <h5 class="card-title" style="font-size: 30px;">{{ $forum->judul }}</h5>
                        @if ($forum->gambar)
                        <img src="{{ asset('storage/forum/' . $forum->gambar) }}" alt="Gambar forum" class="img-thumbnail mb-4"
                            style="max-width: 500px; max-height: 500px; object-fit: cover;">
                        @endif
                        <div class="content-justify" style="text-align: justify;">
                            {!! $forum->content !!}
                        </div>
                    </div>

                    <div class="card-footer">
                        <div class="d-flex justify-content-between align-items-center">
                            @if (auth()->user()->level == 'superadmin')
                            <form action="{{ route('admin.datacomment.store', $forum->id) }}" method="POST" class="d-flex search-form w-100">
                                @elseif (auth()->user()->level == 'admin')
                                <form action="{{ route('admin.datacomment.store', $forum->id) }}" method="POST" class="d-flex search-form w-100">
                                    @elseif (auth()->user()->level == 'siswa')
                                    <form action="{{ route('user.datacomment.store', $forum->id) }}" method="POST" class="d-flex search-form w-100">
                                        @endif
                                        @csrf
                                        <input type="hidden" name="forum_id" value="{{ $forum->id }}">
                                        <input type="text" class="form-control @error('body') is-invalid @enderror flex-grow-1" name="body" id="inputText"
                                            placeholder="Tulis Komentar" value="{{ old('body') }}">
                                        <button type="submit" class="btn btn-primary ms-2">Kirim</button>
                                    </form>
                        </div>
                    </div>
                </div><!-- End Card with header and footer -->

                <div class="comments-container" style="padding-left: 50px;">
                    <!-- Comments -->
                    @foreach ($forum->comments as $comment)
                    <div class="card mb-3">
                        <div class="card-header">
                            <div class="d-flex align-items-start">
                                @if (($comment->admin && $comment->admin->foto) || ($comment->user && $comment->user->foto))
                                <img src="{{ $comment->admin && $comment->admin->foto ? asset('storage/foto/' . $comment->admin->foto) : asset('storage/foto/' . $comment->user->foto) }}"
                                    alt="Profile" class="rounded-circle"
                                    style="width: 45px; height: 45px; object-fit: cover; border-radius: 50%; margin-right: 10px;">
                                @endif
                                <div class="d-flex flex-column">
                                    re: {{ $forum->judul }}
                                    <span style="font-size: 0.8em; color: gray;">
                                        by
                                        <b>
                                            @if ($comment->admin)
                                            {{ $comment->admin->nama }} ({{ $comment->admin->level }})
                                            @elseif ($comment->user)
                                            {{ $comment->user->nama }} ({{ $comment->user->level }})
                                            @else
                                            Admin dan User tidak tersedia
                                            @endif
                                        </b>
                                        {{ $comment->created_at->translatedFormat('l, j F Y, H:i A') }}
                                    </span>
                                </div>
                            </div>
                        </div>

                        <div class="card-body">
                            <div class="content-justify mt-4" style="text-align: justify;">
                                {{ $comment->body }}
                            </div>
                        </div>
                    </div><!-- End Card with header and footer -->
                    @endforeach
                </div>

            </div>
        </div>
    </section>
    
<!-- Modal -->
<div class="modal fade" id="infoModal" tabindex="-1" aria-labelledby="infoModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl"> <!-- Menambahkan modal-lg untuk lebar lebih besar -->
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="infoModalLabel">Panduan Berkomentar Pada Forum</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                🔹 Masukan isi dalam komentar.<br>
                🔹 Tekan kirim.<br>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>
</main><!-- End #main -->
@endsection