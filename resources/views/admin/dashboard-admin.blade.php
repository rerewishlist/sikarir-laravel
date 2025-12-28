<section class="section dashboard">
    <div class="row">

        <!-- Left side columns -->
        <div class="col-lg-8">
            <div class="row">

                <!-- Sales Card -->
                <div class="col-xxl-4 col-md-6">
                    <div class="card info-card sales-card">

                        <div class="card-body">
                            <h5 class="card-title">Admin <span>| Total</span></h5>
                            <div class="d-flex align-items-center">
                                <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                    <i class="bi bi-people"></i>
                                </div>
                                <div class="ps-3">
                                    <h6>{{ $totalAdmin }} Admin</h6>
                                </div>
                            </div>
                        </div>

                    </div>
                </div><!-- End Sales Card -->

                <!-- Sales Card -->
                <div class="col-xxl-4 col-md-6">
                    <div class="card info-card sales-card">

                        <div class="card-body">
                            <h5 class="card-title">Siswa <span>| Total</span></h5>
                            <div class="d-flex align-items-center">
                                <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                    <i class="bi bi-people"></i>
                                </div>
                                <div class="ps-3">
                                    <h6>{{ $totalSiswa }} Siswa</h6>
                                </div>
                            </div>
                        </div>

                    </div>
                </div><!-- End Sales Card -->

                {{-- <!-- Sales Card -->
                <div class="col-xxl-4 col-md-6">
                    <div class="card info-card sales-card">

                        <div class="card-body">
                            <h5 class="card-title">Materi <span>| Total</span></h5>
                            <div class="d-flex align-items-center">
                                <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                    <i class="bi bi-cart"></i>
                                </div>
                                <div class="ps-3">
                                    <h6>{{ $totalMateri }} Materi</h6>
                                </div>
                            </div>
                        </div>

                    </div>
                </div><!-- End Sales Card --> --}}

                <!-- Sales Card -->
                <div class="col-xxl-4 col-md-6">
                    <div class="card info-card sales-card">

                        <div class="card-body">
                            <h5 class="card-title">Berita <span>| Total</span></h5>
                            <div class="d-flex align-items-center">
                                <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                    <i class="bi bi-newspaper"></i>
                                </div>
                                <div class="ps-3">
                                    <h6>{{ $totalBerita }} Berita</h6>
                                </div>
                            </div>
                        </div>

                    </div>
                </div><!-- End Sales Card -->

                <!-- Sales Card -->
                <div class="col-xxl-4 col-md-6">
                    <div class="card info-card sales-card">

                        <div class="card-body">
                            <h5 class="card-title">Forum <span>| Total</span></h5>
                            <div class="d-flex align-items-center">
                                <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                    <i class="ri ri-discuss-line"></i>
                                </div>
                                <div class="ps-3">
                                    <h6>{{ $totalForum }} Forum</h6>
                                </div>
                            </div>
                        </div>

                    </div>
                </div><!-- End Sales Card -->

                <!-- Sales Card -->
                <div class="col-xxl-4 col-md-6">
                    <div class="card info-card sales-card">

                        <div class="card-body">
                            <h5 class="card-title">Chat <span>| berlangsung</span></h5>
                            <div class="d-flex align-items-center">
                                <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                    <i class="bi bi-chat-dots"></i>
                                </div>
                                <div class="ps-3">
                                    <h6>{{ $totalChatLive }} Siswa</h6>
                                </div>
                            </div>
                        </div>

                    </div>
                </div><!-- End Sales Card -->

            </div>
        </div><!-- End Left side columns -->

        <!-- Right side columns -->
        <div class="col-lg-4">

            <!-- Recent Activity -->
            <div class="card">
                <!-- News & Updates Traffic -->
                <div class="card">
                    <div class="card-body pb-0">
                        <h5 class="card-title">Berita Terbaru <span>| Today</span></h5>

                        <div class="news">
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
                            @foreach ($recentBerita as $berita)
                                <div class="post-item clearfix">
                                    @if ($berita->gambar)
                                        <img src="{{ asset('storage/berita/' . $berita->gambar) }}" alt="Profile"
                                            style="width: 80px; height: 60px; object-fit: cover;">
                                    @else
                                        <img src="{{ asset($randomImage) }}" alt="Profile" style="width: 80px; height: 60px; object-fit: cover;">
                                    @endif
                                    <h4><a href="{{ route('databerita.detail', $berita->id) }}">{{ $berita->judul }}</a></h4>
                                    <p>{!! \Illuminate\Support\Str::limit(strip_tags($berita->content), 80, '...') !!}</p>
                                </div>
                            @endforeach
                        </div><!-- End sidebar recent posts-->

                    </div>
                </div>
            </div><!-- End News & Updates -->

        </div><!-- End Right side columns -->

    </div>
</section>

@include('admin.chart')
