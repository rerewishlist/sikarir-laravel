@extends('layouts.content-guest')
@section('title', 'Profile Page')
@section('content-guest')

    <main class="main">

        <!-- Page Title -->
        <div class="page-title" data-aos="fade">
            <div class="container d-lg-flex justify-content-between align-items-center">
                <h1 class="mb-2 mb-lg-0">Profile</h1>
                <nav class="breadcrumbs">
                    <ol>
                        <li><a href="{{ Route('dashboard') }}">Home</a></li>
                        <li class="current">Profile</li>
                    </ol>
                </nav>
            </div>
        </div><!-- End Page Title -->

        <!-- Service Details Section -->
        <section id="service-details" class="service-details section">

            <div class="container">
                <div class="row gy-5">
                    <div class="col-lg-3" data-aos="fade-up" data-aos-delay="100">
                        <div class="service-box">
                            <div class="services-list">
                                <a href="{{ route('profile.edit') }}" class="profile-link">
                                    <i class="bi bi-arrow-right-circl"></i><span>Profile</span>
                                </a>
                                <a href="{{ route('password.edit') }}" class="password-link active">
                                    <i class="bi bi-arrow-right-circle"></i><span>Password</span>
                                </a>
                            </div>
                        </div><!-- End Services List -->
                    </div>

                    <div class="col-lg-9 ps-lg-5" data-aos="fade-up">
                        <!-- Password Section -->
                        <div id="password-section" class="mb-5">
                            <form method="post" action="{{ route('password.update') }}">
                                @csrf
                                @method('put')

                                <div class="row mb-3">
                                    <label for="currentPassword" class="col-sm-2 col-form-label">Current Password</label>
                                    <div class="col-sm-10">
                                        <input name="current_password" type="password"
                                            class="form-control @error('current_password', 'updatePassword') is-invalid @enderror" id="currentPassword">
                                        @error('current_password', 'updatePassword')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <label for="newPassword" class="col-sm-2 col-form-label">New Password</label>
                                    <div class="col-sm-10">
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
                                    <label for="confirmPassword" class="col-sm-2 col-form-label">Confirm Password</label>
                                    <div class="col-sm-10">
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
                                    <button type="submit" class="btn btn-primary">Update Password</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>



        </section><!-- /Service Details Section -->

    </main>

    <script>
        document.querySelector('.btn').addEventListener('click', function() {
            document.getElementById('formFileFoto').click();
        });
    </script>

    <style>
        .editor-container {
            padding-bottom: 50px;
            /* Menambahkan padding bawah pada kontainer editor */
        }
    </style>
@endsection
