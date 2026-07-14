<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description"
        content="@yield('meta_description', 'BeautyCare - Aplikasi Manajemen Bisnis Kecantikan untuk Salon, Spa, Nail Art, Barbershop, dan Skincare.')">
    <meta name="keywords" content="beautycare, manajemen salon, software kecantikan, booking online, POS salon">
    <meta name="author" content="BeautyCare">

    <title>@yield('title', 'BeautyCare - Manajemen Bisnis Kecantikan')</title>

    <link rel="icon" type="image/svg+xml" href="{{ asset('assets/images/logo/favicon.svg') }}">
    <link rel="alternate icon" href="{{ asset('assets/images/logo/favicon.svg') }}">

    <!-- Font -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">

    <!-- Styles -->
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    @stack('styles')
    <link rel="stylesheet" href="{{ asset('assets/css/responsive.css') }}">

    @stack('head')
</head>

<body>