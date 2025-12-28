@extends('layouts.content-guest')
@section('title', 'Profile Page')
@section('content-guest')

    <main class="main">

        <!-- Page Title -->
        <div class="page-title" data-aos="fade">
            <div class="container d-lg-flex justify-content-between align-items-center">
                <h1 class="mb-2 mb-lg-0">Profile</h1>
                <nav class="breadcrumbs">
                    <ol>
                        <li><a href="{{ Route('dashboard') }}">Home</a></li>
                        <li class="current">Profile</li>
                    </ol>
                </nav>
            </div>
        </div><!-- End Page Title -->

        <!-- Service Details Section -->
        <section id="service-details" class="service-details section">

            <div class="container">
                <div class="row gy-5">
                    <div class="col-lg-3" data-aos="fade-up" data-aos-delay="100">
                        <div class="service-box">
                            <div class="services-list">
                                <a href="{{ route('profile.edit') }}" class="profile-link active">
                                    <i class="bi bi-arrow-right-circl"></i><span>Profile</span>
                                </a>
                                <a href="{{ route('password.edit') }}" class="password-link">
                                    <i class="bi bi-arrow-right-circle"></i><span>Password</span>
                                </a>
                            </div>
                        </div><!-- End Services List -->
                    </div>

                    <div class="col-lg-9 ps-lg-5" data-aos="fade-up">
                        <!-- Profile Section -->
                        <div id="profile-section" class="mb-5">
                            <form method="post" action="{{ route('profile.update') }}" enctype="multipart/form-data">
                                @csrf
                                @method('patch')

                                <div class="row mb-3">
                                    <label for="inputEmail3" class="col-sm-2 col-form-label">NIS</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" value="{{ $currentUser->nis }}" disabled>
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <label for="inputEmail3" class="col-sm-2 col-form-label">Nama</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" value="{{ $currentUser->nama }}" disabled>
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <label for="inputEmail3" class="col-sm-2 col-form-label">Kelas Jurusan</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control"
                                            value="{{ $currentUser->kelas . ' ' . $jurusan . ' ' . $currentUser->subkelas }}" disabled>
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <label for="inputEmail3" class="col-sm-2 col-form-label">Tempat Tanggal Lahir</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control"
                                            value="{{ $currentUser->tempat_lahir . ', ' . $currentUser->tanggal_lahir }}" disabled>
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <label class="col-form-label col-sm-2 pt-0">Foto</label>
                                    <div class="col-sm-10 ">
                                        @if ($currentUser->foto)
                                            <img src="{{ asset('storage/foto/' . $currentUser->foto) }}" alt="Profile" class="img-thumbnail mt-2"
                                                style="width: 120px; height: 120px; object-fit: cover;">
                                        @else
                                            <img src="{{ asset('assets/img/blank-profile-picture.jpg') }}" alt="Profile" class="img-thumbnail mt-2"
                                                style="width: 120px; height: 120px; object-fit: cover;">
                                        @endif
                                        <div class="pt-2">
                                            <a class="btn btn-primary btn-sm" title="Upload foto profile baru">
                                                <i class="bi bi-upload"></i>
                                                <input type="file" class="form-control @error('foto') is-invalid @enderror" name="foto"
                                                    id="formFileFoto" style="display: none;" placeholder="Foto"
                                                    onchange="this.nextElementSibling.textContent = this.files[0].name;">
                                                <span>Upload</span>
                                            </a>
                                        </div>
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <label for="inputEmail3" class="col-sm-2 col-form-label">Alamat</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control @error('alamat') is-invalid @enderror" name="alamat" id="inputText"
                                            placeholder="Masukan alamat" value="{{ $currentUser->alamat }}">
                                        @error('alamat')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <label for="inputEmail3" class="col-sm-2 col-form-label">Nomor HP</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control @error('nohp') is-invalid @enderror" name="nohp" id="inputText"
                                            placeholder="Masukan nohp" value="{{ $currentUser->nohp }}">
                                        @error('nohp')
                                            <div class="invalid-feedback">
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

    </main>

    <script>
        document.querySelector('.btn').addEventListener('click', function() {
            document.getElementById('formFileFoto').click();
        });
    </script>



    <style>
        .editor-container {
            padding-bottom: 50px;
            /* Menambahkan padding bawah pada kontainer editor */
        }
    </style>
@endsection
