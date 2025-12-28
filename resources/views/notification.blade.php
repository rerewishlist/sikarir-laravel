@extends('layouts.main')
@section('title', 'Notifikasi')
@section('content')
    <main id="main" class="main">

        <div class="pagetitle">
            @if (session()->has('success'))
                <div class="alert alert-primary alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            <h1>Semua Notifikasi</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="/admin/dashboard">Dashboard</a></li>
                    <li class="breadcrumb-item active">Semua Notifikasi</li>
                </ol>
            </nav>
        </div><!-- End Page Title -->

        <section class="section">
            <div class="row">
                <div class="col-lg-12">

                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Notifikasi</h5>
                            <!-- List group with custom content -->
                            <ol class="list-group list-group-numbered">
                                @if ($beritaforummateriNotifications->count() > 0)
                                    @foreach ($databeritaforummateriNotifications as $item)
                                        <li class="list-group-item d-flex justify-content-between align-items-start"
                                            data-id="{{ $item->data['berita_id'] ?? ($item->data['forum_id'] ?? $item->data['materi_id']) }}"
                                            data-type="{{ $item->data['type'] }}" style="cursor: pointer;">
                                            <div class="ms-2 me-auto">
                                                @if ($item->data['type'] == 'berita')
                                                    <div class="fw-bold"><span style="color: #012970;">{{ $item->data['type'] }}</span>:
                                                        "{{ $item->data['judul'] }}"</div>
                                                @elseif($item->data['type'] == 'forum')
                                                    <div class="fw-bold"><span style="color: #012970;">{{ $item->data['type'] }}</span>:
                                                        "{{ $item->data['judul'] }}"</div>
                                                @elseif($item->data['type'] == 'materi')
                                                    <div class="fw-bold"><span style="color: #012970;">{{ $item->data['type'] }}</span>:
                                                        "{{ $item->data['judul'] }}"</div>
                                                @endif
                                                {!! \Illuminate\Support\Str::limit(strip_tags($item->data['content']), 70, '...') !!}
                                            </div>
                                            <span class="badge bg-primary rounded-pill me-1">{{ $item->created_at->diffForHumans() }}</span>
                                            <span>{{ \Carbon\Carbon::parse($item->data['created_at'])->format('d/m/Y') }}</span>
                                        </li>
                                    @endforeach
                                @else
                                    <li class="d-flex justify-content-between align-items-start">
                                        <div class="fw-bold">Tidak ada notifikasi baru</div>
                                    </li>
                                @endif
                            </ol><!-- End with custom content -->

                        </div>
                    </div>
                </div>
            </div>
        </section>

    </main><!-- End #main -->

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Dapatkan semua elemen <li> dengan class 'list-group-item'
            const listItems = document.querySelectorAll('.list-group-item');

            // Tambahkan event listener pada setiap elemen <li>
            listItems.forEach(item => {
                item.addEventListener('click', function() {
                    const id = this.getAttribute('data-id');
                    const type = this.getAttribute('data-type');

                    // Tentukan URL tujuan berdasarkan type
                    let url;
                    @if (auth()->user()->level == 'superadmin')
                        if (type === 'berita') {
                            url = `databerita/detail/${id}`; // Contoh URL: sesuaikan dengan route aplikasi Anda
                        } else if (type === 'forum') {
                            url = `dataforum/detail/${id}`; // Contoh URL: sesuaikan dengan route aplikasi Anda
                        } else if (type === 'materi') {
                            url = `datamateri/detail/${id}`; // Contoh URL: sesuaikan dengan route aplikasi Anda
                        }
                    @elseif (auth()->user()->level == 'admin')
                        if (type === 'berita') {
                            url = `databerita/detail/${id}`; // Contoh URL: sesuaikan dengan route aplikasi Anda
                        } else if (type === 'forum') {
                            url = `dataforum/detail/${id}`; // Contoh URL: sesuaikan dengan route aplikasi Anda
                        } else if (type === 'materi') {
                            url = `datamateri/detail/${id}`; // Contoh URL: sesuaikan dengan route aplikasi Anda
                        }
                    @elseif (auth()->user()->level == 'siswa')
                        if (type === 'berita') {
                            url = `berita/detail/${id}`; // Contoh URL: sesuaikan dengan route aplikasi Anda
                        } else if (type === 'forum') {
                            url = `forumdiskusi/detail/${id}`; // Contoh URL: sesuaikan dengan route aplikasi Anda
                        } else if (type === 'materi') {
                            url = `materi/detail/${id}`; // Contoh URL: sesuaikan dengan route aplikasi Anda
                        }
                    @endif

                    // Arahkan ke URL yang telah ditentukan
                    if (url) {
                        window.location.href = url;
                    }
                });
            });
        });
    </script>

    <script>
        document.getElementById('notificationTable').addEventListener('click', function(event) {
            var target = event.target;
            while (target && target.nodeName !== 'TR') {
                target = target.parentNode;
            }
            if (target) {
                var id = target.getAttribute('data-id');
                var type = target.getAttribute('data-type');
                var url = '';

                console.log('Clicked row:', target);
                console.log('ID:', id);
                console.log('Type:', type);

                @if (auth()->user()->level == 'superadmin')
                    if (type === 'berita') {
                        url = 'databerita/detail/' + id; // Sesuaikan dengan route berita Anda
                    } else if (type === 'forum') {
                        url = 'dataforum/detail/' + id; // Sesuaikan dengan route forum Anda
                    } else if (type === 'materi') {
                        url = 'datamateri/detail/' + id; // Sesuaikan dengan route forum Anda
                    }
                @elseif (auth()->user()->level == 'admin')
                    if (type === 'berita') {
                        url = 'databerita/detail/' + id; // Sesuaikan dengan route berita Anda
                    } else if (type === 'forum') {
                        url = 'dataforum/detail/' + id; // Sesuaikan dengan route forum Anda
                    } else if (type === 'materi') {
                        url = 'datamateri/detail/' + id; // Sesuaikan dengan route forum Anda
                    }
                @elseif (auth()->user()->level == 'siswa')
                    if (type === 'berita') {
                        url = 'berita/detail/' + id; // Sesuaikan dengan route berita Anda
                    } else if (type === 'forum') {
                        url = 'forumdiskusi/detail/' + id; // Sesuaikan dengan route forum Anda
                    } else if (type === 'materi') {
                        url = 'materi/detail/' + id; // Sesuaikan dengan route forum Anda
                    }
                @endif

                if (url) {
                    window.location.href = url;
                }
            }
        });
    </script>



    <!-- Tambahkan JavaScript untuk menghapus parameter pencarian saat halaman di-refresh -->
    <script>
        window.addEventListener('load', function() {
            // Menghapus parameter pencarian dari URL saat halaman di-refresh
            var url = new URL(window.location.href);
            url.searchParams.delete('search');
            url.searchParams.delete('kelas');
            url.searchParams.delete('jurusan');
            window.history.replaceState({}, document.title, url.toString());
        });
    </script>

@endsection
