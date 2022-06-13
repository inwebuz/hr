@extends('layouts.app')

@section('seo_title', $page->getTranslatedAttribute('seo_title') ?: $page->getTranslatedAttribute('name'))
@section('meta_description', $page->getTranslatedAttribute('meta_description'))
@section('meta_keywords', $page->getTranslatedAttribute('meta_keywords'))

@section('content')

@include('partials.page_top', ['title' => $page->getTranslatedAttribute('name')])

<!-- Start Services Area
============================================= -->
<div class="thumb-services-area inc-thumbnail py-5 position-relative">
    <!-- Shape -->
    <div class="right-shape">
        <img src="{{ asset('assets/img/shape/9.png') }}" alt="Shape">
    </div>
    <!-- Shape -->
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

@endsection
