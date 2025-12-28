<footer id="footer" class="footer position-relative light-background">
    @php
        $alamat = optional($informasi)->alamat;
        $nohp = optional($informasi)->nohp;
        $email = optional($informasi)->email;
        $instansi = optional($informasi)->instansi;
        $deskripsi = optional($informasi)->deskripsi;
        $twitter = optional($informasi)->twitter;
        $facebook = optional($informasi)->facebook;
        $instagram = optional($informasi)->instagram;
        $youtube = optional($informasi)->youtube;
        $tiktok = optional($informasi)->tiktok;
    @endphp
    @if ($instansi)
        <div class="container footer-top">
            <div class="row gy-4">
                <div class="col-lg-6 col-md-6 footer-about">
                    <a href="#" class="logo d-flex align-items-center">
                        <span class="sitename">    <img src="{{ asset('assets-guest/img/logosikarir.png') }}" alt="">
                        </span>
                    </a>
                    <div class="footer-contact pt-3">
                        @if ($instansi)
                            <p><strong>{{ $instansi }}</strong></p>
                        @endif
                        @if ($deskripsi)
                            <p>{{ $deskripsi }}</p>
                        @endif
                        @if ($alamat)
                            <p class="mt-3"><strong>Alamat:</strong> <span>{{ $alamat }}</span></p>
                        @endif
                        @if ($nohp)
                            <p class="mt-3"><strong>Phone:</strong> <span>{{ $nohp }}</span></p>
                        @endif
                        @if ($email)
                            <p><strong>Email:</strong> <span>{{ $email }}</span></p>
                        @endif
                    </div>
                </div>
                <div class="col-lg-6 col-md-3 footer-links">
                    <h4>Sosial Media</h4>
                    <div class="social-links d-flex mt-4">
                        @if ($instansi)
                            <a href="https://www.google.com/search?q={{ str_replace(' ', '+', strtolower($instansi)) }}&oq=smkn&gs_lcrp=EgZjaHJvbWUqBggAEEUYOzIGCAAQRRg7MgYIARBFGDkyBggCEEUYQDIGCAMQRRg8MgYIBBBFGDwyBggFEEUYPNIBCDEyNjFqMGo3qAIAsAIA&sourceid=chrome&ie=UTF-8"
                                target="_blank"><i class="bi bi-google"></i></a>
                        @endif
                        @if ($twitter)
                            <a href="https://www.x.com/{{ $twitter }}" target="_blank"><i class="bi bi-twitter-x"></i></a>
                        @endif
                        @if ($facebook)
                            <a href="https://www.facebook.com/{{ $facebook }}" target="_blank"><i class="bi bi-facebook"></i></a>
                        @endif
                        @if ($instagram)
                            <a href="https://www.instagram.com/{{ $instagram }}" target="_blank"><i class="bi bi-instagram"></i></a>
                        @endif
                        @if ($youtube)
                            <a href="https://www.youtube.com/{{ $youtube }}" target="_blank"><i class="bi bi-youtube"></i></a>
                        @endif
                        @if ($tiktok)
                            <a href="https://www.tiktok.com/&#64;{{ $tiktok }}" target="_blank"><i class="bi bi-tiktok"></i></a>
                        @endif
                    </div>
                </div>

            </div>
        </div>
    @endif

    <div class="container copyright text-center mt-4">
        &copy; 2024 <strong><span>SiKarir</span></strong>. Ver. 2024.1.1
    </div>

</footer>
