@extends('layouts.app')

@section('seo_title', $page->getTranslatedAttribute('seo_title') ?: $page->getTranslatedAttribute('name'))
@section('meta_description', $page->getTranslatedAttribute('meta_description'))
@section('meta_keywords', $page->getTranslatedAttribute('meta_keywords'))

@section('content')

@include('partials.page_top', ['title' => $page->getTranslatedAttribute('name')])

<div class="new-partners-area default-padding-bottom py-5">
    <div class="container">
        <div class="d-flex flex-wrap justify-content-center justify-content-lg-start">
            @foreach ($partners as $partner)
                <div class="new-partner-single new-partner-single-sm text-center shadow rounded-xl mx-2">
                    <a href="{{ $partner->url }}" class="d-block">
                        <img src="{{ $partner->medium_img }}" alt="{{ $partner->getTranslatedAttribute('name') }}" class="img-fluid">
                    </a>
                </div>
            @endforeach
        </div>
    </div>
</div>

@endsection
