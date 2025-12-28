<!-- ======= Header ======= -->
<header id="header" class="header fixed-top d-flex align-items-center">

    <div class="d-flex align-items-center justify-content-between">
        <a href="#" class="logo d-flex align-items-center">
            <img src="{{ asset('assets-guest/img/logosikarir.png') }}" alt="">
        </a>
        <i class="bi bi-list toggle-sidebar-btn"></i>
    </div><!-- End Logo -->


    <nav class="header-nav ms-auto">
        <ul class="d-flex align-items-center">

            <li class="nav-item d-block d-lg-none">
                <a class="nav-link nav-icon search-bar-toggle " href="#">
                    <i class="bi bi-search"></i>
                </a>
            </li><!-- End Search Icon-->

            <li class="nav-item dropdown">
                <a class="nav-link nav-icon" href="#" data-bs-toggle="dropdown">
                    <i class="bi bi-bell"></i>
                    @if ($beritaforummateriNotifications->count() > 0)
                        <span class="badge bg-primary badge-number">!</span>
                    @endif
                </a><!-- End Notification Icon -->
                <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow notifications">
                    <li class="dropdown-header">
                        Anda memiliki {{ $beritaforummateriNotifications->count() }} notifikasi baru
                    </li>
                    <li>
                        <hr class="dropdown-divider">
                    </li>
                    @foreach ($beritaforummateriNotifications as $item)
                        <li class="notification-item">
                            @if (auth()->user()->level == 'superadmin')
                                @if ($item->data['type'] == 'berita')
                                    <i class="bi bi-newspaper text-primary"></i>
                                    <a href="{{ route('databerita.detail', $item->data['berita_id']) }}">
                                    @elseif($item->data['type'] == 'forum')
                                        <i class="bi bi-chat-dots text-info"></i>
                                        <a href="{{ route('admin.dataforum.detail', $item->data['forum_id']) }}">
                                        @elseif($item->data['type'] == 'materi')
                                            <i class="bi bi-blockquote-left text-info"></i>
                                            <a href="{{ route('datamateri.detail', $item->data['materi_id']) }}">
                                @endif
                            @elseif (auth()->user()->level == 'admin')
                                @if ($item->data['type'] == 'berita')
                                    <i class="bi bi-newspaper text-primary"></i>
                                    <a href="{{ route('databerita.detail', $item->data['berita_id']) }}">
                                    @elseif($item->data['type'] == 'forum')
                                        <i class="bi bi-chat-dots text-info"></i>
                                        <a href="{{ route('admin.dataforum.detail', $item->data['forum_id']) }}">
                                        @elseif($item->data['type'] == 'materi')
                                            <i class="bi bi-blockquote-left text-info"></i>
                                            <a href="{{ route('datamateri.detail', $item->data['materi_id']) }}">
                                @endif
                            @elseif (auth()->user()->level == 'siswa')
                                @if ($item->data['type'] == 'berita')
                                    <i class="bi bi-newspaper text-primary"></i>
                                    <a href="{{ route('user.berita.detail', $item->data['berita_id']) }}">
                                    @elseif($item->data['type'] == 'forum')
                                        <i class="bi bi-chat-dots text-info"></i>
                                        <a href="{{ route('user.dataforum.detail', $item->data['forum_id']) }}">
                                        @elseif($item->data['type'] == 'materi')
                                            <i class="bi bi-blockquote-left text-info"></i>
                                            <a href="{{ route('user.materi.detail', $item->data['materi_id']) }}">
                                @endif
                            @endif
                            <div>
                                <h4>{!! \Illuminate\Support\Str::limit(strip_tags($item->data['judul']), 20, '...') !!}</h4>
                                <p>{!! \Illuminate\Support\Str::limit(strip_tags($item->data['content']), 20, '...') !!}</p>
                                <p>{{ $item->created_at->diffForHumans() }}</p>
                            </div>
                            </a>
                        </li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                    @endforeach
                    <li class="dropdown-footer">
                        <a href="{{ route('admin.notifications.view') }}">Tampilkan semua notifikasi</a>
                    </li>
                </ul>
            </li><!-- End Notification Nav -->

            <li class="nav-item dropdown">
                <a class="nav-link nav-icon" href="#" data-bs-toggle="dropdown">
                    <i class="bi bi-chat-left-text"></i>
                    @if ($chatNotifications->whereNull('read_at')->count() > 0)
                        <span class="badge bg-success badge-number">{{ $chatNotifications->whereNull('read_at')->count() }}</span>
                    @endif
                </a><!-- End Messages Icon -->
                <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow messages">
                    <li class="dropdown-header">
                        Anda memiliki {{ $chatNotifications->whereNull('read_at')->count() }} pesan belum terbaca
                    </li>
                    <li>
                        <hr class="dropdown-divider">
                    </li>
                    @foreach ($chatNotifications as $item)
                        @if ($item->read_at === null)
                            <!-- Menampilkan hanya notifikasi yang belum dibaca -->
                            <li class="message-item">
                                @php
                                    $fromId = $item->data['from_id'];
                                    $user = \App\Models\User::find($fromId);
                                    $admin = \App\Models\Admin::find($fromId);

                                    $fromAdminPhoto = optional($admin)->foto;
                                    $fromUserPhoto = optional($user)->foto;
                                @endphp

                                @if (auth()->user()->level == 'superadmin')
                                    <a href="{{ route('admin.chat.detail', $item->data['from_id']) }}">
                                        @if ($fromUserPhoto)
                                            <img src="{{ asset('storage/foto/' . $fromUserPhoto) }}" alt="" class="rounded-circle"
                                                style="width: 37px; height: 37px; object-fit: cover;">
                                        @else
                                            <img src="{{ asset('assets/img/blank-profile-picture.jpg') }}" alt="" class="rounded-circle"
                                                style="width: 37px; height: 37px; object-fit: cover;">
                                        @endif
                                    @elseif (auth()->user()->level == 'admin')
                                        <a href="{{ route('admin.chat.detail', $item->data['from_id']) }}">
                                            @if ($fromUserPhoto)
                                                <img src="{{ asset('storage/foto/' . $fromUserPhoto) }}" alt="" class="rounded-circle"
                                                    style="width: 37px; height: 37px; object-fit: cover;">
                                            @else
                                                <img src="{{ asset('assets/img/blank-profile-picture.jpg') }}" alt="" class="rounded-circle"
                                                    style="width: 37px; height: 37px; object-fit: cover;">
                                            @endif
                                        @elseif (auth()->user()->level == 'siswa')
                                            <a href="{{ route('user.chat.detail', $item->data['from_id']) }}">
                                                @if ($fromAdminPhoto)
                                                    <img src="{{ asset('storage/foto/' . $fromAdminPhoto) }}" alt="" class="rounded-circle"
                                                        style="width: 37px; height: 37px; object-fit: cover;">
                                                @else
                                                    <img src="{{ asset('assets/img/blank-profile-picture.jpg') }}" alt=""
                                                        class="rounded-circle" style="width: 37px; height: 37px; object-fit: cover;">
                                                @endif
                                @endif
                                <div>
                                    <h4>{{ $item->data['from_name'] }}</h4>
                                    <p>{{ $item->data['message'] }}</p>
                                    <p>{{ $item->created_at->diffForHumans() }}</p>
                                </div>
                                </a>
                            </li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                        @endif
                    @endforeach
                    <li class="dropdown-footer">
                    </li>
                </ul><!-- End Messages Dropdown Items -->
            </li><!-- End Messages Nav -->

            <li class="nav-item dropdown pe-3">

                <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#" data-bs-toggle="dropdown">
                    @if ($currentUser->foto)
                        <img src="{{ asset('storage/foto/' . $currentUser->foto) }}" alt="Profile" class="rounded-circle"
                            style="width: 37px; height: 37px; object-fit: cover; border-radius: 50%;">
                    @else
                        <img src="{{ asset('assets/img/blank-profile-picture.jpg') }}" alt="Profile" class="rounded-circle"
                            style="width: 37px; height: 37px; object-fit: cover; border-radius: 50%;">
                    @endif
                    <span class="d-none d-md-block dropdown-toggle ps-2">{{ $currentUser->nama }}</span>
                </a><!-- End Profile Iamge Icon -->

                <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">
                    <li class="dropdown-header">
                        <h6>{{ $currentUser->nama }}</h6>
                        <span>{{ $currentUser->level }}</span>
                    </li>
                    <li>
                        <hr class="dropdown-divider">
                    </li>

                    @if (auth()->user()->level == 'admin')
                        <li>
                            <a class="dropdown-item d-flex align-items-center" href="{{ route('profile.admin.edit') }}">
                                <i class="bi bi-person"></i>
                                <span>My Profile</span>
                            </a>
                        </li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li>
                            <form id="logout-form" action="{{ url('admin/logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form>
                            <a class="dropdown-item d-flex align-items-center" href="#"
                                onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                <i class="bi bi-box-arrow-right"></i>
                                <span>Sign Out</span>
                            </a>
                        </li>
                    @endif

                    @if (auth()->user()->level == 'superadmin')
                        <li>
                            <a class="dropdown-item d-flex align-items-center" href="{{ route('profile.admin.edit') }}">
                                <i class="bi bi-person"></i>
                                <span>My Profile</span>
                            </a>
                        </li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li>
                            <form id="logout-form" action="{{ url('admin/logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form>
                            <a class="dropdown-item d-flex align-items-center" href="#"
                                onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                <i class="bi bi-box-arrow-right"></i>
                                <span>Sign Out</span>
                            </a>
                        </li>
                    @endif

                    @if (auth()->user()->level == 'siswa')
                        <li>
                            <a class="dropdown-item d-flex align-items-center" href="{{ route('profile.edit') }}">
                                <i class="bi bi-person"></i>
                                <span>My Profile</span>
                            </a>
                        </li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li>
                            <form id="logout-form" action="{{ url('/logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form>
                            <a class="dropdown-item d-flex align-items-center" href="#"
                                onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                <i class="bi bi-box-arrow-right"></i>
                                <span>Sign Out</span>
                            </a>
                        </li>
                    @endif



                </ul><!-- End Profile Dropdown Items -->
            </li><!-- End Profile Nav -->

        </ul>
    </nav><!-- End Icons Navigation -->

</header><!-- End Header -->
