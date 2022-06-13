@extends('layouts.app')

@section('seo_title', $page->getTranslatedAttribute('seo_title') ?: $page->getTranslatedAttribute('name'))
@section('meta_description', $page->getTranslatedAttribute('meta_description'))
@section('meta_keywords', $page->getTranslatedAttribute('meta_keywords'))
@section('body_class', 'home-page')

@section('content')

@if (session()->has('alert') || session()->has('success') || session()->has('status') || session()->has('error') || session()->has('message'))
<div class="content-block">
    @include('partials.alerts')
</div>
@endif

<!-- Start Banner
============================================= -->
<div class="banner-area text-center text-big">
    <div id="bootcarousel" class="carousel text-light slide animate_text" data-ride="carousel">

        <!-- Wrapper for slides -->
        <div class="carousel-inner carousel-zoom">

            @foreach ($slides as $key => $slide)
            <div class="carousel-item @if($key == 0) active @endif">
                <div class="slider-thumb bg-fixed" style="background-image: url({{ $slide->img }});"></div>
                <div class="box-table">
                    <div class="box-cell e-shadow dark-hard">
                        <div class="container">
                            <div class="content">
                                <h2 data-animation="animated zoomInLeft">{{ $slide->getTranslatedAttribute('name') }}</h2>
                                <p class="animated slideInRight">{{ $slide->getTranslatedAttribute('description') }}</p>
                                @if ($slide->getTranslatedAttribute('button_text') && $slide->getTranslatedAttribute('url'))
                                <a data-animation="animated zoomInUp" class="btn btn-outline-light effect btn-md" href="{{ $slide->getTranslatedAttribute('url') }}">{{ $slide->getTranslatedAttribute('button_text') }}</a>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        <!-- End Wrapper for slides -->

        <!-- Left and right controls -->
        <a class="left carousel-control light" href="#bootcarousel" data-slide="prev">
            <i class="fa fa-angle-left"></i>
            <span class="sr-only">{{ __('main.previous') }}</span>
        </a>
        <a class="right carousel-control light" href="#bootcarousel" data-slide="next">
            <i class="fa fa-angle-right"></i>
            <span class="sr-only">{{ __('main.next') }}</span>
        </a>

    </div>
</div>
<!-- End Banner -->

<!-- Start About
============================================= -->
<div class="about-us-area default-padding bg-green2">
    <div class="container">
        <div class="about-items">
            <div class="row align-center">
                <div class="col-lg-6 mb-4 mb-lg-0">
                    <img src="{{ $homeSeo->img }}" class="img-fluid rounded-circle border-white-20-60" alt="{{ $homeSeo->getTranslatedAttribute('name') }}">
                </div>
                <div class="col-lg-6 info">
                    <h2>{{ $homeSeo->getTranslatedAttribute('name') }}</h2>
                    <div>
                        {!! $homeSeo->getTranslatedAttribute('description') !!}
                    </div>

                    <div class="author">
                        <div class="signature">
                            <img src="{{ $founder->img }}" class="img-fluid" alt="{{ $founder->getTranslatedAttribute('name') }}">
                        </div>
                        <div class="intro">
                            <h5 class="text-secondary font-weight-bold">{{ $founder->getTranslatedAttribute('name') }}</h5>
                            <span class="text-green2 font-weight-semibold">{{ $founder->getTranslatedAttribute('description') }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- End About Area -->

<!-- Start Services Area
============================================= -->
<div class="thumb-services-area inc-thumbnail default-padding bottom-less">
    <!-- Shape -->
    <div class="right-shape">
        <img src="{{ asset('assets/img/shape/9.png') }}" alt="Shape">
    </div>
    <!-- Shape -->
    <div class="container">
        <div class="row">
            <div class="col-lg-8 offset-lg-2">
                <div class="site-heading text-center">
                    <h2>{{ $servicesPage->getTranslatedAttribute('name') }}</h2>
                    <p>{{ $servicesPage->getTranslatedAttribute('description') }}</p>
                    {{-- <div class="divider"></div> --}}
                </div>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="services-items text-center">
            <div class="row">
                @foreach ($services as $service)
                <div class="col-lg-4 col-md-6 single-item">
                    @include('partials.service_one')
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
<!-- End Services Area -->

<!-- Start Contact Area
============================================= -->
@php
    $phone = Helper::setting('contact.phone');
    $phone2 = Helper::setting('contact.phone2');
    $email = Helper::setting('contact.email');
@endphp
<div class="contact-area default-padding bg-theme inc-shape">
    <div class="container">
        <div class="row align-center">
            <div class="col-lg-5 info">
                <div class="content">
                    <h2>{{ $writeUs->getTranslatedAttribute('name') }}</h2>
                    <p>{{ $writeUs->getTranslatedAttribute('description') }}</p>
                    <ul>
                        <li>
                            <i class="fas fa-phone"></i>
                            <p>
                                @if ($phone)
                                    <a href="tel:{{ Helper::phone($phone) }}" class="text-dark">{{ $phone }}</a>
                                @endif
                                @if ($phone2)
                                    <br>
                                    <a href="tel:{{ Helper::phone($phone2) }}" class="text-dark">{{ $phone2 }}</a>
                                @endif
                            </p>
                        </li>
                        <li>
                            <i class="far fa-envelope"></i>
                            <p>
                                @if ($email)
                                    <a href="mailto:{{ $email }}" class="text-primary">{{ $email }}</a>
                                @endif
                            </p>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="col-lg-6 offset-lg-1 contact-form-box">
                <div class="form-box">
                    <form action="{{ route('contacts.send') }}" method="POST" class="contact-form">
                        @csrf

                        <div class="form-result"></div>

                        <div class="row">
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <input class="form-control" name="name" placeholder="{{ __('main.form.your_name') }}" type="text">
                                    <span class="alert-error"></span>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <input class="form-control" name="email" placeholder="{{ __('main.email') }}" type="email">
                                    <span class="alert-error"></span>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <input class="form-control" name="phone_number" placeholder="{{ __('main.phone_number') }}" type="text">
                                    <span class="alert-error"></span>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="form-group comments">
                                    <textarea class="form-control" name="message" placeholder="{{ __('main.message') }}"></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label class="text-white">{{ __('main.cv_pdf_or_docs') }}</label>
                                    <input type="file" name="file" class="border-0">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12">
                                <button type="submit" name="submit" id="submit">
                                    {{ __('main.to_send') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- End Contact Area -->

<!-- Start Blog
============================================= -->
<div class="blog-area bg-green2 default-padding bottom-less position-relative">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 offset-lg-2">
                <div class="site-heading text-center">
                    <h2>{{ $newsText->getTranslatedAttribute('name') }}</h2>
                    <p>{{ $newsText->getTranslatedAttribute('description') }}</p>
                </div>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="blog-items">
            <div class="row">
                @foreach ($news as $publication)
                <div class="single-item col-lg-4 col-md-6">
                    @include('partials.publication_one')
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
<!-- End Blog Area -->

<x-reviews></x-reviews>

<x-partners></x-partners>

@endsection
