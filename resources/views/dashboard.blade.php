@extends('layouts.main')
@section('title', 'Dashboard')
@section('content')
    <main id="main" class="main">

        <div class="pagetitle">
            @if (session()->has('success'))
                <div class="alert alert-primary alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            <h1>Dashboard</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item active">{{ auth()->user()->level }}</li>
                </ol>
            </nav>
        </div><!-- End Page Title -->

        @if (auth()->user()->level == 'admin')
            @include('admin.dashboard-admin')
        @endif

        @if (auth()->user()->level == 'superadmin')
            @include('admin.dashboard-admin')
        @endif

        @if (auth()->user()->level == 'siswa')
            @include('siswa.dashboard-siswa')
        @endif

    </main><!-- End #main -->
@endsection
