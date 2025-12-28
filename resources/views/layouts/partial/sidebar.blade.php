<!-- ======= Sidebar ======= -->
<aside id="sidebar" class="sidebar">

    <ul class="sidebar-nav" id="sidebar-nav">

        @if (auth()->user()->level == 'admin')
            <li class="nav-item">
                <a class="nav-link {{ setActive('admin/dashboard*') }}" href="/admin/dashboard">
                    <i class="ri ri-home-4-line"></i>
                    <span>Dashboard</span>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link {{ setActive('admin/informasi*') }}" href="/admin/informasi">
                    <i class="bi bi-info-circle"></i>
                    <span>Data Informasi</span>
                </a>
            </li>

            {{-- <li class="nav-item">
                <a class="nav-link {{ setActive('admin/datamateri*') }}" href="/admin/datamateri">
                    <i class="bi bi-blockquote-left"></i>
                    <span>Data Materi</span>
                </a>
            </li> --}}

            <li class="nav-item">
                <a class="nav-link
                @if (Request::is('admin/datasiswa*')) {{ setActive('admin/datasiswa*') }}
                @elseif (Request::is('admin/datajurusan')) {{ setActive('admin/datajurusan*') }}
                @else collapsed @endif
                @if (Request::is('admin/datasiswa*') || Request::is('admin/datajurusan')) active @endif"
                    data-bs-target="#siswa-nav" data-bs-toggle="collapse" href="#">
                    <i class="bi bi-people"></i><span>Data Siswa</span><i class="bi bi-chevron-down ms-auto"></i>
                </a>
                <ul id="siswa-nav" class="nav-content collapse
                @if (Request::is('admin/datasiswa*') || Request::is('admin/datajurusan')) show @endif"
                    data-bs-parent="#sidebar-nav">
                    <li>
                        <a href="/admin/datasiswa" class="@if (Request::is('admin/datasiswa*')) active @endif">
                            <i class="bi bi-circle"></i><span>Data Siswa</span>
                        </a>
                    </li>
                    <li>
                        <a href="/admin/datajurusan" class="@if (Request::is('admin/datajurusan')) active @endif">
                            <i class="bi bi-circle"></i><span>Data Jurusan</span>
                        </a>
                    </li>
                </ul>
            </li>

            <li class="nav-item">
                <a class="nav-link
                @if (Request::is('admin/databerita*')) {{ setActive('admin/databerita*') }}
                @elseif (Request::is('admin/datakategori')) {{ setActive('admin/datakategori*') }}
                @else collapsed @endif
                @if (Request::is('admin/databerita*') || Request::is('admin/datakategori')) active @endif"
                    data-bs-target="#berita-nav" data-bs-toggle="collapse" href="#">
                    <i class="bi bi-newspaper"></i><span>Data Berita</span><i class="bi bi-chevron-down ms-auto"></i>
                </a>
                <ul id="berita-nav" class="nav-content collapse
                @if (Request::is('admin/databerita*') || Request::is('admin/datakategori')) show @endif"
                    data-bs-parent="#sidebar-nav">
                    <li>
                        <a href="/admin/databerita" class="@if (Request::is('admin/databerita*')) active @endif">
                            <i class="bi bi-circle"></i><span>Data Berita</span>
                        </a>
                    </li>
                    <li>
                        <a href="/admin/datakategori" class="@if (Request::is('admin/datakategori')) active @endif">
                            <i class="bi bi-circle"></i><span>Data Kategori</span>
                        </a>
                    </li>
                </ul>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ setActive('admin/dataforum*') }}" href="/admin/dataforum">
                    <i class="ri ri-discuss-line"></i>
                    <span>Data Forum</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ setActive('admin/chat*') }}" href="/admin/chat">
                    <i class="bi bi-chat-dots"></i>
                    <span>Data Chat</span>
                </a>
            </li>
        @endif

        @if (auth()->user()->level == 'superadmin')
            <li class="nav-item">
                <a class="nav-link {{ setActive('admin/dashboard*') }}" href="/admin/dashboard">
                    <i class="ri ri-home-4-line"></i>
                    <span>Dashboard</span>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link {{ setActive('admin/informasi*') }}" href="/admin/informasi">
                    <i class="bi bi-info-circle"></i>
                    <span>Data Informasi</span>
                </a>
            </li>

            {{-- <li class="nav-item">
                <a class="nav-link {{ setActive('admin/datamateri*') }}" href="/admin/datamateri">
                    <i class="bi bi-blockquote-left"></i>
                    <span>Data Materi</span>
                </a>
            </li> --}}

            <li class="nav-item">
                <a class="nav-link
                @if (Request::is('admin/datasiswa*')) {{ setActive('admin/datasiswa*') }}
                @elseif (Request::is('admin/datajurusan')) {{ setActive('admin/datajurusan*') }}
                @else collapsed @endif
                @if (Request::is('admin/datasiswa*') || Request::is('admin/datajurusan')) active @endif"
                    data-bs-target="#siswa-nav" data-bs-toggle="collapse" href="#">
                    <i class="bi bi-people"></i><span>Data Siswa</span><i class="bi bi-chevron-down ms-auto"></i>
                </a>
                <ul id="siswa-nav" class="nav-content collapse
                @if (Request::is('admin/datasiswa*') || Request::is('admin/datajurusan')) show @endif"
                    data-bs-parent="#sidebar-nav">
                    <li>
                        <a href="/admin/datasiswa" class="@if (Request::is('admin/datasiswa*')) active @endif">
                            <i class="bi bi-circle"></i><span>Data Siswa</span>
                        </a>
                    </li>
                    <li>
                        <a href="/admin/datajurusan" class="@if (Request::is('admin/datajurusan')) active @endif">
                            <i class="bi bi-circle"></i><span>Data Jurusan</span>
                        </a>
                    </li>
                </ul>
            </li>

            <li class="nav-item">
                <a class="nav-link
                @if (Request::is('admin/databerita*')) {{ setActive('admin/databerita*') }}
                @elseif (Request::is('admin/datakategori')) {{ setActive('admin/datakategori*') }}
                @else collapsed @endif
                @if (Request::is('admin/databerita*') || Request::is('admin/datakategori')) active @endif"
                    data-bs-target="#berita-nav" data-bs-toggle="collapse" href="#">
                    <i class="bi bi-newspaper"></i><span>Data Berita</span><i class="bi bi-chevron-down ms-auto"></i>
                </a>
                <ul id="berita-nav" class="nav-content collapse
                @if (Request::is('admin/databerita*') || Request::is('admin/datakategori')) show @endif"
                    data-bs-parent="#sidebar-nav">
                    <li>
                        <a href="/admin/databerita" class="@if (Request::is('admin/databerita*')) active @endif">
                            <i class="bi bi-circle"></i><span>Data Berita</span>
                        </a>
                    </li>
                    <li>
                        <a href="/admin/datakategori" class="@if (Request::is('admin/datakategori')) active @endif">
                            <i class="bi bi-circle"></i><span>Data Kategori</span>
                        </a>
                    </li>
                </ul>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ setActive('admin/dataforum*') }}" href="/admin/dataforum">
                    <i class="ri ri-discuss-line"></i>
                    <span>Data Forum</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ setActive('admin/chat*') }}" href="/admin/chat">
                    <i class="bi bi-chat-dots"></i>
                    <span>Data Chat</span>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link {{ setActive('admin/dataadmin*') }}" href="/admin/dataadmin">
                    <i class="bi bi-people"></i>
                    <span>Data Admin</span>
                </a>
            </li>
        @endif

        @if (auth()->user()->level == 'siswa')
            </li>
            <li class="nav-item">

                <a class="nav-link @if (Request::is('siswa/dashboard*')) {{ setActive('siswa/dashboard*') }} @elseif (Request::is('siswa/berita*')) {{ setActive('siswa/berita*') }} @else collapsed @endif"
                    href="/siswa/dashboard">
                    <i class="ri ri-home-4-line"></i>
                    <span>Dashboard</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ setActive('siswa/materi*') }}" href="/siswa/materi">
                    <i class="bi bi-blockquote-left"></i>
                    <span>Data Materi</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ setActive('siswa/forumdiskusi*') }}" href="/siswa/forumdiskusi">
                    <i class="ri ri-discuss-line"></i>
                    <span>Forum Diskusi</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ setActive('siswa/chat*') }}" href="/siswa/chat">
                    <i class="bi bi-chat-dots"></i>
                    <span>Data Chat</span>
                </a>
            </li>
        @endif

    </ul>

</aside><!-- End Sidebar-->
