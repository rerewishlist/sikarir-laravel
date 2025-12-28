@extends('layouts.main')
@section('title', 'Edit Materi')
@section('content')
    <main id="main" class="main">

        <div class="pagetitle">
            @if (session()->has('success'))
                <div class="alert alert-primary alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            <h1>Edit Materi "{{ $materi->judul }}"</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('datamateri.view') }}">Data Materi</a></li>
                    <li class="breadcrumb-item active">Edit Materi "{{ $materi->judul }}"</li>
                </ol>
            </nav>
        </div><!-- End Page Title -->

        <section class="section">
            <div class="row">
                <div class="col-lg-12">

                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Edit Materi</h5>
                            <form method="POST" action="{{ route('datamateri.update', $materi->id) }}" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <div class="row mb-3">
                                    <label for="inputEmail3" class="col-sm-2 col-form-label">Judul</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control @error('judul') is-invalid @enderror" name="judul" id="inputText"
                                            placeholder="Masukan judul" value="{{ old('judul', $materi->judul ?? '') }}">
                                        @error('judul')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <label for="inputEmail3" class="col-sm-2 col-form-label">Deskripsi</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control @error('deskripsi') is-invalid @enderror" name="deskripsi"
                                            id="inputText" placeholder="Masukan deskripsi" value="{{ old('deskripsi', $materi->deskripsi ?? '') }}">
                                        @error('deskripsi')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <label class="col-form-label col-sm-2 pt-0">File Pendukung</label>
                                    <div class="col-sm-10 ">
                                        @if ($materi->file_pendukung)
                                            @php
                                                $fileExtension = pathinfo($materi->file_pendukung, PATHINFO_EXTENSION);
                                            @endphp

                                            <div class="d-flex align-items-center mt-2">
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
                                                    <img src="{{ asset('storage/materi/' . $materi->file_pendukung) }}" alt="Gambar materi"
                                                        class="img-thumbnail" style="width: 100px; height: 100px; object-fit: cover;">
                                                @else
                                                    <i class="bi bi-file-text" style="font-size: 24px;"></i>
                                                @endif
                                                </a>
                                            </div>
                                        @endif
                                        <div class="pt-2">
                                            <a class="btn btn-primary btn-sm" title="Upload file pendukung baru">
                                                <i class="bi bi-upload"></i>
                                                <input type="file" class="form-control @error('file_pendukung') is-invalid @enderror"
                                                    name="file_pendukung" id="formFileFoto" style="display: none;" placeholder="Foto"
                                                    onchange="this.nextElementSibling.textContent = this.files[0].name;">
                                                <span>Upload</span>
                                                @error('file_pendukung')
                                                    <div class="invalid-feedback text-white">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </a>
                                        </div>
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <label for="inputEmail3" class="col-sm-2 col-form-label">Content</label>
                                    <div class="col-sm-10">
                                        <div id="quill-editor" class="mb-3" style="height: 300px;">
                                        </div>
                                        <textarea rows="3" class="mb-3 d-none" name="content" id="quill-editor-area">{{ old('content', $materi->content ?? '') }}</textarea>
                                        @error('content')
                                            <div class="invalid-feedback d-block">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="text-center">
                                    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                                </div>
                            </form><!-- End Horizontal Form -->

                        </div>
                    </div>

                </div>
            </div>
        </section>

        <script>
            document.querySelector('.btn').addEventListener('click', function() {
                document.getElementById('formFileFoto').click();
            });
        </script>

        <script>
            document.addEventListener('DOMContentLoaded', function() {
                if (document.getElementById('quill-editor-area')) {
                    var editor = new Quill('#quill-editor', {
                        theme: 'snow'
                    });
                    var quillEditor = document.getElementById('quill-editor-area');
                    editor.root.innerHTML = quillEditor.value; // Set initial content
                    editor.on('text-change', function() {
                        quillEditor.value = editor.root.innerHTML;
                    });

                    quillEditor.addEventListener('input', function() {
                        editor.root.innerHTML = quillEditor.value;
                    });
                }
            });
        </script>

        <style>
            .editor-container {
                padding-bottom: 50px;
                /* Menambahkan padding bawah pada kontainer editor */
            }
        </style>

    </main><!-- End #main -->
@endsection
