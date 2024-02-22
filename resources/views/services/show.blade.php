@extends('layouts.app')

@section('seo_title', $service->getTranslatedAttribute('seo_title') ?: $service->getTranslatedAttribute('name'))
@section('meta_description', $service->getTranslatedAttribute('meta_description'))
@section('meta_keywords', $service->getTranslatedAttribute('meta_keywords'))

@section('content')

@include('partials.page_top', ['title' => $service->getTranslatedAttribute('name')])

<div class="py-5">
    <div class="container">
        <div class="text-block">
            {!! $service->getTranslatedAttribute('body') !!}
        </div>
    </div>
</div>

@endsection
