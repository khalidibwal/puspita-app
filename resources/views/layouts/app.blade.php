<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'PUSPITA MEDIKA') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <style>
        /* Sidebar styles */
        .sidebar {
            width: 250px;
            background-color: #343a40;
            color: white;
            height: 100vh;
            position: fixed;
            padding: 20px;
        }

        .sidebar h2 {
            margin-bottom: 20px;
        }

        .sidebar ul {
            list-style: none;
            padding: 0;
        }

        .sidebar ul li {
            margin: 15px 0;
        }

        .sidebar ul li a {
            color: white;
            text-decoration: none;
            padding: 10px 15px;
            display: block;
            border-radius: 5px;
            transition: background-color 0.3s;
        }

        .sidebar ul li a:hover {
            background-color: #495057;
        }

        /* Main content adjustment */
        .main-content {
            margin-left: 260px; /* to account for sidebar width */
            padding: 20px;
        }
    </style>
</head>
<body class="font-sans antialiased">
    <div class="min-h-screen bg-gray-100 dark:bg-gray-900">
        @include('layouts.navigation')

        <!-- Sidebar Navigation -->
        <nav class="sidebar">
            <h2>Puspita Medika Dashboard</h2>
            <ul>
                <li><a href="{{ route('dashboard') }}">Dashboard</a></li>
                @if (auth()->user()->role === 2)  <!-- Check if the user's role is 2 -->
                    <li><a href="{{ route('admin.index') }}">Users</a></li>
                @endif
                <li><a href="{{ route('dokters.index') }}">List Dokter</a></li>
                <li><a href="{{ route('pasiens.index') }}">List Pasien</a></li>
                <li><a href="{{ route('obats.index') }}">List Obat</a></li>
                <li><a href="{{ route('polikliniks.index') }}">List Poliklinik</a></li>
                <li><a href="{{ route('rekammedis.index') }}">Rekam Medis</a></li>
                <li><a href="{{ route('non_bookantrian.index') }}">Non-Booking</a></li>
            </ul>
        </nav>

        <!-- Page Heading -->
        <div class="main-content">
            @if (isset($header))
                <header class="bg-white dark:bg-gray-800 shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endif

            <!-- Page Content -->
            <main>
                {{ $slot }}
            </main>
        </div>
    </div>
</body>
</html>
