@extends('layouts.main')
@section('title', 'Chat Admin')
@section('content')
    <main id="main" class="main">

        <div class="pagetitle">
            @if (session()->has('success'))
                <div class="alert alert-primary alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            <h1>Chat Admin</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active">Chat Admin</li>
                </ol>
            </nav>
        </div><!-- End Page Title -->

        <section class="section">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="justify-content-between align-items-center mt-3">
                                <!-- Form Pencarian -->
                                <form method="GET" action="{{ url('/siswa/chat') }}" class="d-flex search-form">
                                    <input style="margin-right: 10px;" type="text" name="search" class="form-control"
                                        placeholder="Cari nama admin..." value="{{ request('search') }}">

                                    <button type="submit" class="btn btn-primary">Cari</button>
                                </form>
                                <!-- End Form Pencarian -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>


        <section class="section dashboard">
            <div class="row">

                @foreach ($admins as $item)
                    <!-- Card with an image on top -->
                    <div class="col-lg-3">
                        <div class="card text-center">
                            @if ($item->foto)
                                <img src="{{ asset('storage/foto/' . $item->foto) }}" alt="foto" class="card-img-top"
                                    style="height: 300px; object-fit: cover;">
                            @else
                                <img src="{{ asset('assets/img/blank-profile-picture.jpg') }}" alt="foto" class="card-img-top"
                                    style="height: 300px; object-fit: cover;">
                            @endif
                            <div class="card-body">
                                <h5 class="card-title" style="height: 2cm">{{ $item->nama }}</h5>
                                <a href="{{ route('user.chat.detail', $item->id) }}" class="btn btn-primary">Kirim
                                    Pesan</a>
                            </div>
                        </div>
                    </div><!-- End Card with an image on top -->
                @endforeach

            </div>
        </section>
    </main><!-- End #main -->

    <!-- Tambahkan JavaScript untuk menghapus parameter pencarian saat halaman di-refresh -->
    <script>
        window.addEventListener('load', function() {
            // Menghapus parameter pencarian dari URL saat halaman di-refresh
            var url = new URL(window.location.href);
            url.searchParams.delete('search');
            window.history.replaceState({}, document.title, url.toString());
        });
    </script>

@endsection
