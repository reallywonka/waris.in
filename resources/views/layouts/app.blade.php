<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'waris.in') }} — Estafet Barang Kampus</title>

        <!-- Google Fonts: Plus Jakarta Sans -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

        <!-- Scripts & Tailwind CSS -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <style>
            [x-cloak] { display: none !important; }
        </style>
    </head>
    <body class="font-sans antialiased text-waris-text bg-waris-bg flex flex-col min-h-screen selection:bg-waris-primary-soft selection:text-waris-primary">
        
        <!-- Navbar Atas -->
        @include('layouts.navigation')

        <!-- Flash Messages (Notifikasi Berhasil / Gagal) -->
        @if (session('success'))
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-4 w-full">
                <div class="bg-waris-primary-soft border border-waris-primary-border text-waris-primary px-4 py-3 rounded-xl flex items-center justify-between shadow-2xs">
                    <div class="flex items-center space-x-2.5">
                        <x-icon name="check-circle" class="w-4 h-4 text-waris-primary-muted shrink-0" />
                        <span class="text-xs sm:text-sm font-medium">{{ session('success') }}</span>
                    </div>
                    <button onclick="this.parentElement.remove()" class="text-waris-primary-muted hover:text-waris-primary text-sm font-bold cursor-pointer">&times;</button>
                </div>
            </div>
        @endif

        @if (session('error'))
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-4 w-full">
                <div class="bg-waris-danger-soft border border-waris-danger-border text-waris-danger-text px-4 py-3 rounded-xl flex items-center justify-between shadow-2xs">
                    <div class="flex items-center space-x-2.5">
                        <x-icon name="alert-triangle" class="w-4 h-4 text-waris-danger shrink-0" />
                        <span class="text-xs sm:text-sm font-medium">{{ session('error') }}</span>
                    </div>
                    <button onclick="this.parentElement.remove()" class="text-waris-danger hover:text-waris-danger-hover text-sm font-bold cursor-pointer">&times;</button>
                </div>
            </div>
        @endif

        @if (session('info'))
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-4 w-full">
                <div class="bg-waris-info-soft border border-waris-info-border text-waris-info-text px-4 py-3 rounded-xl flex items-center justify-between shadow-2xs">
                    <div class="flex items-center space-x-2.5">
                        <x-icon name="info" class="w-4 h-4 text-waris-info shrink-0" />
                        <span class="text-xs sm:text-sm font-medium">{{ session('info') }}</span>
                    </div>
                    <button onclick="this.parentElement.remove()" class="text-waris-info hover:text-waris-info-text text-sm font-bold cursor-pointer">&times;</button>
                </div>
            </div>
        @endif

        <!-- Konten Halaman Dinamis -->
        <main class="flex-grow py-8 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 w-full">
            {{ $slot }}
        </main>

        <!-- Footer Bawah -->
        @include('layouts.footer')

    </body>
</html>