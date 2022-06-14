@extends('layouts.app')

@section('seo_title', $page->getTranslatedAttribute('seo_title') ?: $page->getTranslatedAttribute('name'))
@section('meta_description', $page->getTranslatedAttribute('meta_description'))
@section('meta_keywords', $page->getTranslatedAttribute('meta_keywords'))

@section('content')

@include('partials.page_top', ['title' => $page->getTranslatedAttribute('name')])


<div class="py-5">
    @if ($page->id == 8)
        <div class="container mt-4 font-weight-bold">
            <div class="row">
                <div class="col-lg-4 mb-4">
                    <a href="{{ route('news') }}" class="d-block p-4 border rounded-lg bg-light">{{ __('main.news') }}</a>
                </div>
                <div class="col-lg-4 mb-4">
                    <a href="{{ route('gallery') }}" class="d-block p-4 border rounded-lg bg-light">{{ __('main.gallery') }}</a>
                </div>
            </div>
        </div>
    @elseif ($page->id == 11)
        <div class="container font-weight-bold mt-4">
            <div class="row">
                <div class="col-lg-4 mb-4">
                    <a href="{{ route('vacancies.index') }}" class="d-block p-4 border rounded-lg bg-light">{{ __('main.vacancies') }}</a>
                </div>
                <div class="col-lg-4 mb-4">
                    <a href="{{ route('cvs.index') }}" class="d-block p-4 border rounded-lg bg-light">{{ __('main.cv') }}</a>
                </div>
                <div class="col-lg-4 mb-4">
                    <a href="{{ route('contacts') }}" class="d-block p-4 border rounded-lg bg-light">{{ __('main.nav.contacts') }}</a>
                </div>
            </div>
        </div>
    @endif
    <div class="container">
        <div class="text-block">
            {!! $page->body !!}
        </div>
    </div>

</div>

@if ($page->id == 3)
    <x-principles></x-principles>
@endif

@can('edit', $page)
    <div class="container">
        <div class="my-4">
            <a href="{{ url('admin/pages/' . $page->id . '/edit') }}" class="btn btn-lg btn-primary"
                target="_blank">Редактировать (ID: {{ $page->id }})</a>
        </div>
    </div>
@endcan

<x-reviews></x-reviews>

<x-partners></x-partners>

@endsection
