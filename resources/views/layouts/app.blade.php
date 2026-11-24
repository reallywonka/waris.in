<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'waris.in') }} : Estafet Barang Kampus</title>

        <!-- Favicon & Web Icons -->
        <link rel="icon" href="{{ asset('favicon.ico') }}" sizes="any">
        <link rel="icon" href="{{ asset('favicon.svg') }}" type="image/svg+xml">
        <link rel="apple-touch-icon" href="{{ asset('apple-touch-icon.png') }}">
        <link rel="manifest" href="{{ asset('site.webmanifest') }}">

        <!-- Google Fonts: Plus Jakarta Sans -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">

        <!-- Scripts & Tailwind CSS -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <style>
            [x-cloak] { display: none !important; }
        </style>
    </head>
    <body class="font-sans antialiased text-slate-900 bg-[#fbfbfb] flex flex-col min-h-screen selection:bg-emerald-100 selection:text-emerald-900">
        
        <!-- Navbar Atas -->
        @include('layouts.navigation')

        <!-- Flash Messages (Notifikasi Berhasil / Gagal) -->
        @if (session('success'))
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-4 w-full">
                <div class="bg-emerald-50 border border-emerald-200/80 text-emerald-900 px-4 py-3 rounded-2xl flex items-center justify-between shadow-2xs">
                    <div class="flex items-center space-x-2.5">
                        <x-icon name="check-circle" class="w-4 h-4 text-emerald-700 shrink-0" />
                        <span class="text-xs sm:text-sm font-medium">{{ session('success') }}</span>
                    </div>
                    <button onclick="this.parentElement.remove()" aria-label="Tutup notifikasi" class="text-emerald-600 hover:text-emerald-900 text-sm font-bold cursor-pointer">&times;</button>
                </div>
            </div>
        @endif

        @if (session('error'))
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-4 w-full">
                <div class="bg-rose-50 border border-rose-200/80 text-rose-900 px-4 py-3 rounded-2xl flex items-center justify-between shadow-2xs">
                    <div class="flex items-center space-x-2.5">
                        <x-icon name="alert-triangle" class="w-4 h-4 text-rose-600 shrink-0" />
                        <span class="text-xs sm:text-sm font-medium">{{ session('error') }}</span>
                    </div>
                    <button onclick="this.parentElement.remove()" aria-label="Tutup notifikasi" class="text-rose-600 hover:text-rose-900 text-sm font-bold cursor-pointer">&times;</button>
                </div>
            </div>
        @endif

        @if (session('info'))
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-4 w-full">
                <div class="bg-blue-50 border border-blue-200/80 text-blue-900 px-4 py-3 rounded-2xl flex items-center justify-between shadow-2xs">
                    <div class="flex items-center space-x-2.5">
                        <x-icon name="info" class="w-4 h-4 text-blue-700 shrink-0" />
                        <span class="text-xs sm:text-sm font-medium">{{ session('info') }}</span>
                    </div>
                    <button onclick="this.parentElement.remove()" aria-label="Tutup notifikasi" class="text-blue-600 hover:text-blue-900 text-sm font-bold cursor-pointer">&times;</button>
                </div>
            </div>
        @endif

        <!-- Konten Halaman Dinamis -->
        <main class="flex-grow py-6 sm:py-8 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 w-full">
            {{ $slot }}
        </main>

        <!-- Footer Bawah -->
        @include('layouts.footer')

        <!-- Global Pop-up Confirmation Modal Card -->
        <x-confirm-dialog />

    </body>
</html>
