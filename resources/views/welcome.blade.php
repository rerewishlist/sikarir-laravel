@extends('layouts.main-guest')
@section('title', 'Home Page')
@section('menuLanding', 'active')
@section('content-guest')

    <main class="main">
        <!-- Hero Section -->
        <section id="hero" class="hero section">
            <div class="hero-bg">
                @php
                    $videoyt = optional($informasi)->videoyt;
                    // Ekstrak ID video dari URL YouTube
                    preg_match('/v=([a-zA-Z0-9_-]{11})/', $videoyt, $matches);
                    $videoId = $matches[1] ?? null;
                @endphp
                @if ($videoyt)
                    <iframe width="100%" height="100%"
                        src="https://www.youtube.com/embed/{{ $videoId }}?autoplay=1&mute=1&controls=0&modestbranding=1&rel=0&si=wEFeD_OyUlxlaYHW"
                        title="YouTube video player" frameborder="0"
                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                        referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
                @endif
            </div>


            <div class="container text-center">
                <div class="d-flex flex-column justify-content-center align-items-center">
                    @php
                        $instansi = optional($informasi)->instansi;
                    @endphp
                    @if ($instansi)
                        <h1 data-aos="fade-up"><span><i>SiKarir</i></span></h1>
                        <h1 data-aos="fade-up"><span>Jembatan Siswa Menuju Masa Depan</span></h1>
                        <p data-aos="fade-up" data-aos-delay="100">Platform informasi dan diskusi untuk membantu siswa SMK menemukan jalan terbaik menuju dunia kerja dan perkuliahan<br></p>
                    @else
                        <h1 data-aos="fade-up"><span><i>SiKarir</i></span></h1>
                        <h1 data-aos="fade-up"><span>Jembatan Siswa Menuju Masa Depan</span></h1>
                        <p data-aos="fade-up" data-aos-delay="100">Platform informasi dan diskusi untuk membantu siswa SMK menemukan jalan terbaik menuju dunia kerja dan perkuliahan<br></p>
                    @endif
                </div>
            </div>
        </section><!-- /Hero Section -->

        <!-- Featured Services Section -->
        <section id="featured-services" class="featured-services section light-background">

            <div class="container">

                <div class="row gy-4" style="display: flex; justify-content: center; flex-wrap: wrap;">

                    <div class="col-xl-2 col-lg-6" data-aos="fade-up" data-aos-delay="100">
                        <div class="service-item d-flex">
                            <div class="icon flex-shrink-0"><i class="bi bi-briefcase"></i></div>
                            <div>
                                <h4 class="title"><a href="#" class="stretched-link"><span class="count-jurusan"
                                            style="font-size: 40px;">0</span></a></h4>
                                <p class="description">Jurusan</p>
                            </div>
                        </div>
                    </div>

                    <div class="col-xl-2 col-lg-6" data-aos="fade-up" data-aos-delay="200">
                        <div class="service-item d-flex">
                            <div class="icon flex-shrink-0"><i class="bi bi-people"></i></div>
                            <div>
                                <h4 class="title"><a href="#" class="stretched-link"><span class="count-siswa"
                                            style="font-size: 40px;">0</span></a></h4>
                                <p class="description">Siswa</p>
                            </div>
                        </div>
                    </div>

                    <div class="col-xl-2 col-lg-6" data-aos="fade-up" data-aos-delay="300">
                        <div class="service-item d-flex">
                            <div class="icon flex-shrink-0"><i class="bi bi-newspaper"></i></div>
                            <div>
                                <h4 class="title"><a href="#" class="stretched-link"><span class="count-berita"
                                            style="font-size: 40px;">0</span></a></h4>
                                <p class="description">Berita</p>
                            </div>
                        </div>
                    </div>

                    <div class="col-xl-2 col-lg-6" data-aos="fade-up" data-aos-delay="400">
                        <div class="service-item d-flex">
                            <div class="icon flex-shrink-0"><i class="ri ri-discuss-line"></i></div>
                            <div>
                                <h4 class="title"><a href="#" class="stretched-link"><span class="count-forum"
                                            style="font-size: 40px;">0</span></a></h4>
                                <p class="description">Forum</p>
                            </div>
                        </div>
                    </div>

                </div>

            </div>

        </section><!-- /Featured Services Section -->

            <!-- Services Section -->
    <section id="services" class="services section">

<!-- Section Title -->
<div class="container section-title" data-aos="fade-up">
  <h2>SIKARIR</h2>
  <p>Sikarir merupakan platform yang membantu siswa SMK menemukan peluang kerja dan perkuliahan setelah lulus. Menyediakan informasi perkuliahan dan lowongan pekerjaan, forum diskusi, dan fitur chatting untuk bimbingan karir. 🚀</p>
</div><!-- End Section Title -->

<div class="container">

  <div class="row g-5">

    <div class="col-lg-12" data-aos="fade-up" data-aos-delay="100">
      <div class="service-item item-cyan position-relative">
      <i class="bi bi-calendar4-week icon"></i>
        <div>
          <h3>Informasi Berita Lowongan Pekerjaan dan Perkuliahan</h3>
          <p>Membantu siswa SMK menemukan peluang karir yang tepat dengan menghadirkan informasi terbaru seputar lowongan kerja dan jalur pendidikan lanjutan. Jangan lewatkan kesempatan emas untuk meraih masa depan yang lebih cerah! 🌟</p>
          <a href="{{ Route('berita.menu') }}" class="read-more stretched-link">Learn More <i class="bi bi-arrow-right"></i></a>
        </div>
      </div>
    </div><!-- End Service Item -->

    <div class="col-lg-12" data-aos="fade-up" data-aos-delay="200">
      <div class="service-item item-orange position-relative">
        <i class="bi bi-broadcast icon"></i>
        <div>
          <h3>Forum Diskusi</h3>
          <p>Tempat bagi siswa untuk berdiskusi dengan guru dan teman-teman mengenai dunia kerja, peluang perkuliahan, serta berbagi pengalaman dan wawasan. Dapatkan inspirasi dan solusi terbaik untuk merancang perjalanan karirmu! 🚀</p>
          @if (auth()->check())
          <a href="{{ Route('user.dataforum.view') }}" class="read-more stretched-link @yield('menuForum')">Learn More <i class="bi bi-arrow-right"></i></a>
          @else
          <a href="{{ Route('forum.menu') }}" class="read-more stretched-link @yield('menuForum')">Learn More <i class="bi bi-arrow-right"></i></a>
          @endif
        </div>
      </div>
    </div><!-- End Service Item -->

    <div class="col-lg-12" data-aos="fade-up" data-aos-delay="300">
      <div class="service-item item-teal position-relative">
      <i class="bi bi-chat-square-text icon"></i>
        <div>
          <h3>Chat dengan Guru!</h3>
          <p>Bimbingan karir kini lebih mudah! Fitur chat ini membantu siswa mendapatkan arahan langsung dari guru mengenai pilihan pekerjaan, perkuliahan, dan langkah terbaik setelah lulus. Jangan ragu untuk bertanya dan wujudkan impianmu! ✨</p>
          <a href="{{ Route('user.chat.view') }}"" class="read-more stretched-link">Learn More <i class="bi bi-arrow-right"></i></a>
        </div>
      </div>
    </div><!-- End Service Item -->

  </div>

</div>

</section><!-- /Services Section -->
        
        <!-- Features Section -->
        <section id="features" class="features section light-background">

            <!-- Section Title -->
            <div class="container section-title" data-aos="fade-up">
                <h2>Berita Terbaru</h2>
                <p></p>
            </div><!-- End Section Title -->

            @if ($beritas->count() > 0)
                <div class="container">
                    <div class="row justify-content-between">

                        <div class="col-lg-5 d-flex align-items-center">
                            <ul class="nav nav-tabs" data-aos="fade-up" data-aos-delay="100">
                                @foreach ($beritas as $item)
                                    <li class="nav-item">
                                        <a class="nav-link" data-bs-toggle="tab" data-bs-target="#features-tab-{{ $item->id }}"
                                            href="#features-tab-{{ $item->id }}" onclick="activateTab(event, '{{ $item->id }}')">
                                            <i class="bi bi-binoculars"></i>
                                            <div>
                                                <h4 class="d-none d-lg-block">{{ $item->judul }}</h4>
                                                <p>
                                                    {!! \Illuminate\Support\Str::limit(strip_tags($item->content), 200, '...') !!}
                                                </p>
                                            </div>
                                        </a>
                                    </li>
                                @endforeach
                            </ul><!-- End Tab Nav -->
                        </div>

                        <div class="col-lg-6">
                            <div class="tab-content" data-aos="fade-up" data-aos-delay="200">
                                @foreach ($beritas as $item)
                                    <div class="tab-pane fade" id="features-tab-{{ $item->id }}">
                                        <a href="{{ Route('berita.detail.menu', $item->slug) }}">

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
                                                <img src="{{ asset('storage/berita/' . $item->gambar) }}" alt="" class="img-fluid"
                                                    style="width: 700px; height: 700px; object-fit: cover;">
                                            @else
                                                <img src="{{ asset($randomImage) }}" alt="" class="img-fluid"
                                                    style="width: 700px; height: 700px; object-fit: cover;">
                                            @endif
                                        </a>
                                    </div><!-- End Tab Content Item -->
                                @endforeach
                            </div>
                        </div>

                    </div>
                </div>
            @else
                <div class="container" style="text-align: center" data-aos="fade-up">
                    <h4>Belum ada berita</h4>
                </div><!-- End Section Title -->
            @endif

        </section><!-- /Features Section -->

        {{-- @if (auth()->check())
            <!-- Testimonials Section -->
            <section id="testimonials" class="testimonials section light-background">

                <!-- Section Title -->
                <div class="container section-title" data-aos="fade-up">
                    <h2>Materi Bimbingan Dan Konseling Karir</h2>
                </div><!-- End Section Title -->

                @if ($materis->count() > 0)
                    <div class="container" data-aos="fade-up" data-aos-delay="100">

                        <div class="swiper init-swiper">
                            <script type="application/json" class="swiper-config">
                        {
                            "loop": true,
                            "speed": 600,
                            "autoplay": {
                                "delay": 5000
                            },
                            "slidesPerView": "auto",
                            "pagination": {
                                "el": ".swiper-pagination",
                                "type": "bullets",
                                "clickable": true
                            },
                            "breakpoints": {
                                "320": {
                                    "slidesPerView": 1,
                                    "spaceBetween": 40
                                },
                                "1200": {
                                    "slidesPerView": 3,
                                    "spaceBetween": 1
                                }
                            }
                        }
                        </script>

                            <div class="swiper-wrapper">

                                @foreach ($materis as $item)
                                    <div class="swiper-slide">
                                        <div class="testimonial-item">
                                            <div class="stars">
                                                <h3>{{ $item->judul }}</h3>

                                            </div>
                                            <p>
                                                {!! \Illuminate\Support\Str::limit(strip_tags($item->deskripsi), 100, '...') !!}
                                            </p>
                                            <p></p>
                                            <p>
                                                <a href="">Baca Materi</a>
                                            </p>
                                            <p></p>
                                            <div class="profile mt-auto">
                                                @if ($item->admin->foto)
                                                    <img src="{{ asset('storage/foto/' . $item->admin->foto) }}" class="testimonial-img"
                                                        alt="">
                                                @else
                                                    <img src="{{ asset('assets/img/blank-profile-picture.jpg') }}" class="testimonial-img"
                                                        alt="">
                                                @endif
                                                <h3>{{ $item->admin->nama }}</h3>
                                                <h4>{{ $item->created_at->diffForHumans() }}</h4>
                                            </div>
                                        </div>
                                    </div><!-- End testimonial item -->
                                @endforeach
                            </div>
                            <div class="swiper-pagination"></div>
                        </div>

                    </div>
                @else
                    <div class="container" style="text-align: center" data-aos="fade-up">
                        <h4>Belum ada materi</h4>
                    </div><!-- End Section Title -->
                @endif


            </section><!-- /Testimonials Section -->
        @endif --}}


    </main>

    <script>
        $(document).ready(function() {
            // Fungsi untuk animasi penghitung
            function animateCounter(selector, endValue, duration) {
                var $element = $(selector);
                $element.text(0); // Inisialisasi teks awal

                $({
                    count: 0
                }).animate({
                    count: endValue
                }, {
                    duration: duration,
                    easing: 'swing',
                    step: function() {
                        $element.text(Math.ceil(this.count));
                    }
                });
            }

            // Panggil fungsi animasi penghitung untuk totalBerita dan totalSiswa
            var totalJurusan = {{ $totalJurusan }};
            var totalSiswa = {{ $totalSiswa }};
            var totalBerita = {{ $totalBerita }};
            var totalForum = {{ $totalForum }};
            // var totalMateri = {{ $totalMateri }};

            if (!isNaN(totalJurusan) && totalJurusan > 0) {
                animateCounter('.count-jurusan', totalJurusan, 3000); // 2000 ms atau 2 detik
            }

            if (!isNaN(totalSiswa) && totalSiswa > 0) {
                animateCounter('.count-siswa', totalSiswa, 3000); // 2000 ms atau 2 detik
            }

            if (!isNaN(totalBerita) && totalBerita > 0) {
                animateCounter('.count-berita', totalBerita, 3000); // 2000 ms atau 2 detik
            }

            if (!isNaN(totalForum) && totalForum > 0) {
                animateCounter('.count-forum', totalForum, 3000); // 2000 ms atau 2 detik
            }

            // if (!isNaN(totalMateri) && totalMateri > 0) {
            //     animateCounter('.count-materi', totalMateri, 3000); // 2000 ms atau 2 detik
            // }
        });
    </script>

    <script>
        function activateTab(event, id) {
            // Prevent the default anchor click behavior
            event.preventDefault();

            // Remove 'active show' classes from all nav links and tab panes
            document.querySelectorAll('.nav-link').forEach(link => link.classList.remove('active', 'show'));
            document.querySelectorAll('.tab-pane').forEach(pane => pane.classList.remove('active', 'show'));

            // Add 'active show' classes to the clicked tab and its corresponding tab pane
            event.currentTarget.classList.add('active', 'show');
            document.querySelector(`#features-tab-${id}`).classList.add('active', 'show');
        }

        // Automatically activate the first tab on page load
        document.addEventListener('DOMContentLoaded', () => {
            const firstTabLink = document.querySelector('.nav-link');
            if (firstTabLink) {
                firstTabLink.classList.add('active', 'show');
                const firstTabPaneId = firstTabLink.getAttribute('data-bs-target');
                document.querySelector(firstTabPaneId).classList.add('active', 'show');
            }
        });
    </script>
@endsection
