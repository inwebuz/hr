@extends('layouts.app')

@section('seo_title', $page->getTranslatedAttribute('seo_title') ?: $page->getTranslatedAttribute('name'))
@section('meta_description', $page->getTranslatedAttribute('meta_description'))
@section('meta_keywords', $page->getTranslatedAttribute('meta_keywords'))

@section('content')

@include('partials.page_top', ['title' => $page->getTranslatedAttribute('name')])

<div class="py-5">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 offset-lg-2">
                @include('partials.cv_form')
            </div>
        </div>
    </div>
</div>

@endsection
