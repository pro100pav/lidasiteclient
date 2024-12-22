<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title ?? 'Page Title' }} | {{env('APP_NAME')}}</title>
    <link rel="icon" type="image/x-icon" href="/favicon.ico">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="{{ asset('/assets/css/uikit.min.css') }}">
    <link rel="stylesheet" href="{{ asset('/assets/libs/summer/summernote.min.css') }}">
    <link rel="stylesheet" href="{{ asset('/assets/libs/summer/summernote-lite.css') }}">
    <link rel="stylesheet" href="{{ mix('/assets/css/cabinet.css') }}" media="screen">
</head>
<body>
    {{-- @include('components.navbar') --}}
    @yield('content')
    @include('components.dashFooter')
    <script src="{{ asset('/assets/js/jquery.min.js') }}"></script>
    <script src="{{ asset('/assets/js/uikit.min.js') }}"></script>
    <script src="{{ asset('/assets/js/uikit-icons.min.js') }}"></script>
    <script src="https://d3js.org/d3.v7.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/d3-org-chart@3"></script>
    <script src="https://cdn.jsdelivr.net/npm/d3-flextree@2.1.2/build/d3-flextree.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/resumable.js/1.1.0/resumable.min.js"></script>

    <script src="{{ asset('/assets/libs/summer/summernote.min.js') }}"></script>
    <script src="{{ asset('/assets/libs/summer/summernote-lite.js') }}"></script>
    <script src="{{ asset('/assets/libs/summer/lang/summernote-ru-RU.min.js') }}"></script>
    <script class="u-script" type="text/javascript" src="{{ mix('/assets/js/cabinet.js') }}" defer=""></script>
    @include('components.alerts')
    
</body>
</html>
