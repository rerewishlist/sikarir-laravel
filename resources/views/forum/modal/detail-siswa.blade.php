@extends('layouts.content-guest')
@section('title', 'Forum Page Detail')
@section('menuForum', 'active')
@section('content-guest')

    <main class="main">

        <!-- Page Title -->
        <div class="page-title" data-aos="fade">
            <div class="container d-lg-flex justify-content-between align-items-center">
                <div class="mb-2 mb-lg-0">
                    <h1>{{ $forum->judul }}</h1>
                    @if ($forum->admin)
                        by {{ $forum->admin->nama }} ({{ $forum->admin->level }}) |
                    @elseif ($forum->user)
                        by {{ $forum->user->nama }} ({{ $forum->user->level }}) |
                    @else
                        <!-- Anda bisa menampilkan pesan atau elemen lain jika admin dan user tidak ada -->
                        <span>Admin dan User tidak tersedia</span>
                    @endif
                    {{ $forum->created_at->translatedFormat('d F Y') }}
                </div>

                <nav class="breadcrumbs">
                    <ol>
                        <li><a href="{{ Route('dashboard') }}">Home</a></li>
                        <li><a href="{{ Route('user.dataforum.view') }}">Forum</a></li>
                        <li class="current">Detail Forum</li>
                    </ol>
                </nav>
            </div>
        </div><!-- End Page Title -->

        <!-- Service Details Section -->
        <section id="service-details" class="service-details section">
            <div class="container">
                <div class="row gy-5">
                    <div class="col-lg-10 ps-lg-5" data-aos="fade-up" data-aos-delay="100">
                        @if ($forum->gambar)
                            <img src="{{ asset('storage/forum/' . $forum->gambar) }}" alt="Gambar berita" class="img-fluid services-img">
                        @endif
                        <div class="content-justify" style="text-align: justify;">
                            {!! $forum->content !!}
                        </div>
                        <form action="{{ route('user.datacomment.store', $forum->id) }}" method="POST" class="d-flex search-form w-100">
                            @csrf
                            <input type="hidden" name="forum_id" value="{{ $forum->id }}">
                            <input type="text" class="form-control @error('body') is-invalid @enderror flex-grow-1" name="body" id="inputText"
                                placeholder="Tulis Komentar" value="{{ old('body') }}">
                            <button type="submit" class="btn btn-primary ms-2">Kirim</button>
                        </form>
                    </div>

                    <div class="col-lg-10 ps-lg-5" data-aos="fade-up" data-aos-delay="100">
                        <h3>Komentar</h3>
                        <hr>
                        @if ($forum->comments->count() > 0)
                            @foreach ($forum->comments as $comment)
                                <div class="d-flex align-items-center mb-2">
                                    @if (($comment->admin && $comment->admin->foto) || ($comment->user && $comment->user->foto))
                                        <img src="{{ $comment->admin && $comment->admin->foto ? asset('storage/foto/' . $comment->admin->foto) : asset('storage/foto/' . $comment->user->foto) }}"
                                            alt="Profile" class="rounded-circle"
                                            style="width: 30px; height: 30px; object-fit: cover; border-radius: 50%; margin-right: 10px;">
                                    @else
                                        <img src="{{ asset('assets/img/blank-profile-picture.jpg') }}" alt="Profile" class="rounded-circle"
                                            style="width: 30px; height: 30px; object-fit: cover; border-radius: 50%; margin-right: 10px;">
                                    @endif
                                    <div class="d-flex flex-column">
                                        <span style="font-size: 0.8em; color: gray;">
                                            <b>
                                                @if ($comment->admin)
                                                    {{ $comment->admin->nama }} ({{ $comment->admin->level }})
                                                @elseif ($comment->user)
                                                    {{ $comment->user->nama }} ({{ $comment->user->level }})
                                                @else
                                                    Admin dan User tidak tersedia
                                                @endif
                                            </b>
                                            , {{ $comment->created_at->translatedFormat('j F Y, H:i A') }}
                                        </span>
                                    </div>
                                </div>

                                <p class="content-justify" style="text-align: justify;">
                                    {{ $comment->body }}
                                </p>
                                <hr>
                            @endforeach
                        @else
                            <div class="d-flex align-items-center mb-2">
                                Belum Ada Komentar
                            </div>
                            <hr>
                        @endif
                    </div><!-- End Card with header and footer -->

                </div>
            </div>
        </section><!-- /Service Details Section -->
    </main>
@endsection
