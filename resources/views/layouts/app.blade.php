<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('seo_title')</title>
    <meta name="description" content="@yield('meta_description')" />
    <meta name="keywords" content="@yield('meta_keywords')" />

    <link rel="canonical" href="{{ url()->current() }}">

    @php
		$htmlClass = [];
		$badEye = json_decode(request()->cookie('bad_eye'), true);
		if (is_array($badEye)) {
			foreach ($badEye as $key => $value) {
				if ($value != 'normal' && !in_array('bad-eye', $htmlClass)) {
					$htmlClass[] = 'bad-eye';
				}
				$htmlClass[] = 'bad-eye-' . $key . '-' . $value;
			}
		}
        $assetsVersion = env('ASSETS_VERSION', 1);
    @endphp

    <link rel="stylesheet" href="{{ asset('css/main.css?v=' . $assetsVersion) }}">
    <link rel="stylesheet" href="{{ asset('css/custom.css?v=' . $assetsVersion) }}">

    {{-- <link rel="stylesheet" href="{{ asset('css/vendor.css?v=' . $assetsVersion) }}">
    <link rel="stylesheet" href="{{ asset('css/app.css?v=' . $assetsVersion) }}"> --}}

    @yield('styles')

    <link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png">
    <link rel="manifest" href="/site.webmanifest">
    <link rel="mask-icon" href="/safari-pinned-tab.svg" color="#5bbad5">
    <meta name="msapplication-TileColor" content="#da532c">
    <meta name="theme-color" content="#ffffff">

    {!! setting('site.facebook_pixel_code') !!}

    {!! setting('site.jivochat_code') !!}

</head>
<body class="@yield('body_class')">

    @include('partials.svg')

    <x-header />

    @yield('content')

    <x-footer />

    @yield('after_footer_blocks')

    @include('partials.preloader')
	
    <script src="{{ asset('js/main.js?v=' . $assetsVersion) }}"></script>
    <script src="{{ asset('js/custom.js?v=' . $assetsVersion) }}"></script>

    {{-- <script src="{{ asset('js/app.js?v=' . $assetsVersion) }}"></script> --}}

    @yield('scripts')

    {!! setting('site.google_analytics_code') !!}
    {!! setting('site.yandex_metrika_code') !!}
    {!! setting('site.inweb_widget_code') !!}

    @yield('microdata')

</body>
</html>
