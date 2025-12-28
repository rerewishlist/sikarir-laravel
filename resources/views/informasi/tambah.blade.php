@extends('layouts.main')
@section('content')
@section('title', 'Data Informasi')
<main id="main" class="main">

    <div class="pagetitle">
        @if (session()->has('success'))
            <div class="alert alert-primary alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        <h1>Tambah Informasi
<button type="button" class="btn btn-link p-0" data-bs-toggle="modal" data-bs-target="#infoModal">
    <i class="bi bi-question-circle fs-5"></i>
</button>
        </h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item active">Tambah Informasi</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <section class="section profile">
        <div class="row">

            <!-- Profile Card -->
            <div class="col-xl-12">
                <div class="card">
                    <div class="card-body pt-3">

                        <ul class="nav nav-tabs nav-tabs-bordered">
                            <li class="nav-item">
                                <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#profile-edit">Tambah
                                    Informasi</button>
                            </li>
                        </ul>

                        <div class="tab-content pt-2">
                            <!-- Profile Edit Form -->
                            <div class="tab-pane fade show active profile-edit pt-3" id="profile-edit">
                                <form method="POST" action="{{ route('informasi.create') }}" enctype="multipart/form-data">
                                    @csrf

                                    <div class="row mb-3">
                                        <label for="fullName" class="col-md-4 col-lg-3 col-form-label">Instansi</label>
                                        <div class="col-md-8 col-lg-9">
                                            <input type="text" class="form-control @error('instansi') is-invalid @enderror" name="instansi"
                                                id="fullName" placeholder="Instansi" value="{{ old('instansi') }}">
                                            @error('instansi')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <label for="fullName" class="col-md-4 col-lg-3 col-form-label">Alamat</label>
                                        <div class="col-md-8 col-lg-9">
                                            <input type="text" class="form-control @error('alamat') is-invalid @enderror" name="alamat"
                                                id="fullName" placeholder="Alamat" value="{{ old('alamat') }}">
                                            @error('alamat')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <label for="fullName" class="col-md-4 col-lg-3 col-form-label">No HP</label>
                                        <div class="col-md-8 col-lg-9">
                                            <input type="text" class="form-control @error('nohp') is-invalid @enderror" name="nohp"
                                                id="fullName" placeholder="No HP" value="{{ old('nohp') }}">
                                            @error('nohp')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <label for="fullName" class="col-md-4 col-lg-3 col-form-label">Email</label>
                                        <div class="col-md-8 col-lg-9">
                                            <input type="email" class="form-control @error('email') is-invalid @enderror" name="email"
                                                id="fullName" placeholder="Email" value="{{ old('email') }}">
                                            @error('email')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <label for="fullName" class="col-md-4 col-lg-3 col-form-label">Deskripsi</label>
                                        <div class="col-md-8 col-lg-9">
                                            <input type="text" class="form-control @error('deskripsi') is-invalid @enderror" name="deskripsi"
                                                id="fullName" placeholder="Deskripsi" value="{{ old('deskripsi') }}">
                                            @error('deskripsi')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <label for="fullName" class="col-md-4 col-lg-3 col-form-label">Video Youtube</label>
                                        <div class="col-md-8 col-lg-9">
                                            <input type="text" class="form-control @error('videoyt') is-invalid @enderror" name="videoyt"
                                                id="fullName" placeholder="Masukan link video youtube" value="{{ old('videoyt') }}">
                                            @error('videoyt')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <label for="fullName" class="col-md-4 col-lg-3 col-form-label">Facebook</label>
                                        <div class="col-md-8 col-lg-9">
                                            <input type="text" class="form-control @error('facebook') is-invalid @enderror" name="facebook"
                                                id="fullName" placeholder="Facebook" value="{{ old('facebook') }}">
                                            @error('facebook')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <label for="fullName" class="col-md-4 col-lg-3 col-form-label">Instagram</label>
                                        <div class="col-md-8 col-lg-9">
                                            <input type="text" class="form-control @error('instagram') is-invalid @enderror" name="instagram"
                                                id="fullName" placeholder="Instagram" value="{{ old('instagram') }}">
                                            @error('instagram')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <label for="fullName" class="col-md-4 col-lg-3 col-form-label">Twitter</label>
                                        <div class="col-md-8 col-lg-9">
                                            <input type="text" class="form-control @error('twitter') is-invalid @enderror" name="twitter"
                                                id="fullName" placeholder="Twitter" value="{{ old('twitter') }}">
                                            @error('twitter')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <label for="fullName" class="col-md-4 col-lg-3 col-form-label">Youtube</label>
                                        <div class="col-md-8 col-lg-9">
                                            <input type="text" class="form-control @error('youtube') is-invalid @enderror" name="youtube"
                                                id="fullName" placeholder="Youtube" value="{{ old('youtube') }}">
                                            @error('youtube')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <label for="fullName" class="col-md-4 col-lg-3 col-form-label">Tiktok</label>
                                        <div class="col-md-8 col-lg-9">
                                            <input type="text" class="form-control @error('tiktok') is-invalid @enderror" name="tiktok"
                                                id="fullName" placeholder="Tiktok" value="{{ old('tiktok') }}">
                                            @error('tiktok')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="text-center">
                                        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                                    </div>
                                </form>
                            </div><!-- End Profile Edit Form -->

                        </div>
                    </div>
                </div>
            </div> <!-- End Profile Card -->



    </section>
<!-- Modal -->
<div class="modal fade" id="infoModal" tabindex="-1" aria-labelledby="infoModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl"> <!-- Menambahkan modal-lg untuk lebar lebih besar -->
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="infoModalLabel">Panduan Informasi</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Informasi digunakan untuk menu yang akan tampil di menu contact halaman depan. Jika belum ada data informasi yang disimpan, menu "contact" tidak akan muncul<br>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>
</main><!-- End #main -->

<script>
    document.querySelector('.btn').addEventListener('click', function() {
        document.getElementById('formFileFoto').click();
    });
</script>
@endsection
