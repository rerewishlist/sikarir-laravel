@extends('layouts.main')
@section('title', 'Tambah Forum Baru')
@section('content')
    <main id="main" class="main">

        <div class="pagetitle">
            @if (session()->has('success'))
                <div class="alert alert-primary alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            <h1>Tambah Forum Baru
<button type="button" class="btn btn-link p-0" data-bs-toggle="modal" data-bs-target="#infoModal">
    <i class="bi bi-question-circle fs-5"></i>
</button>             
            </h1>
            <nav>
                <ol class="breadcrumb">
                    @if (auth()->user()->level == 'admin')
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.dataforum.view') }}">Data Forum Diskusi</a></li>
                    @elseif (auth()->user()->level == 'admin')
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.dataforum.view') }}">Data Forum Diskusi</a></li>
                    @elseif (auth()->user()->level == 'siswa')
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('user.dataforum.view') }}">Data Forum Diskusi</a></li>
                    @endif
                    <li class="breadcrumb-item active">Tambah Forum Baru</li>
                </ol>
            </nav>
        </div><!-- End Page Title -->

        <section class="section">
            <div class="row">
                <div class="col-lg-12">

                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Tambah Forum Baru</h5>
                            @if (auth()->user()->level == 'superadmin')
                                <form method="POST" action="{{ route('admin.dataforum.store') }}" enctype="multipart/form-data">
                            @endif
                            @if (auth()->user()->level == 'admin')
                                <form method="POST" action="{{ route('admin.dataforum.store') }}" enctype="multipart/form-data">
                            @endif
                            @if (auth()->user()->level == 'siswa')
                                <form method="POST" action="{{ route('user.dataforum.store') }}" enctype="multipart/form-data">
                            @endif
                            @csrf
                            <div class="row mb-3">
                                <label for="inputEmail3" class="col-sm-2 col-form-label">Judul Forum</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control @error('judul_forum') is-invalid @enderror" name="judul_forum"
                                        id="inputText" placeholder="Masukan judul" value="{{ old('judul_forum') }}">
                                    @error('judul_forum')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label class="col-form-label col-sm-2 pt-0">Gambar (Jika Ada)</label>
                                <div class="col-sm-10 ">
                                    <a class="btn btn-primary btn-sm btn-upload" title="Upload gambar profile baru">
                                        <i class="bi bi-upload"></i>
                                        <input type="file" class="form-control @error('gambar') is-invalid @enderror" name="gambar" id="formFileFoto"
                                            style="display: none;" placeholder="Foto"
                                            onchange="this.nextElementSibling.textContent = this.files[0].name;">
                                        <span>Upload</span>
                                        @error('gambar')
                                            <div class="invalid-feedback text-white">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </a>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="inputEmail3" class="col-sm-2 col-form-label">Content</label>
                                <div class="col-sm-10">
                                    <div id="quill-editor" class="mb-3" style="height: 300px;"></div>
                                    <textarea rows="3" class="mb-3 d-none" name="content" id="quill-editor-area">{{ old('content') }}</textarea>
                                    @error('content')
                                        <div class="invalid-feedback d-block">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>


                            <div class="text-center">
                                <button type="submit" class="btn btn-primary">Simpan</button>
                                <button type="reset" class="btn btn-secondary">Reset</button>
                            </div>
                            </form><!-- End Horizontal Form -->

                        </div>
                    </div>

                </div>
            </div>
        </section>

        <script>
document.querySelector('.btn-upload').addEventListener('click', function() {
    document.getElementById('formFileFoto').click();
});
        </script>

        <!-- Script Forum -->
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                if (document.getElementById('quill-editor-area')) {
                    var editor = new Quill('#quill-editor', {
                        theme: 'snow'
                    });
                    var quillEditor = document.getElementById('quill-editor-area');

                    // Set initial content from the textarea
                    editor.root.innerHTML = quillEditor.value;

                    editor.on('text-change', function() {
                        quillEditor.value = editor.root.innerHTML;
                    });

                    // When the form is submitted, copy the content from Quill to the textarea
                    document.querySelector('form').onsubmit = function() {
                        quillEditor.value = editor.root.innerHTML;
                    };
                }
            });
        </script>

        <style>
            .editor-container {
                padding-bottom: 50px;
                /* Menambahkan padding bawah pada kontainer editor */
            }
        </style>
<!-- Modal -->
<div class="modal fade" id="infoModal" tabindex="-1" aria-labelledby="infoModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl"> <!-- Menambahkan modal-lg untuk lebar lebih besar -->
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="infoModalLabel">💡Panduan Menambahkan Forum Baru</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                🔹 Masukan judul forum, gambar (opsional), dan juga isi konten dengan topik yang akan dibahas.<br>
                🔹 Tekan simpan.<br>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>
    </main><!-- End #main -->
@endsection
