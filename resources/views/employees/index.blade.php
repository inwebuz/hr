@extends('layouts.app')

@section('seo_title', $page->getTranslatedAttribute('seo_title') ?: $page->getTranslatedAttribute('name'))
@section('meta_description', $page->getTranslatedAttribute('meta_description'))
@section('meta_keywords', $page->getTranslatedAttribute('meta_keywords'))

@section('content')

@include('partials.page_top', ['title' => $page->getTranslatedAttribute('name')])

<!-- Star Team Area
============================================= -->
<div class="team-area py-5">
    <div class="container">
        <div class="team-items text-center">
            <div class="row">
                @foreach ($employees as $employee)
                <div class="single-item col-lg-4 col-md-6">
                    <div class="item">
                        <div class="thumb">
                            <a href="{{ $employee->url }}" class="d-block">
                                <img src="{{ $employee->medium_img }}" alt="{{ $employee->full_name }}" class="img-fluid rounded-circle">
                            </a>
                        </div>
                        <div class="info">
                            <div class="content">
                                <h4><a href="{{ $employee->url }}" class="text-secondary">{{ $employee->full_name }}</a></h4>
                                <span class="text-green2">{{ $employee->getTranslatedAttribute('position') }}</span>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
<!-- End Team Area -->

@endsection
