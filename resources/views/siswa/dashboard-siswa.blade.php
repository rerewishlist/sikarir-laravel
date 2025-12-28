<section class="section">
    <div class="row mb-3">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Selamat Datang</h5>
                    <h3 class="card-body">{{ $currentUser->nama }}</h3>
                </div>
            </div>
        </div>

        <section class="section">
            <div class="row">
                <div class="col-lg-12">

                    <div class="card mb-4">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <h5 class="card-title">Berita Terbaru</h5>
                                <!-- Form Pencarian -->
                                <form method="GET" action="{{ url('/siswa/dashboard') }}" class="d-flex search-form">
                                    <input style="margin-right: 10px;" type="text" name="search_berita" class="form-control"
                                        placeholder="Cari judul berita..." value="{{ request('search_berita') }}">

                                    <!-- Dropdown untuk memilih kategori -->
                                    <select name="filter_kategori" class="form-control" style="margin-right: 10px;">
                                        <option value="">-- Pilih Kategori --</option>
                                        @foreach ($kategoris as $kategori)
                                            <option value="{{ $kategori->id }}" {{ request('filter_kategori') == $kategori->id ? 'selected' : '' }}>
                                                {{ $kategori->nama }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <button type="submit" class="btn btn-primary">Cari</button>
                                </form>
                                <!-- End Form Pencarian -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        @if ($allBerita->count() > 0)
            @foreach ($allBerita as $item)
                <div class="col-lg-12">
                    <div class="card">
                        @php
                            $randomImages = [
                                'assets/img/berita1.jpeg',
                                'assets/img/berita2.jpeg',
                                'assets/img/berita3.jpeg',
                                'assets/img/berita4.jpeg',
                                'assets/img/berita5.jpeg',
                            ];
                            $randomImage = $randomImages[array_rand($randomImages)];
                        @endphp
                        @if ($item->gambar)
                            <img src="{{ asset('storage/berita/' . $item->gambar) }}" alt="foto" class="card-img-top"
                                style="height: 300px; object-fit: cover;">
                        @else
                            <img src="{{ asset($randomImage) }}" alt="foto" class="card-img-top" style="height: 300px; object-fit: cover;">
                        @endif
                        <div class="card-body">
                            <h5 class="card-title">{{ $item->judul }}</h5>
                            <p class="card-text">{!! \Illuminate\Support\Str::limit(strip_tags($item->content), 400, '...') !!}</p>
                            <a href="{{ route('user.berita.detail', $item->id) }}" class="btn btn-primary">Selengkapnya...</a>
                        </div>
                    </div>
                </div>
            @endforeach
        @else
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <p class="card-text mt-4">Tidak ada berita terbaru</p>
                    </div>
                </div>
            </div>
        @endif

    </div>

    <!-- Paginate -->
    <nav aria-label="Page navigation example">
        <ul class="pagination">
            <!-- Previous Page Link -->
            @if ($allBerita->onFirstPage())
                <li class="page-item disabled"><span class="page-link">Previous</span></li>
            @else
                <li class="page-item"><a class="page-link" href="{{ $allBerita->previousPageUrl() }}">Previous</a>
                </li>
            @endif

            <!-- Pagination Elements -->
            @for ($i = 1; $i <= $allBerita->lastPage(); $i++)
                <li class="page-item {{ $i == $allBerita->currentPage() ? 'active' : '' }}">
                    <a class="page-link" href="{{ $allBerita->url($i) }}">{{ $i }}</a>
                </li>
            @endfor

            <!-- Next Page Link -->
            @if ($allBerita->hasMorePages())
                <li class="page-item"><a class="page-link" href="{{ $allBerita->nextPageUrl() }}">Next</a></li>
            @else
                <li class="page-item disabled"><span class="page-link">Next</span></li>
            @endif
        </ul>
    </nav>
    <!-- End Paginate -->
</section>

<script>
    window.addEventListener('load', function() {
        // Menghapus parameter pencarian dari URL saat halaman di-refresh
        var url = new URL(window.location.href);
        url.searchParams.delete('search_berita');
        url.searchParams.delete('filter_kategori');
        window.history.replaceState({}, document.title, url.toString());
    });
</script>
