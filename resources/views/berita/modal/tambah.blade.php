@extends('layouts.main')
@section('title', 'Tambah Berita')
@section('content')
    <main id="main" class="main">

        <div class="pagetitle">
            @if (session()->has('success'))
                <div class="alert alert-primary alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            <h1>Tambah Berita Baru</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('databerita.view') }}">Data Berita</a></li>
                    <li class="breadcrumb-item active">Tambah Berita Baru</li>
                </ol>
            </nav>
        </div><!-- End Page Title -->

        <section class="section">
            <div class="row">
                <div class="col-lg-12">

                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Tambah Berita Baru</h5>
                            <form method="POST" action="{{ route('databerita.store') }}" enctype="multipart/form-data">
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

                                <input type="hidden" name="admin_id" value="{{ $currentUser->id }}">

                                <div class="row mb-3">
                                    <label class="col-form-label col-sm-2 pt-0">Kategori</label>
                                    <div class="col-sm-10 ">
                                        @foreach ($kategoris as $kategori)
                                            <div class="form-check">
                                                <input class="form-check-input @error('kategori_id') is-invalid @enderror"
                                                    type="radio" id="kategori_{{ $kategori->id }}" name="kategori_id[]"
                                                    value="{{ $kategori->id }}"
                                                    {{ is_array(old('kategori_id')) && in_array($kategori->id, old('kategori_id')) ? 'checked' : '' }}>
                                                <label class="form-check-label" for="kategori_{{ $kategori->id }}">
                                                    {{ $kategori->nama }}
                                                </label>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <label class="col-form-label col-sm-2 pt-0">Gambar</label>
                                    <div class="col-sm-10 ">
                                        <a class="btn btn-primary btn-sm" title="Upload gambar profile baru">
                                            <i class="bi bi-upload"></i>
                                            <input type="file" class="form-control @error('gambar') is-invalid @enderror"
                                                name="gambar" id="formFileFoto" style="display: none;" placeholder="Foto"
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

                                <div class="row mb-3">
                                    <label for="inputEmail3" class="col-sm-2 col-form-label">Lokasi</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control @error('lokasi') is-invalid @enderror"
                                            name="lokasi" id="inputText" placeholder="Masukan Lokasi" value="{{ old('lokasi') }}">
                                        @error('lokasi')
                                            <div class="invalid-feedback">
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
//             document.addEventListener('DOMContentLoaded', function() {
//     if (document.getElementById('quill-editor-area')) {
//         var editor = new Quill('#quill-editor', {
//             theme: 'snow'
//         });
//         var quillEditor = document.getElementById('quill-editor-area');

//         // Set initial content from the textarea
//         editor.root.innerHTML = quillEditor.value;

//         // Cek apakah URL menggunakan HTTPS
//         if (window.location.protocol === 'https:') {
//             // Jika ya, tambahkan tag <a> pada konten editor
//             editor.root.innerHTML = `<a href="#">${editor.root.innerHTML}</a>`;
//         }

//         editor.on('text-change', function() {
//             quillEditor.value = editor.root.innerHTML;
//         });

//         // When the form is submitted, copy the content from Quill to the textarea
//         document.querySelector('form').onsubmit = function() {
//             quillEditor.value = editor.root.innerHTML;
//         };
//     }
// });

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
