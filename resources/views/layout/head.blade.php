<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite(['resources/scss/app.scss'])
    {{-- <title>@yield('seo_title', $site->seo_title)</title> --}}
    <meta name="csrf-token" content="{{ csrf_token() }}">
    {{-- <meta name="description" content="@yield('seo_description', $site->seo_description)"> --}}
</head>

<body>
