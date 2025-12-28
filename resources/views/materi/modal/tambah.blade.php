@extends('layouts.main')
@section('title', 'Tambah Materi')
@section('content')
    <main id="main" class="main">

        <div class="pagetitle">
            @if (session()->has('success'))
                <div class="alert alert-primary alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            <h1>Tambah Materi Baru</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('datamateri.view') }}">Data Materi</a></li>
                    <li class="breadcrumb-item active">Tambah Materi Baru</li>
                </ol>
            </nav>
        </div><!-- End Page Title -->

        <section class="section">
            <div class="row">
                <div class="col-lg-12">

                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Tambah Materi Baru</h5>
                            <form method="POST" action="{{ route('datamateri.store') }}" enctype="multipart/form-data">
                                @csrf
                                <div class="row mb-3">
                                    <label for="inputEmail3" class="col-sm-2 col-form-label">Judul</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control @error('judul') is-invalid @enderror"
                                            name="judul" id="inputText" placeholder="Masukan judul" value="{{ old('judul') }}">
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
                                        <input type="text" class="form-control @error('deskripsi') is-invalid @enderror"
                                            name="deskripsi" id="inputText" placeholder="Masukan deskripsi" value="{{ old('deskripsi') }}">
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
                                        <a class="btn btn-primary btn-sm" title="Upload file pendukung">
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
            document.querySelector('.btn').addEventListener('click', function() {
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

    </main><!-- End #main -->
@endsection
