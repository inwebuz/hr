@extends('layouts.app')

@section('seo_title', $page->getTranslatedAttribute('seo_title') ?: $page->getTranslatedAttribute('name'))
@section('meta_description', $page->getTranslatedAttribute('meta_description'))
@section('meta_keywords', $page->getTranslatedAttribute('meta_keywords'))

@section('content')

@include('partials.page_top', ['title' => $page->getTranslatedAttribute('name')])

<div class="blog-area py-5 position-relative">
    <div class="container">
        <div class="blog-items">
            <div class="row">
                @foreach ($publications as $publication)
                <div class="single-item col-lg-4 col-md-6">
                    @include('partials.publication_one')
                </div>
                @endforeach
            </div>
        </div>

        @if($links)
            {!! $links !!}
        @endif
    </div>
</div>


@endsection
