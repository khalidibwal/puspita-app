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
            border-radius: 5px; /* Added rounded border */
            overflow-y: auto; /* Make sidebar scrollable */
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
            border-radius: 5px; /* Rounded border for each menu item */
            overflow: hidden;
        }

        .sidebar ul li a {
            color: white;
            text-decoration: none;
            padding: 10px 15px;
            display: block;
            border-radius: 5px; /* Rounded border for links */
            transition: background-color 0.3s;
        }

        .sidebar ul li a:hover {
            background-color: #495057;
        }

        .Menu-card {
            cursor: pointer;
            position: relative;
            /* padding: 10px 15px; */
            border-radius: 5px; /* Rounded border for expandable menu */
            background-color: #3d464d;
        }

        .expandable-menu {
            cursor: pointer;
            position: relative;
            padding: 10px 15px;
            border-radius: 5px; /* Rounded border for expandable menu */
            background-color: #3d464d;
        }

        .expandable-menu::after {
            content: '▼';
            font-size: 0.8rem;
            position: absolute;
            right: 15px;
            transition: transform 0.3s ease;
        }

        .expandable-menu.active::after {
            transform: rotate(-180deg);
        }

        /* Child menu styles */
        .child-menu {
            display: none;
            margin-left: 20px;
            padding: 10px;
        }

        .child-menu a {
            padding: 8px 15px;
            font-size: 0.9rem;
            background-color: #6c757d; /* Sub-menu background */
            border-radius: 5px; /* Rounded border for sub-menu items */
            margin: 5px 0;
        }

        .child-menu a:hover {
            background-color: #5a6268;
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

    <!-- JavaScript for expanding and collapsing the menus -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const expandableMenus = document.querySelectorAll('.expandable-menu');
            
            expandableMenus.forEach(menu => {
                menu.addEventListener('click', function () {
                    this.classList.toggle('active');
                    const childMenu = this.nextElementSibling;
                    childMenu.style.display = childMenu.style.display === 'block' ? 'none' : 'block';
                });
            });
        });
    </script>
</body>
</html>
