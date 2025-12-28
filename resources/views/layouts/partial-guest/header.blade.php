<div class="container-fluid container-xl position-relative d-flex align-items-center">
    @if (auth()->check())
        <a href="{{ Route('dashboard') }}" class="logo d-flex align-items-center me-auto">
        @else
            <a href="{{ Route('landing') }}" class="logo d-flex align-items-center me-auto">
    @endif
    <img src="{{ asset('assets-guest/img/logosikarir.png') }}" alt="">
    <h1 class="sitename"></h1>
    </a>

    <nav id="navmenu" class="navmenu">
        <ul>
            @php
                $instansi = optional($informasi)->instansi;
            @endphp

            @if (auth()->check())
                <li><a href="{{ Route('dashboard') }}" class="@yield('menuLanding')">Home</a></li>
                <li><a href="{{ Route('user.berita.view') }}" class="@yield('menuBerita')">Berita</a></li>
                {{-- <li><a href="{{ Route('user.materi') }}" class="@yield('menuMateri')">Materi</a></li> --}}
                <li><a href="{{ Route('user.dataforum.view') }}" class="@yield('menuForum')">Forum</a></li>
                <li><a href="{{ Route('user.chat.view') }}" class="@yield('menuChat')">Chat</a></li>
                <li><a href="{{ Route('tes-minat.index') }}" class="@yield('menuTes')">Tes</a></li>
                <li class="dropdown">
                    <a href="#">
                        <span class="icon-wrapper">
                            <i class="bi bi-bell icon-size"></i>
                            @if ($beritaforummateriNotifications->count() > 0)
                                <span class="badge">{{ $beritaforummateriNotifications->whereNull('read_at')->count() }}</span>
                            @endif
                            
                        </span>
                        <i class="bi bi-chevron-down toggle-dropdown"></i>
                    </a>
                    <ul class="notification-list">
                        <li style="justify-content: center">
                            Anda memiliki {{ $beritaforummateriNotifications->whereNull('read_at')->count() }} notifikasi baru
                        </li>
                        @foreach ($beritaforummateriNotifications as $item)
                            <li>
                                @if ($item->data['type'] == 'berita')
                                    <a href="{{ route('user.berita.detail', $item->data['slug']) }}">
                                        <i class="bi bi-newspaper"></i>
                                        <div class="message-content">
                                            <strong>{!! \Illuminate\Support\Str::limit(strip_tags($item->data['judul']), 15, '...') !!}</strong>
                                            <p>{{ $item->created_at->diffForHumans() }}</p>
                                        </div>
                                    </a>
                                @elseif($item->data['type'] == 'forum')
                                    <a href="{{ route('user.dataforum.detail', $item->data['forum_id']) }}">
                                        <i class="bi bi-chat-dots"></i></i>
                                        <div class="message-content">
                                            <strong>{!! \Illuminate\Support\Str::limit(strip_tags($item->data['judul']), 15, '...') !!}</strong>
                                            <p>{{ $item->created_at->diffForHumans() }}</p>
                                        </div>
                                    </a>
                                @elseif($item->data['type'] == 'materi')
                                    <a href="{{ route('user.materi.detail', $item->data['materi_id']) }}">
                                        <i class="bi bi-blockquote-left"></i>
                                        <div class="message-content">
                                            <strong>{!! \Illuminate\Support\Str::limit(strip_tags($item->data['judul']), 15, '...') !!}</strong>
                                            <p>{{ $item->created_at->diffForHumans() }}</p>
                                        </div>
                                    </a>
                                @endif
                            </li>
                        @endforeach
                        <li style="justify-content: center">
                            <a href="{{ route('user.notifications.view') }}">Tampilkan semua notifikasi baru</a>
                        </li>
                    </ul>
                </li>

                <li class="dropdown">
                    <a href="#">
                        <span class="icon-wrapper">
                            <i class="bi bi-chat-left-text icon-size"></i>
                            @if ($chatNotifications->count() > 0)
                                <span class="badge">{{ $chatNotifications->whereNull('read_at')->count() }}</span>
                            @endif
                        </span>
                        <i class="bi bi-chevron-down toggle-dropdown"></i>
                    </a>
                    <ul class="notification-list">
                        <li style="justify-content: center">
                            Anda memiliki {{ $chatNotifications->whereNull('read_at')->count() }} pesan baru
                        </li>
                        @foreach ($chatNotifications as $item)
                            @php
                                $fromId = $item->data['from_id'];
                                $user = \App\Models\User::find($fromId);
                                $admin = \App\Models\Admin::find($fromId);

                                $fromAdminPhoto = optional($admin)->foto;
                                $fromUserPhoto = optional($user)->foto;
                            @endphp
                            <li>
                                <a href="{{ route('user.chat.detail', $item->data['from_id']) }}">
                                    @if ($fromAdminPhoto)
                                        <img src="{{ asset('storage/foto/' . $fromAdminPhoto) }}" alt="" class="rounded-circle">
                                    @else
                                        <img src="{{ asset('assets/img/blank-profile-picture.jpg') }}" alt="" class="rounded-circle">
                                    @endif
                                    <div class="message-content">
                                        <strong>{{ $item->data['from_name'] }}</strong>
                                        <span>{!! \Illuminate\Support\Str::limit(strip_tags($item->data['message']), 15, '...') !!}</span>
                                        <p>{{ $item->created_at->diffForHumans() }}</p>
                                    </div>
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </li>

                <li class="dropdown"><a href="#" class="@yield('menuContact') @yield('menuPerusahaan')"><span>Informasi</span> <i class="bi bi-chevron-down toggle-dropdown"></i></a>
                    <ul>
                        @if ($instansi)
                            <li><a href="{{ Route('contact.menu') }}" class="@yield('menuContact')">Contact</a></li>
                        @endif
                        <li><a href="{{ Route('user.perusahaan.view') }}" class="@yield('menuPerusahaan')">Perusahaan</a></li>
                    </ul>
                </li>

            @else
                <li><a href="{{ Route('landing') }}" class="@yield('menuLanding')">Home</a></li>
                <li><a href="{{ Route('berita.menu') }}" class="@yield('menuBerita')">Berita</a></li>
                <li><a href="{{ Route('forum.menu') }}" class="@yield('menuForum')">Forum</a></li>
            
                <li class="dropdown"><a href="#" class="@yield('menuContact') @yield('menuPerusahaan')"><span>Informasi</span> <i class="bi bi-chevron-down toggle-dropdown"></i></a>
                    <ul>
                        @if ($instansi)
                            <li><a href="{{ Route('contact.menu') }}" class="@yield('menuContact')">Contact</a></li>
                        @endif
                        <li><a href="{{ Route('perusahaan.menu') }}" class="@yield('menuPerusahaan')">Perusahaan</a></li>
                    </ul>
                </li>

                
                
            @endif
        </ul>
        <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
    </nav>

    @if (auth('admin')->check())
        <a class="btn-getstarted" href="{{ route('admin.dashboard') }}">{{ auth('admin')->user()->nama }}</a>
    @elseif (auth()->check())
        <div class="dropdown">
            <a class="btn-getstarted dropdown-toggle" href="#" id="profileDropdown" role="button" data-bs-toggle="dropdown"
                aria-expanded="false">
                {{ $currentUser->nama }}
            </a>
            <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile mt-2" aria-labelledby="profileDropdown">
                <li class="dropdown-header">
                    <div class="d-flex align-items-center">
                        @if ($currentUser->foto)
                            <img src="{{ asset('storage/foto/' . $currentUser->foto) }}" alt="" class="rounded-circle"
                                style="width: 50px; height: 50px;">
                        @else
                            <img src="{{ asset('assets/img/blank-profile-picture.jpg') }}" alt="" class="rounded-circle"
                                style="width: 50px; height: 50px;">
                        @endif
                        <div class="ms-3">
                            <h6>{{ $currentUser->nama }}</h6>
                            <span>{{ $currentUser->level }}</span>
                        </div>
                    </div>
                </li>
                <li>
                    <hr class="dropdown-divider">
                </li>
                <li>
                    <a class="dropdown-item d-flex align-items-center" href="{{ route('profile.edit') }}">
                        <i class="bi bi-person"></i>
                        <span class="ms-2">My Profile</span>
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
                        <span class="ms-2">Sign Out</span>
                    </a>
                </li>
            </ul>
        </div>
    @else
        <a class="btn-getstarted" href="/login">Login</a>
    @endif

</div>

<!-- Message Container -->
<div id="message-container" class="message-container hidden">
    <div id="message" class="message">
        <!-- Checkmark Icon -->
        <div class="checkmark-container">
            <svg class="checkmark" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 52 52">
                <circle class="checkmark-circle" cx="26" cy="26" r="25" fill="none" />
                <path class="checkmark-check" fill="none" d="M16 27l6 6 14-14" />
            </svg>
        </div>
        <!-- Message Text -->
        <div class="message-text">Sukses</div>
    </div>
</div>

</header>

<!-- Message Container -->
<div id="message-container" class="message-container hidden">
    <div id="message" class="message"></div>
</div>

<style>
    /* Notifikasi dan Pesan*/
    .icon-wrapper {
        position: relative;
        display: inline-block;
    }

    .icon-size {
        font-size: 18px !important;
        /* Ubah ukuran ikon sesuai kebutuhan */
    }

    .badge {
        position: absolute;
        top: 0;
        right: 0;
        transform: translate(50%, -50%);
        background-color: var(--accent-color);
        /* Warna latar belakang */
        color: white;
        /* Warna angka */
        border-radius: 50%;
        padding: 0.2em 0.5em;
        font-size: 12px;
        /* Ukuran teks badge */
        font-weight: bold;
    }

    ul.notification-list {
        list-style-type: none;
        padding: 0;
        margin: 0;
    }

    ul.notification-list li {
        margin: 0;
        padding: 5px;
        border-bottom: 1px solid #e0e0e0;
        display: flex;
        align-items: flex-start;
        width: 100%;
    }

    ul.notification-list li a {
        text-decoration: none;
        color: #333;
        display: flex;
        align-items: flex-start;
        width: 100%;
        gap: 10px;
    }

    ul.notification-list li a:hover {
        background-color: #f5f5f5;
    }

    ul.notification-list li i,
    ul.notification-list li img {
        flex-shrink: 0;
        /* Prevents the icon and image from shrinking */
    }

    ul.notification-list li i {
        border-radius: 50%;
        width: 37px;
        height: 37px;
        font-size: 1.5em !important;
        /* Adjust font size to match image size */
        display: flex;
        align-items: center;
        justify-content: center;
        line-height: 37px;
        /* Align icon vertically */
    }

    ul.notification-list li img {
        border-radius: 50%;
        width: 37px;
        height: 37px;
        object-fit: cover;
    }

    ul.notification-list li strong {
        margin-right: 5px;
        color: #555;
        white-space: nowrap;
    }

    ul.notification-list li span {
        flex-grow: 1;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    ul.notification-list li .message-content {
        display: flex;
        flex-direction: column;
        flex-grow: 1;
        /* Takes up the remaining space */
    }

    ul.notification-list li .message-content strong {
        font-weight: bold;
        margin-bottom: 5px;
        color: #555;
    }

    ul.notification-list li .message-content span {
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    ul.notification-list li .message-content p {
        font-size: 0.8em;
        color: #888;
        margin-top: 5px;
        margin-bottom: 1px;
    }




    /* Message Container */
    .message-container {
        position: fixed;
        top: calc(100px + 10px);
        /* Adjust '50px' to the height of your header + some spacing */
        left: 50%;
        transform: translateX(-50%);
        z-index: 999;
        display: flex;
        justify-content: center;
        align-items: center;
        padding: 15px;
        border-radius: 8px;
        /* Bentuk persegi dengan sudut membulat */
        background-color: var(--accent-color);
        /* Background putih */
        color: var(--contrast-color);
        /* Tulisan biru */
        font-size: 16px;
        font-weight: bold;
        box-shadow: 0px 0 18px rgba(0, 0, 0, 0.1);
        width: 300px;
        /* Lebar tetap untuk persegi panjang */
        text-align: center;
        /* Tulisan berada di tengah */
        opacity: 0;
        transition: opacity 0.3s ease-in-out;
    }
</style>

<script>
    /* flash message */
    document.addEventListener('DOMContentLoaded', function() {
        // Function to show the message
        function showMessage(message) {
            const messageContainer = document.getElementById('message-container');
            const messageElement = document.getElementById('message');

            // Set the message
            messageElement.textContent = message;

            // Remove the hidden class and show the message
            messageContainer.classList.remove('hidden');
            messageContainer.style.opacity = 1;

            // Hide the message after 2 seconds
            setTimeout(function() {
                messageContainer.style.opacity = 0;
                setTimeout(function() {
                    messageContainer.classList.add('hidden');
                }, 300); // Wait for the fade-out transition to complete
            }, 2000);
        }

        // Example usage
        // Replace this part with actual logic to call showMessage() based on session messages
        @if (session('success'))
            showMessage('{{ session('success') }}');
        @endif
    });
</script>
