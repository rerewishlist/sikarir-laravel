@extends('layouts.main')
@section('title', 'Chat')
@section('content')
    <main id="main" class="main">

        @php
            $hideFooter = true; // Sembunyikan footer di halaman ini
        @endphp
        <div class="pagetitle">
            @if (session()->has('success'))
                <div class="alert alert-primary alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            <h1>
                @if ($targetUser->foto)
                    <img src="{{ asset('storage/foto/' . $targetUser->foto) }}" alt="Profile" class="rounded-circle"
                        style="width: 45px; height: 45px; object-fit: cover; border-radius: 50%; margin-right: 10px;">
                @endif
                {{ $targetUser->nama }}
            </h1>
        </div><!-- End Page Title -->

        <section class="section">
            <div class="row">
                <div class="col-lg-12 chat-container">
                    @php
                        $currentUser = auth()->user();
                    @endphp

                    @foreach ($chats as $chat)
                        @if ($currentUser->level == 'superadmin')
                            @if ($chat->from_admin_id == $currentUser->id)
                                <div class="d-flex justify-content-end">
                                    <div class="card chat-hijau">
                                        <div class="card-body">
                                            <div class="content-justify mt-3" style="text-align: justify;">
                                                @if ($chat->gambar)
                                                    <img src="{{ asset('storage/chat/' . $chat->gambar) }}" alt="Image" class="img-fluid mb-2"><br>
                                                @endif
                                                {{ $chat->message }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @else
                                <div class="d-flex justify-content-start">
                                    <div class="card chat-abu">
                                        <div class="card-body">
                                            <div class="content-justify mt-3" style="text-align: justify;">
                                                @if ($chat->gambar)
                                                    <img src="{{ asset('storage/chat/' . $chat->gambar) }}" alt="Image" class="img-fluid mb-2"><br>
                                                @endif
                                                {{ $chat->message }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        @elseif ($currentUser->level == 'admin')
                            @if ($chat->from_admin_id == $currentUser->id)
                                <div class="d-flex justify-content-end">
                                    <div class="card chat-hijau">
                                        <div class="card-body">
                                            <div class="content-justify mt-3" style="text-align: justify;">
                                                @if ($chat->gambar)
                                                    <img src="{{ asset('storage/chat/' . $chat->gambar) }}" alt="Image" class="img-fluid mb-2"><br>
                                                @endif
                                                {{ $chat->message }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @else
                                <div class="d-flex justify-content-start">
                                    <div class="card chat-abu">
                                        <div class="card-body">
                                            <div class="content-justify mt-3" style="text-align: justify;">
                                                @if ($chat->gambar)
                                                    <img src="{{ asset('storage/chat/' . $chat->gambar) }}" alt="Image" class="img-fluid mb-2"><br>
                                                @endif
                                                {{ $chat->message }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        @elseif ($currentUser->level == 'siswa')
                            @if ($chat->from_user_id == $currentUser->id)
                                <div class="d-flex justify-content-end">
                                    <div class="card chat-hijau">
                                        <div class="card-body">
                                            <div class="content-justify mt-3" style="text-align: justify;">
                                                @if ($chat->gambar)
                                                    <img src="{{ asset('storage/chat/' . $chat->gambar) }}" alt="Image" class="img-fluid mb-2"><br>
                                                @endif
                                                {{ $chat->message }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @else
                                <div class="d-flex justify-content-start">
                                    <div class="card chat-abu">
                                        <div class="card-body">
                                            <div class="content-justify mt-3" style="text-align: justify;">
                                                @if ($chat->gambar)
                                                    <img src="{{ asset('storage/chat/' . $chat->gambar) }}" alt="Image" class="img-fluid mb-2"><br>
                                                @endif
                                                {{ $chat->message }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        @endif
                    @endforeach
                </div>
            </div>
        </section>

        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center">
                @if (auth()->user()->level == 'superadmin')
                    <form action="{{ route('admin.chat.store', $targetUser->id) }}" method="post" enctype="multipart/form-data"
                        class="d-flex search-form w-100">
                    @elseif (auth()->user()->level == 'admin')
                        <form action="{{ route('admin.chat.store', $targetUser->id) }}" method="post" enctype="multipart/form-data"
                            class="d-flex search-form w-100">
                        @elseif (auth()->user()->level == 'siswa')
                            <form action="{{ route('user.chat.store', $targetUser->id) }}" method="post" enctype="multipart/form-data"
                                class="d-flex search-form w-100">
                @endif
                @csrf
                <a class="btn btn-primary btn-sm" title="Upload gambar profile baru">
                    <i class="ri ri-attachment-line"></i>
                    <input type="file" class="form-control @error('gambar') is-invalid @enderror" name="gambar" id="formFileFoto"
                        style="display: none;" placeholder="Foto" onchange="this.nextElementSibling.textContent = this.files[0].name;">
                    <span></span>
                    @error('gambar')
                        <div class="invalid-feedback text-white">
                            {{ $message }}
                        </div>
                    @enderror
                </a>
                <input type="text" class="form-control ms-2 @error('message') is-invalid @enderror" name="message" placeholder="Tulis pesan..."
                    value="{{ old('body') }}">
                <button type="submit" class="btn btn-primary ms-2">Kirim</button>
                </form>
            </div>
        </div>
    </main><!-- End #main -->

    <style>
        .chat-hijau {
            background-color: #b2c0ff91;
            color: black;
            max-width: 60%;
            border-radius: 15px 15px 0 15px;
        }

        .chat-abu {
            background-color: #ffffff;
            color: black;
            max-width: 60%;
            border-radius: 15px 15px 15px 0;
        }
    </style>

    <style>
        /* CSS untuk chat container */
        .chat-container {
            height: calc(80vh - 100px);
            /* Sesuaikan dengan tinggi header dan form kirim pesan */
            overflow-y: scroll;
            display: flex;
            flex-direction: column;
            /* Chat terbaru di bawah */
        }

        .card {
            margin-bottom: 10px;
            /* Memberikan jarak antar chat */
        }
    </style>

    <script>
        document.querySelector('.btn').addEventListener('click', function() {
            document.getElementById('formFileFoto').click();
        });
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var chatContainer = document.querySelector('.chat-container');
            chatContainer.scrollTop = chatContainer.scrollHeight;
        });
    </script>
@endsection
