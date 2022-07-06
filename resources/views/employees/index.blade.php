@extends('layouts.app')

@section('seo_title', $page->getTranslatedAttribute('seo_title') ?: $page->getTranslatedAttribute('name'))
@section('meta_description', $page->getTranslatedAttribute('meta_description'))
@section('meta_keywords', $page->getTranslatedAttribute('meta_keywords'))

@section('content')

@include('partials.page_top', ['title' => $page->getTranslatedAttribute('name'), 'description' => $page->getTranslatedAttribute('description')])

<!-- Start Team Area
============================================= -->
<div class="team-area py-5">
    <div class="container">
        <div class="team-items text-center">
            <div class="row">
                @foreach ($employees as $employee)
                <div class="single-item col-lg-4 col-md-6">
                    @include('partials.employee_one')
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
<!-- End Team Area -->

@endsection
