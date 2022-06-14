@extends('layouts.app')

@section('seo_title', $page->getTranslatedAttribute('seo_title') ?: $page->getTranslatedAttribute('name'))
@section('meta_description', $page->getTranslatedAttribute('meta_description'))
@section('meta_keywords', $page->getTranslatedAttribute('meta_keywords'))

@section('content')

@include('partials.page_top', ['title' => $page->getTranslatedAttribute('name')])

<!-- Start Career
============================================= -->
<div class="earna-career py-5">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <ul class="job-list">
                    <li>
                        <div class="fun-fact">
                            <div class="counter">
                                <div class="timer" data-to="{{ $vacancyCategories->count() }}" data-speed="3000">{{ $vacancyCategories->count() }}</div>
                                <div class="operator"></div>
                            </div>
                            <span class="medium">{{ __('main.categories') }}</span>
                        </div>
                    </li>
                    <li>
                        <div class="fun-fact">
                            <div class="counter">
                                <div class="timer" data-to="{{ $vacanciesQuantity }}" data-speed="3000">{{ $vacanciesQuantity }}</div>
                                <div class="operator">+</div>
                            </div>
                            <span class="medium">{{ __('main.vacancies') }}</span>
                        </div>
                    </li>
                </ul>
            </div>
        </div>

        <div class="job-lists">
            @foreach ($vacancyCategories as $vacancyCategory)
                <div class="item">
                    <div class="info">
                        <h4>
                            <a href="{{ $vacancyCategory->url }}">{{ $vacancyCategory->getTranslatedAttribute('name') }}</a>
                        </h4>
                        <ul>
                            <li>{{ __('main.vacancies') }}: {{ $vacancyCategory->vacancies->count() }}</li>
                        </ul>
                    </div>
                    <div class="button">
                        <a class="btn btn-primary effect btn-md" href="{{ $vacancyCategory->url }}">{{ __('main.view_more') }}</a>
                    </div>
                </div>
            @endforeach
        </div>

    </div>
</div>
<!-- End Career -->

@endsection
