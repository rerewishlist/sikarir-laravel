@extends('layouts.main')
@section('content')
    <!-- Jika Auth Level Admin -->
    @if (auth()->user()->level == 'superadmin')
        @section('title', 'Profile Super Admin')
        <main id="main" class="main">

            <div class="pagetitle">
                @if (session()->has('success'))
                    <div class="alert alert-primary alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
                <h1>Profile Super Admin</h1>
                <nav>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Profile Super Admin</li>
                    </ol>
                </nav>
            </div><!-- End Page Title -->

            <section class="section profile">
                <div class="row">

                    <!-- Photo Card -->
                    <div class="col-xl-4">
                        <div class="card">
                            <div class="card-body profile-card pt-4 d-flex flex-column align-items-center">
                                @if ($currentUser->foto)
                                    <img src="{{ asset('storage/foto/' . $currentUser->foto) }}" alt="Profile" class="rounded-circle"
                                        style="width: 120px; height: 120px; object-fit: cover; border-radius: 50%;">
                                @else
                                    <img src="{{ asset('assets/img/blank-profile-picture.jpg') }}" alt="Profile" class="rounded-circle"
                                        style="width: 120px; height: 120px; object-fit: cover; border-radius: 50%;">
                                @endif
                                <h2>{{ $currentUser->nama }}</h2>
                                <h3>{{ $currentUser->level }}</h3>
                            </div>
                        </div>
                    </div>

                    <!-- Profile Card -->
                    <div class="col-xl-8">
                        <div class="card">
                            <div class="card-body pt-3">

                                <ul class="nav nav-tabs nav-tabs-bordered">
                                    <li class="nav-item">
                                        <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#profile-edit">Edit
                                            Profile</button>
                                    </li>
                                </ul>

                                <div class="tab-content pt-2">
                                    <!-- Profile Edit Form -->
                                    <div class="tab-pane fade show active profile-edit pt-3" id="profile-edit">
                                        <form method="post" action="{{ route('profile.admin.update') }}" enctype="multipart/form-data">
                                            @csrf
                                            @method('patch')
                                            <div class="row mb-3">
                                                <label for="profileImage" class="col-md-4 col-lg-3 col-form-label">Foto
                                                    Profile</label>
                                                <div class="col-md-8 col-lg-9">
                                                    @if ($currentUser->foto)
                                                        <img src="{{ asset('storage/foto/' . $currentUser->foto) }}" alt="Profile"
                                                            class="img-thumbnail mt-2" style="width: 120px; height: 120px; object-fit: cover;">
                                                    @else
                                                        <img src="{{ asset('assets/img/blank-profile-picture.jpg') }}" alt="Profile"
                                                            class="img-thumbnail mt-2" style="width: 120px; height: 120px; object-fit: cover;">
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
                                                <label for="fullName" class="col-md-4 col-lg-3 col-form-label">Nama</label>
                                                <div class="col-md-8 col-lg-9">
                                                    <input type="text" class="form-control @error('nama') is-invalid @enderror" name="nama"
                                                        id="fullName" placeholder="Nama" value="{{ $currentUser->nama }}">
                                                    @error('nama')
                                                        <div class="invalid-feedback">
                                                            {{ $message }}
                                                        </div>
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="row mb-3">
                                                <label for="userName" class="col-md-4 col-lg-3 col-form-label">Username</label>
                                                <div class="col-md-8 col-lg-9">
                                                    <input type="text" class="form-control @error('username') is-invalid @enderror" name="username"
                                                        id="userName" placeholder="Username" value="{{ $currentUser->username }}">
                                                    @error('username')
                                                        <div class="invalid-feedback">
                                                            {{ $message }}
                                                        </div>
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="row mb-3">
                                                <label for="nomorHp" class="col-md-4 col-lg-3 col-form-label">Nomor
                                                    HP</label>
                                                <div class="col-md-8 col-lg-9">
                                                    <input type="text" class="form-control @error('nohp') is-invalid @enderror" name="nohp"
                                                        id="nomorHp" placeholder="Nomor HP" value="{{ $currentUser->nohp }}">
                                                    @error('nohp')
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

                    <div class="col-xl-4"></div>

                    <!-- Password Card -->
                    <div class="col-xl-8">
                        <div class="card">
                            <div class="card-body pt-3">

                                <ul class="nav nav-tabs nav-tabs-bordered">
                                    <li class="nav-item">
                                        <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#profile-change-password">Ganti
                                            Password</button>
                                    </li>
                                </ul>

                                <div class="tab-content pt-2">
                                    <!-- Change Password Form -->
                                    <div class="tab-pane fade show active pt-3" id="profile-change-password">
                                        <form method="post" action="{{ route('admin.password.update') }}">
                                            @csrf
                                            @method('put')
                                            <div class="row mb-3">
                                                <label for="currentPassword" class="col-md-4 col-lg-3 col-form-label">Current
                                                    Password</label>
                                                <div class="col-md-8 col-lg-9">
                                                    <input name="current_password" type="password"
                                                        class="form-control  @error('current_password', 'updatePassword') is-invalid @enderror"
                                                        id="currentPassword">
                                                    @error('current_password', 'updatePassword')
                                                        <div class="invalid-feedback">
                                                            {{ $message }}
                                                        </div>
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="row mb-3">
                                                <label for="newPassword" class="col-md-4 col-lg-3 col-form-label">New
                                                    Password</label>
                                                <div class="col-md-8 col-lg-9">
                                                    <input name="password" type="password"
                                                        class="form-control @error('password', 'updatePassword') is-invalid @enderror" id="newPassword">
                                                    @error('password', 'updatePassword')
                                                        <div class="invalid-feedback">
                                                            {{ $message }}
                                                        </div>
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="row mb-3">
                                                <label for="renewPassword" class="col-md-4 col-lg-3 col-form-label">Re-enter
                                                    New Password</label>
                                                <div class="col-md-8 col-lg-9">
                                                    <input name="password_confirmation" type="password"
                                                        class="form-control @error('password_confirmation', 'updatePassword') is-invalid @enderror"
                                                        id="renewPassword">
                                                    @error('password_confirmation', 'updatePassword')
                                                        <div class="invalid-feedback">
                                                            {{ $message }}
                                                        </div>
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="text-center">
                                                <button type="submit" class="btn btn-primary">Ubah Password</button>
                                            </div>
                                        </form><!-- End Change Password Form -->

                                    </div><!-- End Change Password Form -->

                                </div>
                            </div>
                        </div>
                    </div> <!-- End Password Card -->
                </div>

            </section>

        </main><!-- End #main -->
    @endif
    <!-- Jika Auth Level Admin -->
    @if (auth()->user()->level == 'admin')
        @section('title', 'Profile Admin')
        <main id="main" class="main">

            <div class="pagetitle">
                @if (session()->has('success'))
                    <div class="alert alert-primary alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
                <h1>Profile Admin</h1>
                <nav>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Profile Admin</li>
                    </ol>
                </nav>
            </div><!-- End Page Title -->

            <section class="section profile">
                <div class="row">

                    <!-- Photo Card -->
                    <div class="col-xl-4">
                        <div class="card">
                            <div class="card-body profile-card pt-4 d-flex flex-column align-items-center">
                                @if ($currentUser->foto)
                                    <img src="{{ asset('storage/foto/' . $currentUser->foto) }}" alt="Profile" class="rounded-circle"
                                        style="width: 120px; height: 120px; object-fit: cover; border-radius: 50%;">
                                @else
                                    <img src="{{ asset('assets/img/blank-profile-picture.jpg') }}" alt="Profile" class="rounded-circle"
                                        style="width: 120px; height: 120px; object-fit: cover; border-radius: 50%;">
                                @endif
                                <h2>{{ $currentUser->nama }}</h2>
                                <h3>{{ $currentUser->level }}</h3>
                            </div>
                        </div>
                    </div>

                    <!-- Profile Card -->
                    <div class="col-xl-8">
                        <div class="card">
                            <div class="card-body pt-3">

                                <ul class="nav nav-tabs nav-tabs-bordered">
                                    <li class="nav-item">
                                        <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#profile-edit">Edit
                                            Profile</button>
                                    </li>
                                </ul>

                                <div class="tab-content pt-2">
                                    <!-- Profile Edit Form -->
                                    <div class="tab-pane fade show active profile-edit pt-3" id="profile-edit">
                                        <form method="post" action="{{ route('profile.admin.update') }}" enctype="multipart/form-data">
                                            @csrf
                                            @method('patch')
                                            <div class="row mb-3">
                                                <label for="profileImage" class="col-md-4 col-lg-3 col-form-label">Foto
                                                    Profile</label>
                                                <div class="col-md-8 col-lg-9">
                                                    @if ($currentUser->foto)
                                                        <img src="{{ asset('storage/foto/' . $currentUser->foto) }}" alt="Profile"
                                                            class="img-thumbnail mt-2" style="width: 120px; height: 120px; object-fit: cover;">
                                                    @else
                                                        <img src="{{ asset('assets/img/blank-profile-picture.jpg') }}" alt="Profile"
                                                            class="img-thumbnail mt-2" style="width: 120px; height: 120px; object-fit: cover;">
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
                                                <label for="fullName" class="col-md-4 col-lg-3 col-form-label">Nama</label>
                                                <div class="col-md-8 col-lg-9">
                                                    <input type="text" class="form-control @error('nama') is-invalid @enderror" name="nama"
                                                        id="fullName" placeholder="Nama" value="{{ $currentUser->nama }}">
                                                    @error('nama')
                                                        <div class="invalid-feedback">
                                                            {{ $message }}
                                                        </div>
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="row mb-3">
                                                <label for="userName" class="col-md-4 col-lg-3 col-form-label">Username</label>
                                                <div class="col-md-8 col-lg-9">
                                                    <input type="text" class="form-control @error('username') is-invalid @enderror" name="username"
                                                        id="userName" placeholder="Username" value="{{ $currentUser->username }}">
                                                    @error('username')
                                                        <div class="invalid-feedback">
                                                            {{ $message }}
                                                        </div>
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="row mb-3">
                                                <label for="nomorHp" class="col-md-4 col-lg-3 col-form-label">Nomor
                                                    HP</label>
                                                <div class="col-md-8 col-lg-9">
                                                    <input type="text" class="form-control @error('nohp') is-invalid @enderror" name="nohp"
                                                        id="nomorHp" placeholder="Nomor HP" value="{{ $currentUser->nohp }}">
                                                    @error('nohp')
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

                    <div class="col-xl-4"></div>

                    <!-- Password Card -->
                    <div class="col-xl-8">
                        <div class="card">
                            <div class="card-body pt-3">

                                <ul class="nav nav-tabs nav-tabs-bordered">
                                    <li class="nav-item">
                                        <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#profile-change-password">Ganti
                                            Password</button>
                                    </li>
                                </ul>

                                <div class="tab-content pt-2">
                                    <!-- Change Password Form -->
                                    <div class="tab-pane fade show active pt-3" id="profile-change-password">
                                        <form method="post" action="{{ route('admin.password.update') }}">
                                            @csrf
                                            @method('put')
                                            <div class="row mb-3">
                                                <label for="currentPassword" class="col-md-4 col-lg-3 col-form-label">Current
                                                    Password</label>
                                                <div class="col-md-8 col-lg-9">
                                                    <input name="current_password" type="password"
                                                        class="form-control  @error('current_password', 'updatePassword') is-invalid @enderror"
                                                        id="currentPassword">
                                                    @error('current_password', 'updatePassword')
                                                        <div class="invalid-feedback">
                                                            {{ $message }}
                                                        </div>
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="row mb-3">
                                                <label for="newPassword" class="col-md-4 col-lg-3 col-form-label">New
                                                    Password</label>
                                                <div class="col-md-8 col-lg-9">
                                                    <input name="password" type="password"
                                                        class="form-control @error('password', 'updatePassword') is-invalid @enderror" id="newPassword">
                                                    @error('password', 'updatePassword')
                                                        <div class="invalid-feedback">
                                                            {{ $message }}
                                                        </div>
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="row mb-3">
                                                <label for="renewPassword" class="col-md-4 col-lg-3 col-form-label">Re-enter
                                                    New Password</label>
                                                <div class="col-md-8 col-lg-9">
                                                    <input name="password_confirmation" type="password"
                                                        class="form-control @error('password_confirmation', 'updatePassword') is-invalid @enderror"
                                                        id="renewPassword">
                                                    @error('password_confirmation', 'updatePassword')
                                                        <div class="invalid-feedback">
                                                            {{ $message }}
                                                        </div>
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="text-center">
                                                <button type="submit" class="btn btn-primary">Ubah Password</button>
                                            </div>
                                        </form><!-- End Change Password Form -->

                                    </div><!-- End Change Password Form -->

                                </div>
                            </div>
                        </div>
                    </div> <!-- End Password Card -->
                </div>

            </section>

        </main><!-- End #main -->
    @endif
    <!-- Jika Auth Level Siswa -->
    @if (auth()->user()->level == 'siswa')
        @section('title', 'Profile Siswa')
        <main id="main" class="main">

            <div class="pagetitle">
                @if (session()->has('success'))
                    <div class="alert alert-primary alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
                <h1>Profile Siswa</h1>
                <nav>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Profile Siswa</li>
                    </ol>
                </nav>
            </div><!-- End Page Title -->

            <section class="section profile">
                <div class="row">

                    <!-- Photo Card + Profil-->
                    <div class="col-xl-4">
                        <div class="card">
                            <div class="card-body profile-card pt-4 d-flex flex-column align-items-center">
                                @if ($currentUser->foto)
                                    <img src="{{ asset('storage/foto/' . $currentUser->foto) }}" alt="Profile" class="rounded-circle"
                                        style="width: 120px; height: 120px; object-fit: cover; border-radius: 50%;">
                                @else
                                    <img src="{{ asset('assets/img/blank-profile-picture.jpg') }}" alt="Profile" class="rounded-circle"
                                        style="width: 120px; height: 120px; object-fit: cover; border-radius: 50%;">
                                @endif
                                <h2>{{ $currentUser->nama }}</h2>
                                <h3>{{ $currentUser->level }}</h3>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-body pt-3">
                                <div class="tab-content pt-2">
                                    <!-- Profile Edit Form -->
                                    <div class="tab-pane fade show active profile-edit pt-3" id="profile-edit">
                                        <form>
                                            <div class="row mb-3">
                                                <label class="col-md-4 col-lg-3 col-form-label">NIS</label>
                                                <div class="col-md-8 col-lg-9">
                                                    <input type="text" class="form-control" value="{{ $currentUser->nis }}" disabled>
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <label class="col-md-4 col-lg-3 col-form-label">Nama</label>
                                                <div class="col-md-8 col-lg-9">
                                                    <input type="text" class="form-control" value="{{ $currentUser->nama }}" disabled>
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <label class="col-md-4 col-lg-3 col-form-label">Jurusan</label>
                                                <div class="col-md-8 col-lg-9">
                                                    <input type="text" class="form-control" value="{{ $jurusan }}" disabled>
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <label class="col-md-4 col-lg-3 col-form-label">Kelas</label>
                                                <div class="col-md-8 col-lg-9">
                                                    <input type="text" class="form-control"
                                                        value="{{ $currentUser->kelas . ' ' . $currentUser->subkelas }}" disabled>
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <label class="col-md-4 col-lg-3 col-form-label">Tmp Lahir</label>
                                                <div class="col-md-8 col-lg-9">
                                                    <input type="text" class="form-control" value="{{ $currentUser->tempat_lahir }}" disabled>
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <label class="col-md-4 col-lg-3 col-form-label">Tgl Lahir</label>
                                                <div class="col-md-8 col-lg-9">
                                                    <input type="text" class="form-control" value="{{ $currentUser->tanggal_lahir }}" disabled>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Profile Card -->
                    <div class="col-xl-8">
                        <div class="card">
                            <div class="card-body pt-3">

                                <ul class="nav nav-tabs nav-tabs-bordered">
                                    <li class="nav-item">
                                        <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#profile-edit">Edit
                                            Profile</button>
                                    </li>
                                </ul>

                                <div class="tab-content pt-2">
                                    <!-- Profile Edit Form -->
                                    <div class="tab-pane fade show active profile-edit pt-3" id="profile-edit">
                                        <form method="post" action="{{ route('profile.update') }}" enctype="multipart/form-data">
                                            @csrf
                                            @method('patch')
                                            <div class="row mb-3">
                                                <label for="profileImage" class="col-md-4 col-lg-3 col-form-label">Foto
                                                    Profile</label>
                                                <div class="col-md-8 col-lg-9">
                                                    @if ($currentUser->foto)
                                                        <img src="{{ asset('storage/foto/' . $currentUser->foto) }}" alt="Profile"
                                                            class="img-thumbnail mt-2" style="width: 120px; height: 120px; object-fit: cover;">
                                                    @else
                                                        <img src="{{ asset('assets/img/blank-profile-picture.jpg') }}" alt="Profile"
                                                            class="img-thumbnail mt-2" style="width: 120px; height: 120px; object-fit: cover;">
                                                    @endif
                                                    <div class="pt-2">
                                                        <a class="btn btn-primary btn-sm" title="Upload foto profile baru">
                                                            <i class="bi bi-upload"></i>
                                                            <input type="file" class="form-control @error('foto') is-invalid @enderror"
                                                                name="foto" id="formFileFoto" style="display: none;" placeholder="Foto"
                                                                onchange="this.nextElementSibling.textContent = this.files[0].name;">
                                                            <span>Upload</span>
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row mb-3">
                                                <label for="alamat" class="col-md-4 col-lg-3 col-form-label">Alamat</label>
                                                <div class="col-md-8 col-lg-9">
                                                    <input type="text" class="form-control @error('alamat') is-invalid @enderror" name="alamat"
                                                        id="alamat" placeholder="Alamat" value="{{ $currentUser->alamat }}">
                                                    @error('alamat')
                                                        <div class="invalid-feedback">
                                                            {{ $message }}
                                                        </div>
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="row mb-3">
                                                <label for="nomorHp" class="col-md-4 col-lg-3 col-form-label">Nomor
                                                    HP</label>
                                                <div class="col-md-8 col-lg-9">
                                                    <input type="text" class="form-control @error('nohp') is-invalid @enderror" name="nohp"
                                                        id="nomorHp" placeholder="Nomor HP" value="{{ $currentUser->nohp }}">
                                                    @error('nohp')
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
                        <div class="card">
                            <div class="card-body pt-3">

                                <ul class="nav nav-tabs nav-tabs-bordered">
                                    <li class="nav-item">
                                        <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#profile-change-password">Ganti
                                            Password</button>
                                    </li>
                                </ul>

                                <div class="tab-content pt-2">
                                    <!-- Change Password Form -->
                                    <div class="tab-pane fade show active pt-3" id="profile-change-password">
                                        <form method="post" action="{{ route('password.update') }}">
                                            @csrf
                                            @method('put')
                                            <div class="row mb-3">
                                                <label for="currentPassword" class="col-md-4 col-lg-3 col-form-label">Current
                                                    Password</label>
                                                <div class="col-md-8 col-lg-9">
                                                    <input name="current_password" type="password"
                                                        class="form-control  @error('current_password', 'updatePassword') is-invalid @enderror"
                                                        id="currentPassword">
                                                    @error('current_password', 'updatePassword')
                                                        <div class="invalid-feedback">
                                                            {{ $message }}
                                                        </div>
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="row mb-3">
                                                <label for="newPassword" class="col-md-4 col-lg-3 col-form-label">New
                                                    Password</label>
                                                <div class="col-md-8 col-lg-9">
                                                    <input name="password" type="password"
                                                        class="form-control @error('password', 'updatePassword') is-invalid @enderror"
                                                        id="newPassword">
                                                    @error('password', 'updatePassword')
                                                        <div class="invalid-feedback">
                                                            {{ $message }}
                                                        </div>
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="row mb-3">
                                                <label for="renewPassword" class="col-md-4 col-lg-3 col-form-label">Re-enter
                                                    New Password</label>
                                                <div class="col-md-8 col-lg-9">
                                                    <input name="password_confirmation" type="password"
                                                        class="form-control @error('password_confirmation', 'updatePassword') is-invalid @enderror"
                                                        id="renewPassword">
                                                    @error('password_confirmation', 'updatePassword')
                                                        <div class="invalid-feedback">
                                                            {{ $message }}
                                                        </div>
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="text-center">
                                                <button type="submit" class="btn btn-primary">Ubah Password</button>
                                            </div>
                                        </form><!-- End Change Password Form -->

                                    </div><!-- End Change Password Form -->

                                </div>
                            </div>
                        </div>
                    </div> <!-- End Profile Card -->

                    <div class="col-xl-4"></div>

                    <!-- Password Card -->
                    <div class="col-xl-8">

                    </div> <!-- End Password Card -->
                </div>

            </section>

        </main><!-- End #main -->
    @endif
    <script>
        document.querySelector('.btn').addEventListener('click', function() {
            document.getElementById('formFileFoto').click();
        });
    </script>
@endsection
