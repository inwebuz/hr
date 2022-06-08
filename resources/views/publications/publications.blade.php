@extends('layouts.app')

@section('seo_title', $page->getTranslatedAttribute('seo_title') ?: $page->getTranslatedAttribute('name'))
@section('meta_description', $page->getTranslatedAttribute('meta_description'))
@section('meta_keywords', $page->getTranslatedAttribute('meta_keywords'))

@section('content')

<main class="main">

    <section class="content-header">
        <div class="container">
            @include('partials.breadcrumbs')
        </div>
    </section>

	<div class="container py-4 py-lg-5">
        <h1>{{ $page->getTranslatedAttribute('name') }}</h1>

        <div class="row news-wrap">
            @foreach ($publications as $publication)
            <div class="col-lg-4 col-md-6 news-item__parent">
                @include('partials.publication_one')
            </div>
            @endforeach
        </div>

        <div class="mt-4">
            {!! $links !!}
        </div>
    </div>
</main>

@endsection
