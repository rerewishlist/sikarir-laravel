@extends('layouts.main')
@section('title', 'Edit Berita')
@section('content')
    <main id="main" class="main">

        <div class="pagetitle">
            @if (session()->has('success'))
                <div class="alert alert-primary alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            <h1>Edit Berita "{{ $berita->judul }}"</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('databerita.view') }}">Data Berita</a></li>
                    <li class="breadcrumb-item active">Edit Berita "{{ $berita->judul }}"</li>
                </ol>
            </nav>
        </div><!-- End Page Title -->

        <section class="section">
            <div class="row">
                <div class="col-lg-12">

                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Edit Berita</h5>
                            <form method="POST" action="{{ route('databerita.update', $berita->id) }}" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <div class="row mb-3">
                                    <label for="inputEmail3" class="col-sm-2 col-form-label">Judul</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control @error('judul') is-invalid @enderror" name="judul" id="inputText"
                                            placeholder="Masukan judul" value="{{ old('judul', $berita->judul ?? '') }}">
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
                                                <input class="form-check-input @error('kategori_id') is-invalid @enderror" type="checkbox"
                                                    id="kategori_{{ $kategori->id }}" name="kategori_id[]" value="{{ $kategori->id }}"
                                                    {{ in_array($kategori->id, old('kategori_id', $berita->kategoris->pluck('id')->toArray() ?? [])) ? 'checked' : '' }}>
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
                                        @if ($berita->gambar)
                                            <img src="{{ asset('storage/berita/' . $berita->gambar) }}" alt="Gambar berita" class="img-thumbnail mt-2"
                                                style="width: 100px; height: 100px;">
                                        @endif
                                        <div class="pt-2">
                                            <a class="btn btn-primary btn-sm" title="Upload gambar profile baru">
                                                <i class="bi bi-upload"></i>
                                                <input type="file" class="form-control @error('gambar') is-invalid @enderror" name="gambar"
                                                    id="formFileFoto" style="display: none;" placeholder="Foto"
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
                                </div>

                                <div class="row mb-3">
                                    <label for="inputEmail3" class="col-sm-2 col-form-label">Content</label>
                                    <div class="col-sm-10">
                                        <div id="quill-editor" class="mb-3" style="height: 300px;">
                                        </div>
                                        <textarea rows="3" class="mb-3 d-none" name="content" id="quill-editor-area">{{ old('content', $berita->content ?? '') }}</textarea>
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
                                        <input type="text" class="form-control @error('lokasi') is-invalid @enderror" name="lokasi" id="inputText"
                                            placeholder="Masukan Lokasi" value="{{ old('lokasi', $berita->lokasi ?? '') }}">
                                        @error('lokasi')
                                            <div class="invalid-feedback">
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
