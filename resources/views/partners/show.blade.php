@extends('layouts.app')

@section('seo_title', $partner->getTranslatedAttribute('seo_title') ?: $partner->getTranslatedAttribute('name'))
@section('meta_description', $partner->getTranslatedAttribute('meta_description'))
@section('meta_keywords', $partner->getTranslatedAttribute('meta_keywords'))

@section('content')
@include('partials.page_top', ['title' => $partner->getTranslatedAttribute('name')])

<div class="py-5">
    <div class="container">
        <div class="text-block">
            {!! $partner->getTranslatedAttribute('body') !!}
        </div>
    </div>
</div>

@endsection
