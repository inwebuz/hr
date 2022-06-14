@extends('layouts.app')

@section('seo_title', $gallery->getTranslatedAttribute('seo_title') ?: $gallery->getTranslatedAttribute('name'))
@section('meta_description', $gallery->getTranslatedAttribute('meta_description'))
@section('meta_keywords', $gallery->getTranslatedAttribute('meta_keywords'))

@section('content')

@include('partials.page_top', ['title' => $gallery->getTranslatedAttribute('name')])

<div class="gallery-area overflow-hidden py-5 position-relative">
    <div class="container">
        <div class="case-items-area">
            <div class="masonary">
                <div id="portfolio-grid" class="gallery-items colums-3">
                    @foreach ($gallery->imgs as $key => $img)
                    <div class="pf-item">
                        <div class="item">
                            <div class="thumb">
                                <img src="{{ in_array($key % 6, [1, 3, 4]) ? $gallery->large_imgs[$key] : $gallery->medium_imgs[$key] }}" alt="{{ $gallery->getTranslatedAttribute('name') . ' ' . $key }}">
                            </div>
                            <div class="content">
                                <div class="button">
                                    <a href="{{ $img }}" class="item popup-gallery">
                                        <i class="fas fa-plus"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
