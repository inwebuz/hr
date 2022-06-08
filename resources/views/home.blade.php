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

<main class="main">

    <section class="hero-banner">
        <div class="container">
            <div class="row hero-banner__wrap">
                <div class="col-lg-9">
                    <div class="hero-swiper-main swiper-container radius-12">
                        <div class="swiper-wrapper">
                            @foreach ($slides as $slide)
                            <div class="swiper-slide">
                                <div class="hero-swiper-main__item radius-12"
                                    style="background-image: url('{{ $slide->img }}')">
                                    <h2>{{ $slide->getTranslatedAttribute('name') }}</h2>
                                    <p class="sub-title font-regular">{{ $slide->getTranslatedAttribute('description') }}</p>
                                    @if ($slide->getTranslatedAttribute('button_text') && $slide->getTranslatedAttribute('url'))
                                        <a href="{{ $slide->getTranslatedAttribute('url') }}" class="btn btn-primary lg radius-8">{{ $slide->getTranslatedAttribute('button_text') }}</a>
                                    @endif
                                </div>
                            </div>
                            @endforeach

                        </div>
                        <div class="swiper-button-prev">
                            <svg width="18" height="18" fill="rgba(0, 0, 0, .3)">
                                <use xlink:href="#arrow-prev"></use>
                            </svg>
                        </div>
                        <div class="swiper-button-next">
                            <svg width="18" height="18" fill="rgba(0, 0, 0, .3)">
                                <use xlink:href="#arrow-next"></use>
                            </svg>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 d-none d-lg-block">
                    <div class="hero-swiper-sub swiper-container radius-12">
                        <div class="swiper-wrapper">
                            @php
                                $slideProducts = $promotionProducts;
                                // if ($slideProducts->isEmpty()) {
                                //     $slideProducts = $newProducts;
                                // }
                            @endphp
                            @foreach ($slideProducts as $product)
                            <div class="swiper-slide">
                                <div class="hero-swiper-sub__item radius-12">
                                    @if ($product->isDiscounted())
                                        <span class="sale-text bg-danger radius-14">-{{ $product->discount_percent }}%</span>
                                    @endif
                                    <a href="{{ $product->url }}" class="d-block">
                                        <img src="{{ $product->small_img }}" alt="{{ $product->getTranslatedAttribute('name') }}" class="img-fluid">
                                    </a>
                                    <a href="{{ $product->url }}" class="title-link">{{ $product->getTranslatedAttribute('name') }}</a>
                                    <p class="price-text">{{ Helper::formatPrice($product->current_price) }}</p>
                                    @if ($product->isDiscounted())
                                        <del>{{ Helper::formatPrice($product->current_not_sale_price) }}</del>
                                    @endif

                                    <div class="mt-1">
                                        @include('partials.stars', ['rating' => $product->rating_avg])
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                        <div class="swiper-button-prev">
                            <svg width="18" height="18" fill="rgba(0, 0, 0, .3)">
                                <use xlink:href="#arrow-prev"></use>
                            </svg>
                        </div>
                        <div class="swiper-button-next">
                            <svg width="18" height="18" fill="rgba(0, 0, 0, .3)">
                                <use xlink:href="#arrow-next"></use>
                            </svg>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <x-categories></x-categories>

    <x-bestseller-products></x-bestseller-products>

    <section class="ikarvon-b">
        <div class="container">
            <div class="row ikarvon-b__wrap">
                <div class="col-lg-4 col-sm-4 col-6 ikarvon-b-box__parent">
                    <x-banner-middle type="middle_1"></x-banner-middle>
                </div>
                <div class="col-lg-4 col-sm-4 col-6 ikarvon-b-box__parent">
                    <x-banner-middle type="middle_2"></x-banner-middle>
                </div>
                <div class="col-lg-4 col-sm-4 col-6 ikarvon-b-box__parent d-none d-sm-block">
                    <x-banner-middle type="middle_3"></x-banner-middle>
                </div>
            </div>
        </div>
    </section>

    <x-promotion-products></x-promotion-products>

    <x-new-products></x-new-products>

    <x-news></x-news>

    <x-brands></x-brands>

    <section class="about text-block">
        <div class="container">
            <div data-target="more-container" class="gradient">
                {!! $page->getTranslatedAttribute('body') !!}
            </div>
            @if($page->getTranslatedAttribute('body'))
            <a href="javascript:;" data-toggle="more-btn" class="d-block mt-3">{{ __('main.read_all') }}</a>
            @endif
        </div>
    </section>

</main>


@endsection
