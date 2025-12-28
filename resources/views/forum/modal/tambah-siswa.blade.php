@extends('layouts.content-guest')
@section('title', 'Forum Page')
@section('menuForum', 'active')
@section('content-guest')

    <main class="main">

        <!-- Page Title -->
        <div class="page-title" data-aos="fade">
            <div class="container d-lg-flex justify-content-between align-items-center">
                <h1 class="mb-2 mb-lg-0">Buat Forum
<button type="button" class="btn btn-link p-0" data-bs-toggle="modal" data-bs-target="#infoModal">
    <i class="bi bi-question-circle fs-5"></i>
</button> 
                </h1>
                <nav class="breadcrumbs">
                    <ol>
                        <li><a href="{{ Route('dashboard') }}">Home</a></li>
                        <li><a href="{{ Route('user.dataforum.view') }}">Forum</a></li>
                        <li class="current">Buat Forum</li>
                    </ol>
                </nav>
            </div>
        </div><!-- End Page Title -->

        <!-- Service Details Section -->
        <section id="service-details" class="service-details section">

            <div class="container">
                <div class="row gy-5">
                    <div class="col-lg-12 ps-lg-5" data-aos="fade-up">
                        <div class="mb-5">
                            <form method="POST" action="{{ route('user.dataforum.store') }}" enctype="multipart/form-data">
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
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>


        </section><!-- /Service Details Section -->
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
    </main>

    <script>
        window.addEventListener('load', function() {
            // Menghapus parameter pencarian dari URL saat halaman di-refresh
            var url = new URL(window.location.href);
            url.searchParams.delete('search_forum');
            url.searchParams.delete('filter_tanggal');
            window.history.replaceState({}, document.title, url.toString());
        });
    </script>

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
@endsection
