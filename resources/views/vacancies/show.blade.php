@extends('layouts.app')

@section('seo_title', $vacancy->getTranslatedAttribute('seo_title') ?: $vacancy->getTranslatedAttribute('name'))
@section('meta_description', $vacancy->getTranslatedAttribute('meta_description'))
@section('meta_keywords', $vacancy->getTranslatedAttribute('meta_keywords'))

@section('content')

@include('partials.page_top', ['title' => $vacancy->getTranslatedAttribute('name')])

<div class="py-5">
    <div class="container">
        <div class="text-block">
            {!! $vacancy->getTranslatedAttribute('body') !!}
        </div>
    </div>
</div>

@endsection
